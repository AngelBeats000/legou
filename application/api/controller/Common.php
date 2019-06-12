<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-16 18:21:51
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-20 20:12:58
 */
namespace app\api\controller;
use think\Controller;
use think\Db;
class Common extends Controller
{
    // 外部接口
    // 验证登录对比小程序发送过来的openid和服务器获取到的openid是否相同
	public function check_openid(){
		$appid=config('appid');
		$secret=config('secret');
		$grant_type=config('grant_type');
		$openid=input('openid');
		$js_code=input('code');
		// $url='https://api.weixin.qq.com/sns/jscode2session';
		// $data=[
		// 	'appid'=>$appid,
		// 	'secret'=>$secret,
		// 	'js_code'=>$js_code,
		// 	'grant_type'=>$grant_type
		// ];
		// $res=httpRequest($url,'POST',$data);
		$url="https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$secret."&js_code=".$js_code."&grant_type=authorization_code";
		$res=file_get_contents($url);
		$obj=json_decode($res,true);
		// dump($res);return true;
		if($obj['openid'] == $openid){
			return true;
		}else{
			return false;
		}
	}


	public function restToken($openid){
		$data['token']=getRandChar(32);
		$data['token_time']=time();
		$res=Db::name('user')->where('openid',$openid)->update($data);
		if($res){
			return $data['token'];
		}else{
			return false;
		}
	}

	// 验证token的有效期
	public function check_token(){
		$openid=input('openid');
		$token=input('token');
		$user=db('user')->where(['openid'=>$openid,'token'=>$token])->find();
		if($user){
			if((time()-$user['token_time'])>7200){
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}
	}

	// 获取用户id
	public function getUserId($openid){
		$user=db('user')->where('openid',$openid)->field('id')->find();
		return $user['id'];
	}
	
}
