<?php
namespace Api\Controller;
use Think\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 10:15
 */
class LiulongController extends Controller {

    public $token = 'liulong';

    public $wechatObject = null;

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
        //require_once APP_PATH  . "/Common/Vendor/Wechat.php";

        $options = array(
            'token'=> $this->token,
            'encodingaeskey'=> '', //填写加密用的EncodingAESKey
            'appid'=>'wx161846f8d8fd7ad4', //填写高级调用功能的app id, 请在微信开发模式后台查询
            'appsecret'=>'b39d396e1555ccba108c03dcd2f2c55e' //填写高级调用功能的密钥s
        );
        $this->wechatObject = new \Wechat($options);
    }

    public function index() {
        if (IS_GET) {
            //签名验证
            $this->wechatObject->valid();
        } else {
            $this->response();
        }
    }

    public function home() {
        //知乎首页
    }

    /**
     * 创建菜单
     */
    public function menu_create() {
        //创建菜单
        $menu_data = array(
            'button' => array(
                array(
                    'type' => 'click',
                    'name' => '知乎日报',
                    'key' => 'KEY_TOP_STORIES'
                ),
                array(
                    'type' => 'view',
                    'name' => '知乎首页',
                    'url' => U("api/liulong/home", null, false, true)
                ),
                array(
                    'name' => '功能接口',
                    'sub_button' => array(
                        array(
                            'type' => 'view',
                            'name' => '微信支付',
                            'url' => 'http://120.26.220.61/phpgroup/wxpay/index.php'
                        ),
                        array(
                            'type' => 'pic_sysphoto',
                            'name' => '自拍',
                            'key' => 'KEY_SYSPHOTO'
                        )
                    )
                )
            )
        );

        $bool = $this->wechatObject->createMenu($menu_data);
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
        $bool = $this->wechatObject->deleteMenu();
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

        //处理消息
        $object = $this->wechatObject->getRev();
        //获取消息类型
        $msgType = $object->getRevType();
        if ($msgType == \Wechat::MSGTYPE_EVENT) {
            $event = $object->getRevEvent();
            if ($event['event'] == \Wechat::EVENT_SUBSCRIBE) {
                //监听关注事件
                //拉取用户信息
                //$user_open_id = $object->getRevFrom();
                //$user_info = $object->getUserInfo($user_open_id);
                //保存到数据库
                /*
                $db = M("wxuser");
                $user_data = array(
                    'openid' => $user_info['openid'],
                    'nickname' => $user_info['nickname'],
                    'sex' => $user_info['sex'],
                    'language' => $user_info['language'],
                    'province' => $user_info['province'],
                    'city' => $user_info['city'],
                    'country' => $user_info['country'],
                    'headimgurl' => $user_info['headimgurl'],
                    'subscribe' => $user_info['subscribe'],
                    'subscribe_time' => $user_info['subscribe_time'],
                    'createtime' => time(),
                    'token' => $this->token
                );
                $db->data($user_data)->add();
                */




                //$nick_name = $user_info['nickname'];
                //$sex = $user_info['sex'];

                //回复消息
                //$message = "您好：$nick_name;感谢关注XXXXX";
                //$message = "你好";
                //$object->text($message)->reply();

                $zh_latest_news_url = "http://news-at.zhihu.com/api/4/news/latest";
                $data = $this->httpGet($zh_latest_news_url);
                $data_array = json_decode($data, true);
                $top_stories = $data_array['top_stories'];
                $messages = array();
                foreach ($top_stories as $story) {
                    $messages[] = array(
                        'Title' => $story['title'],
                        'Description' => $story['title'],
                        'PicUrl' => $story['image'],
                        'Url' => U("api/liulong/story", array("id"=>$story['id']), false, true)
                    );
                }

                $object->news($messages)->reply();

            } elseif ($event['event'] == \Wechat::EVENT_MENU_CLICK ) {
                $key = $event['key'];
                if ($key == "KEY_TOP_STORIES") {
                    $zh_latest_news_url = "http://news-at.zhihu.com/api/4/news/latest";
                    $data = $this->httpGet($zh_latest_news_url);
                    $data_array = json_decode($data, true);
                    $top_stories = $data_array['stories'];
                    $messages = array();
                    foreach ($top_stories as $story) {
                        $messages[] = array(
                            'Title' => $story['title'],
                            'Description' => $story['title'],
                            'PicUrl' => $story['images'][0],
                            'Url' => U("api/liulong/story", array("id"=>$story['id']), false, true)
                        );
                    }

                    $object->news($messages)->reply();
                }
            }
        }

    }

    public function story() {
        $id = $_GET['id'];
        $url = "http://news-at.zhihu.com/api/4/news/" . $id;
        $story = $this->httpGet($url);
        $array = json_decode($story, true);
        $body = $array['body'];
        $title = $array['title'];
        $this->assign("title", $title);
        $this->assign("body", $body);

        $this->display();
    }


    public function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }


}