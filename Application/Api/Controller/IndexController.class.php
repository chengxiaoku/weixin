<?php
namespace Api\Controller;
use Think\Controller;
class IndexController extends Controller {
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

        $options = array(
            'token'=> $this->token,
            'encodingaeskey'=> '', //填写加密用的EncodingAESKey
            'appid'=>'wxe459fc6738158329', //填写高级调用功能的app id, 请在微信开发模式后台查询
            'appsecret'=>'37164bc3144687d765753f5fe6c7071c' //填写高级调用功能的密钥s
        );

    }

    public function index()
    {define("TOKEN", "clf");

        $wechatObj = new wechatCallbackapiTest();
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method == "GET") {
            //验证
            $wechatObj->valid();
        } else {
            //处理消息
            $wechatObj->responseMsg();
        }
    }
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    /*public function createMenu(){
        $data = '{
     "button":[
     {
          "type":"view",
          "name":"首页",
          "url":"http://www.fastt.cn/"
      },
      {
           "name":"菜单",
           "sub_button":[
           {
               "type":"view",
               "name":"音乐",
               "url":"http://y.qq.com/"
            },
            {
               "type":"view",
               "name":"视频",
               "url":"http://v.qq.com/"
            },
            {
               "type":"view",
               "name":"搜索",
               "url":"http://baidu.com/"
            }]
       }]
 }';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".ACCESS_TOKEN);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $tmpInfo;
    }*/

//获取菜单
    public function getMenu(){
        return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".ACCESS_TOKEN);
    }

//删除菜单
    public function deleteMenu(){
        return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".ACCESS_TOKEN);
    }



    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        //extract post data
        if (!empty($postStr)){
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);

            $msgType = $postObj->MsgType;
            $msgTpl = '';

            if ($msgType == 'text') {
                $msgTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
                $time = time();
                if (!empty($keyword)) {
                    $msgType = "text";
                    $contentStr = "欢迎来到Geek世界!";
                    $resultStr = sprintf($msgTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                } elseif ($keyword == "电影") {
                    //回复图文消息
                    $toUserName = $postObj->FromUserName;
                    $fromUserName = $postObj->ToUserName;
                    $time = time();
                    $msgTpl = "<xml>
                                <ToUserName><![CDATA[$toUserName]]></ToUserName>
                                <FromUserName><![CDATA[$fromUserName]]></FromUserName>
                                <CreateTime>$time</CreateTime>
                                <MsgType><![CDATA[news]]></MsgType>
                                <ArticleCount>2</ArticleCount>
                                <Articles>
                                    <item>
                                    <Title><![CDATA[《附属美丽》新照全明星阵容耀眼]]></Title> 
                                    <Description><![CDATA['这是电影描述']]></Description>
                                    <PicUrl><![CDATA[http://img5.mtime.cn/mg/2016/12/01/082240.56959562.jpg]]></PicUrl>
                                    <Url><![CDATA[http://baidu.com]]></Url>
                                    </item>
                                    
                                    <item>
                                    <Title><![CDATA[首部曲飞船现身《异形：契约》]]></Title>
                                    <Description><![CDATA[描述]]></Description>
                                    <PicUrl><![CDATA[http://img5.mtime.cn/mg/2016/12/01/074038.36333901.jpg]]></PicUrl>
                                    <Url><![CDATA[http://www.mtime.com]]></Url>
                                    </item>
                                </Articles>
                                </xml>";
                    echo $msgTpl;
                }

            } elseif ($msgType == 'image') {
                $picUrl = $postObj->PicUrl;
                $mediaId = $postObj->mediaId;
                $msgTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
                $time = time();
                $msgType = "text";
                $contentStr = $picUrl;
                $resultStr = sprintf($msgTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            } elseif ($msgType == 'event') {
                //处理事件
                $event_name = $postObj->Event;
                switch ($event_name) {
                    case 'subscribe' :
                        //拉去用户信息
                        $user_open_id = $fromUsername;
                        //第一步：获取访问凭证access_token
                        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxe459fc6738158329&secret=37164bc3144687d765753f5fe6c7071c";
                        //CURL
                        $access_token = session('access_token');
                        if (empty($access_token)) {
                            $json = $this->httpGet($url);
                            $arr = json_decode($json, true);
                            $access_token = $arr['access_token'];
                            session('access_token',$access_token);
                        }
                        //第二部：拉取用户信息
                        $user_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$user_open_id&lang=zh_CN";
                        $user = $this->httpGet($user_url);
                        $user_arr = json_decode($user, true);
                        if (empty($user_arr)) {
                            $json = $this->httpGet($url);
                            $arr = json_decode($json, true);
                            $access_token = $arr['access_token'];
                            session('access_token',$access_token);
                            $user_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$user_open_id&lang=zh_CN";
                            $user = $this->httpGet($user_url);
                            $user_arr = json_decode($user, true);
                        }

                        $nickname = $user_arr['nickname'];

                        //回复问候消息
                        $msgTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";

                        $msgType = "text";
                        $time = time();
                        $contentStr = "你好:$nickname";
                        $resultStr = sprintf($msgTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;

                        break;
                    case 'unsubscribe' :
                        break;
                    case 'LOCATION' :
                        break;
                }

            }

        }else {
            echo "24123";
            exit;
        }
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

    private function checkSignature()
    {
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new \Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}
