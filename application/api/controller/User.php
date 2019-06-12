<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-16 18:23:37
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-19 20:49:29
 */
namespace app\api\controller;
use think\Controller;
use think\Db;
class User extends Common
{
    // 外部接口
	public function get_user(){
		if($this->check_openid()){
			$openid=input('openid');
			$data['nick_name']=input('nick_name');
			$data['head_src']=input('head_src');
			$user=db('user')->where('openid',$openid)->find();
			if($user){            //如果找到记录，表示以前登录过，则重置登录时间
				if($user['nick_name']==''&&$data['nick_name']){
					db('user')->where('openid',$openid)->update($data);
				}
				$user['token']=$this->restToken($openid);
				if($user['token']){
					return json_encode(['status'=>200,'msg'=>'登录成功','data'=>$user]);
				}else{
					return json_encode(['status'=>400,'msg'=>'token重置失败']);
				}
			}else{
				return json_encode(['status'=>400,'msg'=>'用户不存在']);
			}
		}else{
			return json_encode(['status'=>401,'msg'=>'登录失败,请重新授权']);
		}
	}


	// 注册
	public function register($openid){
		$data['openid']=$openid;
		$data['token']=getRandChar(32);
		$data['token_time']=time();
		$data['reg_time']=time();
		$user=db('user')->insert($data);
	}

	
}
