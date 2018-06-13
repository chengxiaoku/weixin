<?php
namespace Api\Controller;
use Think\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 10:15
 */
class ClfController extends Controller {

    public $token = 'clf';

    public $active = null;

    /**
     * 构造函数
     * LiulongController constructor.
     */
    public function __construct()
    {
        //调用父类构造函数
        parent::__construct();

        //引入第三方类文件
        import("Common.Vendor.Wechat", APP_PATH, '.php');

        $options = array(
            'token'=> $this->token,
            'encodingaeskey'=> '', //填写加密用的EncodingAESKey
            'appid'=>'wxe459fc6738158329', //填写高级调用功能的app id, 请在微信开发模式后台查询
            'appsecret'=>'37164bc3144687d765753f5fe6c7071c' //填写高级调用功能的密钥s
        );
        $this->active = new \Wechat($options);
    }

    public function index() {
        if (IS_GET) {
            //签名验证
            $this->active->valid();
        } else {
            $this->response();
        }
    }

    /**
     * 创建菜单
     */
    public function menu_create() {
        //创建菜单
        $menu_data = array(
            'button' => array(
                array(
                    'type' => 'view',
                    'name' => '女神直播',
                    'url' => 'http://zhibo.renren.com/home?c1=6173&c2=0001&c3=1&c4=6173&isFull=1'
                ),
                array(
                    'type' => 'click',
                    'name' => '开始聊天',
                    'key' => 'KEY_START'
                ),
                array(
                    'name' => '换人聊天',
                    'sub_button' => array(
                        /*array(
                            'type' => 'click',
                            'name' => '开始聊天',
                            'key' => 'KEY_START'
                        ),*/
                        array(
                            'type' => 'click',
                            'name' => '换人聊天',
                            'key' => 'KEY_CHANGE'
                        ),
                        array(
                            'type' => 'click',
                            'name' => '断开聊天',
                            'key' => 'KEY_OFF'
                        )
                    )
                )
            )
        );

        $bool = $this->active->createMenu($menu_data);
        if ($bool) {
            echo '菜单创建成功';
        } else {
            echo '菜单创建失败';
        }
    }

    /**
     * 删除菜单
     */
    public function menu_del() {
        $bool = $this->active->deleteMenu();
        if ($bool) {
            echo '菜单删除成功';
        } else {
            echo '菜单删除失败';
        }
    }

    /**
     * 响应消息
     */
    public function response() {

        //处理消息  被动对象
        $passive = $this->active->getRev();
        //获取消息类型
        $msgType = $passive->getRevType();
        if ($msgType == \Wechat::MSGTYPE_EVENT) {
            $event = $passive->getRevEvent();

            if ($event['event'] == \Wechat::EVENT_SUBSCRIBE) {
                //监听关注事件
                //拉取用户信息
                $user_open_id = $passive->getRevFrom();
                $user_info = $passive->getUserInfo($user_open_id);
                $user_data = array(
                    //openid用户的唯一标实
                    'openid' => $user_open_id,
                    //用户昵称
                    'nickname' => $user_info['nickname'],
                    //用户性别
                    'sex' => $user_info['sex'],
                    //用户语言
                    //'language' => $user_info['language'],
                    //用户国家
                    // 'country' => $user_info['country'],
                    //用户省份
                    'province' => $user_info['province'],
                    //用户所在城市
                    'city' => $user_info['city'],
                    //用户头像
                    //'headimgurl' => $user_info['headimgurl'],
                    //用户关注是否关注（0取消关注，1关注）
                    //'subscribe' => $user_info['subscribe'],
                    //用户关注时间
                    'subscribe_time' => $user_info['subscribe_time'],
                    //用户增添时间
                    'createtime' => time(),
                    //我的token
                    'token' => $this->token
                );
                $user_from_id = $passive->getRevFrom();
                //$this->active->text('数据入库')->reply();
                $this->active->sendMsgToAll($user_from_id,"约会陌生型男美女，看女神直播，为广大粉丝们搭建一个私密聊天的温馨小屋。");
                $test = M('test');
                $result = $test->where("openid='$user_open_id'")->find();
                //每个用户只允许入库一次
                if (empty($result)) {
                    $test->add($user_data);
                }

            } elseif ($event['event'] == \Wechat::EVENT_UNSUBSCRIBE) {
                //监听取消关注事件
                $user_from_id = $passive->getRevFrom();
                $sex = $this->active->getUserInfo($user_from_id)['sex'];
                $this->chang($user_from_id,$sex);
                $old_data = M('list')->field('user2_openid')->where("user1_openid = '$user_from_id'")->find();
                M('list')->where("user1_openid = '$user_from_id'")->delete();
                M('list')->where("user2_openid = '$user_from_id'")->save(['user2_openid'=>null,'create_time'=>time()]);

                //$this->active->text("咔哒...！ 你断开了电波，你们的连接已断开..你可以点击 [开始聊天] 继续搜索新的电波，寻找和你同频的那个人。")->reply();

                $this->active->sendMsgToAll($old_data['user2_openid'],"咔哒...！ 对方可能遇到了一点小麻烦，暂时断开了电波，你们的连接已断开..你可以点击 [开始聊天] 继续搜索新的电波，寻找和你同频的那个人。");


            } elseif ($event['event'] == \Wechat::EVENT_MENU_CLICK) {
                //监听菜单点击事件

                $test = M('test');
                $menu_key = $event['key'];
                $list = M('list');
                $user_from_id = $passive->getRevFrom();
                $sex = $this->active->getUserInfo($user_from_id)['sex'];
                switch ($sex){
                    case 1:
                        $info1 = '男生';
                        $info2 = '女神';
                        break;
                    case 2:
                        $info1 = '女生';
                        $info2 = '男神';
                        break;
                    case 0:
                        $info1 = '男生';
                        $info2 = '女神';
                        break;
                    default:
                        $info1 = '男生';
                        $info2 = '女神';
                        break;
                }

                if ($menu_key == 'KEY_HOTMOVIE') {

                    $message = $this->active->callHotmovie();
                    $this->active->text($message)->reply();

                } elseif ($menu_key == 'KEY_HOTMUSIC') {

                    $message = $this->active->callHotmusic();
                    $this->active->news($message)->reply();


                } elseif ($menu_key == 'KEY_EXPRESS') {
                    //快递查询
                    //$this->active->text_id('你好，Cc','oZSJ1wZJRES3nXO9Q-uxZoyZYxsU')->reply();;
                    $this->active->text("开发中...")->reply();

                } /*elseif ($menu_key == 'KEY_TRAINTICKET') {
                    //车票查询
                    //$url = U('Geek/ticket');

                    //$this->active->text("开发中...")->reply();

                }*/elseif ($menu_key == 'KEY_WEATHER') {
                    //天气查询
                    $this->active->text("请点击右上角开启【提供位置信息】功能")->reply();
                }elseif ($menu_key == 'KEY_START'){ //开始聊天
                    $this->get_list_user($user_from_id,$info1,$info2);
                    $this->active->sendMsgToAll($user_from_id,"[随机聊天] 匹配启动中，当前{$info1}较多，等待{$info2}翻牌，请耐心等待...");
                    //获取用户性别
                    $sex = $this->active->getUserInfo($user_from_id)['sex'];
                    $this->tpl($user_from_id,$sex);

                }elseif ($menu_key == 'KEY_CHANGE'){ //换人聊天
                    $sex = $this->active->getUserInfo($user_from_id)['sex'];
                    $this->chang($user_from_id,$sex);
                    $this->active->sendMsgToAll($user_from_id,"[随机聊天] 匹配启动中，当前{$info1}较多，等待{$info2}翻牌，请耐心等待...");
                    $old_data = M('list')->field('user2_openid')->where("user1_openid = '$user_from_id'")->find();
                    $this->active->sendMsgToAll($old_data['user2_openid'],"咔哒...！ 对方可能遇到了一点小麻烦，暂时断开了电波，你们的连接已断开..你可以点击 [开始聊天] 继续搜索新的电波，寻找和你同频的那个人。");

                    M('list')->where("user1_openid = '$user_from_id'")->delete();
                    M('list')->where("user2_openid = '$user_from_id'")->save(['user2_openid'=>null,'create_time'=>time()]);
                    $this->tpl($user_from_id,$sex);

                }elseif ($menu_key == 'KEY_OFF'){ //断开聊天
                    $sex = $this->active->getUserInfo($user_from_id)['sex'];
                    $this->chang($user_from_id,$sex);
                    $this->active->text("咔哒...！ 你断开了电波，你们的连接已断开..你可以点击 [开始聊天] 继续搜索新的电波，寻找和你同频的那个人。")->reply();
                    $old_data = M('list')->field('user2_openid')->where("user1_openid = '$user_from_id'")->find();
                    $this->active->sendMsgToAll($old_data['user2_openid'],"咔哒...！ 对方可能遇到了一点小麻烦，暂时断开了电波，你们的连接已断开..你可以点击 [开始聊天] 继续搜索新的电波，寻找和你同频的那个人。");
                    M('list')->where("user1_openid = '$user_from_id'")->delete();
                    M('list')->where("user2_openid = '$user_from_id'")->save(['user2_openid'=>null,'create_time'=>time()]);
                }

            } elseif ($event['event'] == \Wechat::EVENT_LOCATION) {
                $user_open_id = $passive->getRevFrom();

                $location = $passive->getRevEventGeo();
                $lat = $location['x'];
                $lng = $location['y'];
                $weather_msg = $this->active->callWeather($lat, $lng);
                if (!empty($weather_msg)) {
                    M('user')->where("openid = '$user_open_id'")->save(array('weather'=>$weather_msg));
                }
                //$this->active->text("$weather2")->reply();
            }
        } elseif ($msgType == \Wechat::MSGTYPE_TEXT) {
            //消息发送方
            $user_from_id = $passive->getRevFrom();

            $data = M('list')->field('user2_openid')->where("user1_openid = '$user_from_id'")->find();
            if(empty($data)){
               
                exit;
            }else{
                //向指定的用户发送内容
                $this->active->sendMsgToAll($data['user2_openid'],$passive->getRevContent());

            }
            //以前版本 获取图灵机器人消息
            // $contentStr = $this->active->callTuling($message,$user_from_id);
            // $this->active->text($contentStr)->reply();
            //接收音乐
        } elseif ($msgType == \Wechat::MSGTYPE_VOICE){
             //开启语音功能之后  去掉本行
            $user_from_id = $passive->getRevFrom();
            $data = M('list')->field('user2_openid')->where("user1_openid = '$user_from_id'")->find();
            if(empty($data)){
                exit;
            }else{
                //获取发来语音的ID
                $musicid = $this->active->getRevVoice()['mediaid'];
                $this->active->send_voice($data['user2_openid'], $musicid);
            }
        }



    }
    function tpl($user_from_id,$sex){
        //查询是否有匹配的人
        $list = M('list');
        $sql = "SELECT * FROM list WHERE user1_sex != '{$sex}' AND user2_openid is null ORDER BY `create_time` ASC LIMIT 1";
        $data = $list->query($sql);
        if(is_null($data) || empty($data)){
            //进入绑定队列
            $list->add(['user1_openid'=>$user_from_id,'user1_sex'=>$sex,'create_time'=>time()]);

        }else{
            $old_user = $data[0];

            $new_user = $user_from_id;
            //绑定成功
            $list->where("user1_openid = '{$old_user['user1_openid']}'")->save(['user2_openid'=>$new_user]);
            $list->add(['user1_openid'=>$new_user,'user1_sex'=>$this->active->getUserInfo($new_user)['sex'],'user2_openid'=>$old_user['user1_openid'],'create_time'=>time()]);
            //双方进行通知
            function str($sex,$address){
                return "已连接到一个相同频率的电波\r\n性别：{$sex}\r\n地区：{$address}\r\n官方提醒:聊天过程中，请勿随意添加陌生人为好友，以防上当受骗。";
            }
            //给新来用户发老用户的信息
            $old_user_data = $this->active->getUserInfo($old_user['user1_openid']);
            function get_str_sex($str){
                switch ($str){
                    case 1:
                        $old_user_sex = '男';
                        break;
                    case 2:
                        $old_user_sex = '女';
                        break;
                    case 0:
                        $old_user_sex = '未知';
                        break;
                    default:
                        $old_user_sex = '女';
                        break;
                }
                return $old_user_sex;
            }
            //地址省市
            $adress = $old_user_data['province'].$old_user_data['city'];
            $this->active->sendMsgToAll($new_user,str(get_str_sex($old_user_data['sex']),$adress));
            $this->active->sendMsgToAll($new_user,'你在干嘛?');

            //给老的用户发新用户信息
            $old_user = $old_user['user1_openid'];
            $new_user_data = $this->active->getUserInfo($new_user);
            $adress = $new_user_data['province'].$new_user_data['city'];
            $this->active->sendMsgToAll($old_user,str(get_str_sex($new_user_data['sex']),$adress));
            $this->active->sendMsgToAll($old_user,'你在干嘛？');
        }
    }
    /**
     * 判断是否曾经点击过开始聊天
     */
    private function get_list_user($userid,$info1,$info2){

        //正在列队中
        if(M('list')->where("user1_openid = '$userid' and user2_openid is null")->find()){
            $this->active->sendMsgToAll($userid,"[随机聊天] 匹配启动中，当前{$info1}较多，等待{$info2}翻牌，请耐心等待...");
            exit;

        } //正在聊天中。
        if(M('list')->where("user1_openid = '$userid' ")->find() && M('list')->where("user2_openid = '$userid' ")->find()){
            $this->active->sendMsgToAll($userid,'哔滋哔滋~你当前已经连接了一个相同频率的电波，无需重新连接...');
            exit;

        }
    }

    /**
     * 换人聊天 判断是否可以更换
     */
    function chang($userid,$sex){
        switch ($sex){
            case 1:
                $user_sex = '女';
                break;
            case 2:
                $user_sex = '男';
                break;
            case 0:
                $user_sex = '女';
                break;
            default:
                $user_sex = '女';
                break;
        }
        if(!M('list')->where("user1_openid = '$userid'")->find()){
            $this->active->sendMsgToAll($userid,"请点击 [开始聊天] 等待{$user_sex}神翻牌...");
            exit;
        }
    }
    /**
     * @return mixed
     */
    public function uploadMedia() {
        $imgurl = array(
            'media' => '@./image/thumb.jpg'
        );
        $imgtype = 'thumb';
        $upload = $this->active->uploadMedia($imgurl, $imgtype);
        $media_id = $upload['thumb_media_id'];
        return $media_id;
    }

    public function zhihu() {
        /*$url = "http://api.kanzhihu.com/getposts";
        $data = $this->active->httpGet($url);
        $data_array = json_decode($data, true);
        $top_stories = $data_array['stories'];*/
        $data = $this->active->callScience();
        $this->assign("data",$data);
        $this->display();
    }
    public function zhihu_details() {
        $id = $_GET['id'];
        $url = "http://news-at.zhihu.com/api/4/news/" . $id;
        $story = $this->active->httpGet($url);
        $array = json_decode($story, true);
        $body = $array['body'];
        $title = $array['title'];
        $this->assign("title", $title);
        $this->assign("body", $body);

        $this->display();
    }

    public function ticket() {
        $this->display();
    }
    public function ticket_details() {
        if (IS_POST) {
            $originating = I('post.originating');
            $terminal = I('post.terminal');

            $time = str_replace('/', '-',I('post.time'));

            if (empty($time)) {
                $time = date("Y-m-d",strtotime("+1 day"));
            }
            $data = $this->active->callTicket($originating, $terminal,$time);

            $this->assign("data",$data['list']);
        }
        $this->display();
    }

    public function story() {
        $id = $_GET['id'];
        $url = "http://news-at.zhihu.com/api/4/news/" . $id;
        $story = $this->active->httpGet($url);
        $array = json_decode($story, true);
        $body = $array['body'];
        $title = $array['title'];
        $this->assign("title", $title);
        $this->assign("body", $body);

        $this->display();
    }
    function pp(){

/*
        $test = new \SendAllMsg("wxe459fc6738158329","37164bc3144687d765753f5fe6c7071c");

            $info = $test->sendMsgToall();
            dump($info);
*/
        /**
         * 根据openid 获取用户信息
         */
        /*
                $data = $this->active->sendMsgToAll('oGPSv1XdGgpVru7Zsn-1n1mmdAVU','[随机聊天] 匹配启动中，当前男生较多，等待女神翻牌，请耐心等待...');
                dump($data);
        */

    }
}

