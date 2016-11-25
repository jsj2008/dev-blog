<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $token = 'weixin';
        $signature = $_GET['signature'];
        $array = array($timestamp,$nonce,$token);
        sort($array);
        $tmpstr = sha1(implode('', $array));
        if ($tmpstr == $signature && $echostr) {
        	echo $_GET['echostr'];
        	exit;
        } else {
        	$this->responseMsg();
        }
    }

    public function responseMsg() {
    	$postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
    	$postObj = simplexml_load_string($postArr);
    	if (strtolower($postObj->MsgType) == 'event') {
    		if (strtolower($postObj->Event) == 'subscribe') {
    			$toUser = $postObj->FromUserName;
    			$fromUser = $postObj->toUserName;
    			$time = time();
    			$msgType = 'text';
    			$content = "welcome to follow my subscribe";
    			$template = "<xml>
				           <ToUserName><![CDATA[%s]]></ToUserName>
				           <FromUserName><![CDATA[%s]]></FromUserName>
				           <CreateTime>%s</CreateTime>
				           <MsgType><![CDATA[%s]]></MsgType>
				           <Content><![CDATA[%s]]></Content>
				           </xml>";
				$info = sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
				echo $info;
    		}
    	}
    }
}