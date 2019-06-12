<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-22 15:39:30
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-22 21:23:11
 */
namespace app\api\controller;
use think\Controller;
use think\Db;
class Address extends Common
{
    // 得到收货地址
	public function getAddress(){
		if($this->check_token()){
			$openid=input('openid');
			$user_id=$this->getUserId($openid);
			if($user_id){
				$addressRes=Db::name('address')->where('user_id',$user_id)->select();
				if($addressRes){
					return json_encode(['status'=>true,'data'=>$addressRes]);
				}else{
					return json_encode(['status'=>true,'data'=>[]]);
				}
			}else{
				return json_encode(['status'=>false,'msg'=>'请重新登录']);
			}
		}else{
			return json_encode(['status'=>false,'msg'=>'请重新登录']);
		}
	}


	//添加收货地址
	public function add(){
		if($this->check_token()){
			$openid=input('openid');
			$user_id=$this->getUserId($openid);
			if($user_id){
				$data=[
					'user_id'=>$user_id,
					'address_name'=>input('address_name'),
					'phone'=>input('phone'),
					'address'=>input('address')
				];
				Db::name('address')->insert($data);
			}else{
				return json_encode(['status'=>false,'msg'=>'请重新登录']);
			}
		}else{
			return json_encode(['status'=>false,'msg'=>'请重新登录']);
		}
	}

	//删除收货地址
	public function delAddress(){
		if($this->check_token()){
			$openid=input('openid');
			$user_id=$this->getUserId($openid);
			if($user_id){
				$id=input('addressId');
				Db::name('address')->delete($id);
			}else{
				return json_encode(['status'=>false,'msg'=>'请重新登录']);
			}
		}else{
			return json_encode(['status'=>false,'msg'=>'请重新登录']);
		}
	}

	//删除的地址为默认收货地址时,自动选择默认收货地址
	public function defaultAddress(){
		$openid=input('openid');
		$user_id=$this->getUserId($openid);
		$address=Db::name('address')->where('user_id',$user_id)->field('id')->limit(1)->find();
		Db::name('address')->where('id',$address['id'])->update(['deafult'=>1]);
	}

	//修改默认收货地址
	public function setDeafult(){
		if($this->check_token()){
			$openid=input('openid');
			$user_id=$this->getUserId($openid);
			if($user_id){
				$id=input('id');
				Db::name('address')->where('user_id',$user_id)->update(['deafult'=>0]);
				Db::name('address')->where('id',$id)->update(['deafult'=>1]);
			}else{
				return json_encode(['status'=>false,'msg'=>'请重新登录']);
			}
		}else{
			return json_encode(['status'=>false,'msg'=>'请重新登录']);
		}
	}
	
	//修改收货地址是要修改的信息
	public function getEdit(){
		if($this->check_token()){
			$openid=input('openid');
			$user_id=$this->getUserId($openid);
			if($user_id){
				$id=input('id');
				$addressRes=Db::name('address')->find($id);
				return json_encode(['status'=>true,'data'=>$addressRes]);
			}else{
				return json_encode(['status'=>false,'msg'=>'请重新登录']);
			}
		}else{
			return json_encode(['status'=>false,'msg'=>'请重新登录']);
		}
	}

	//修改操作
	public function edit(){
		if($this->check_token()){
			$openid=input('openid');
			$user_id=$this->getUserId($openid);
			if($user_id){
				$id=input('id');
				$data=[
					'user_id'=>$user_id,
					'address_name'=>input('address_name'),
					'phone'=>input('phone'),
					'address'=>input('address')
				];
				$edit=Db::name('address')->where('id',$id)->update($data);
				if($edit!==false){
					return json_encode(['status'=>true]);
				}else{
					return json_encode(['status'=>false,'msg'=>'修改失败']);
				}
				
			}else{
				return json_encode(['status'=>false,'msg'=>'请重新登录']);
			}
		}else{
			return json_encode(['status'=>false,'msg'=>'请重新登录']);
		}
	}

	//判断是否有收货地址
	 public function deafultAddress(){
        if($this->check_token()){
            $openid = input('openid'); 
            $uid = $this->getUserId($openid);
            if($uid){
                $count = db('address')->where('user_id',$uid)->where('deafult', 1)->count();
                if($count){
                    return json(['code'=>200, 'msg'=>'跳转到订单提交']);
                }else{
                    return json(['code'=>401, 'msg'=>'跳转到地址添加']);
                }
                
            }else{
                return json(['code'=>400, 'msg'=>'重新登录']);
            }
        }else{
            return json(['code'=>400, 'msg'=>'重新登录']);
        }
    }

}

