<?php
/**
 * Created by PhpStorm.
 * User: 程龙飞
 * Date: 2018/5/21
 * Time: 15:22
 */
class SendAllMsg {
    private $appId;
    private $appSecret;
    private $access_token;
    //
    public function __construct($appId, $appSecret) {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->access_token = $this->getAccessToken();
    }
    //
    function getData($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    //
    function postData($url,$data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
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
    }

    function getAccessToken(){
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appId."&secret=".$this->appSecret;
        $res = $this->getData($url);
        $jres = json_decode($res,true);
        $access_token = $jres['access_token'];
        return $access_token;
    }
    //
    /*
    private function getUserInfo(){
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->access_token;
        $res = $this->getData($url);
        $jres = json_decode($res,true);
        //print_r($jres);
        $userInfoList = $jres['data']['openid'];
        return $userInfoList;
    }*/
    function sendMsgToAll(){
        //$userInfoList = $this->getUserInfo();
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$this->access_token;
        //foreach($userInfoList as $val){
        $data = '{
              "touser":"oZSJ1wZJRES3nXO9Q-uxZoyZYxsU",
              "msgtype":"text",
              "text":
              {
                "content":"测试一下，抱歉打扰各位"
              }
            }';
        $this->postData($url,$data);
        //}
    }
}