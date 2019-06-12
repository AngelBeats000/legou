<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-20 21:23:35
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-23 19:13:36
 */

namespace app\api\controller;
use think\Controller;
use think\Db;
use app\api\model\Goods;
class Cart extends Common
{

	// 购物车列表
	public function cartList(){
		if($this->check_token()){
			$openid=input('openid');
			$user_id=$this->getUserId($openid);
			if($user_id){
				$cartList=Db::name('cart')->field('id,goods_id,user_id,goods_num,selected')->where('user_id',$user_id)->select();
				if($cartList){
					foreach ($cartList as $k => $v) {
						$cartInfo=model('goods')->field('thumb,shop_price,goods_name,id,stock_num')->find($v['goods_id']);
						$cartInfo=$cartInfo->toArray();
						$cartList[$k]=array_merge($cartInfo,$v);
					}
					return json_encode(['status'=>true,'data'=>$cartList]);
				}else{
					return json_encode(['status'=>false,'msg'=>'购物车为空']);
				}
				
			}else{
				return json_encode(['status'=>false,'msg'=>'请重新登录']);
			}
		}else{
			return json_encode(['status'=>false,'msg'=>'请重新登录']);
		}
	}


	//修改购物车选中状态
	public function updateSelected(){
		if($this->check_token()){
			$openid=input('openid');
			$user_id=$this->getUserId($openid);
			if($user_id){
				$goods_id=input('goodsId');
				$selected=input('selected');

				Db::name('cart')->where('goods_id',$goods_id)->where('user_id',$user_id)->data(['selected'=>$selected])->update();
			}else{
				return json_encode(['status'=>false,'msg'=>'请重新登录']);
			}
		}else{
			return json_encode(['status'=>false,'msg'=>'请重新登录']);
		}
	}

	//全选、反选
	public function updateCheckAll(){
		if($this->check_token()){
			$openid=input('openid');
			$user_id=$this->getUserId($openid);
			if($user_id){
				$selected=input('selected');
				Db::name('cart')->where('user_id',$user_id)->data(['selected'=>$selected])->update();
			}else{
				return json_encode(['status'=>false,'msg'=>'请重新登录']);
			}
		}else{
			return json_encode(['status'=>false,'msg'=>'请重新登录']);
		}
	}

	//加减时修改购物车数量
	public function updateGoodsNum(){
		if($this->check_token()){
			$openid=input('openid');
			$user_id=$this->getUserId($openid);
			if($user_id){
				$goods_id=input('goodsId');
				$goods_num=input('goodsNum');
				Db::name('cart')->where(['goods_id'=>$goods_id,'user_id'=>$user_id])->update(['goods_num'=>$goods_num]);
			}else{
				return json_encode(['status'=>false,'msg'=>'请重新登录']);
			}
		}else{
			return json_encode(['status'=>false,'msg'=>'请重新登录']);
		}
	}

	//初次加载时商品总价计算
	public function firstGoodsTotalPrice(){
		if($this->check_token()){
			$openid=input('openid');
			$user_id=$this->getUserId($openid);
			if($user_id){
				$cartGoods=Db::name('cart')->where('user_id',$user_id)->select();
				$goodsTotalPrice=0;
				foreach ($cartGoods as $k => $v) {
					$goods=Db::name('goods')->find($v['goods_id']);
					$goodsTotalPrice += $goods['shop_price'] * $v['goods_num'];
				}
				return json_encode(['status'=>true,'goodsTotalPrice'=>$goodsTotalPrice]);
			}else{
				return json_encode(['status'=>false,'msg'=>'请重新登录']);
			}
		}else{
			return json_encode(['status'=>false,'msg'=>'请重新登录']);
		}
	}

	//购物车删除
	public function delCartGoods(){
		if($this->check_token()){
			$openid=input('openid');
			$user_id=$this->getUserId($openid);
			if($user_id){
				$goods_id=input('goods_id');
				Db::name('cart')->where(['goods_id'=>$goods_id,'user_id'=>$user_id])->delete();
			}else{
				return json_encode(['status'=>false,'msg'=>'请重新登录']);
			}
		}else{
			return json_encode(['status'=>false,'msg'=>'请重新登录']);
		}
	}


    // 外部接口
    // 添加购物车
	public function addCart(){
		if($this->check_token()){
			$openid=input('openid');
			$goods_id=input('goods_id');
			$num=input('num');
			$user_id=$this->getUserId($openid);
			if($user_id){
				$goodsInfo=Db::name('goods')->find($goods_id);

				// 查询是否已经在购物车，如果在，就只添加数量，没有就添加新数据
				$cart=Db::name('cart')->where(['goods_id'=>$goods_id,'user_id'=>$user_id])->find();
				if($cart){	
					if( ($cart['goods_num']+$num) < $goodsInfo['stock_num']){
						Db::name('cart')->where(['goods_id'=>$goods_id,'user_id'=>$user_id])->setInc('goods_num', $num);
					}else{
						return json_encode(['status'=>false,'msg'=>'库存不足']);
					}
				}else{
					$data=[
						'goods_id'=>$goods_id,
						'goods_num'=>$num,
						'user_id'=>$user_id
					];
					Db::name('cart')->insert($data);
				}

				return json_encode(['status'=>true,'msg'=>'加入成功']);
			
			}else{
				return json_encode(['status'=>false,'msg'=>'请重新登录']);
			}
		}else{
			return json_encode(['status'=>false,'msg'=>'请重新登录']);
		}
	}

	//得到购物车
	public function getCarts(){
		if($this->check_token()){
			$openid=input('openid');
			$user_id=$this->getUserId($openid);
			if($user_id){
				$cartIds=input('cartIds');
				$carts=Db::name('cart')->whereIn('id',$cartIds)->select();
				$goods=model('goods');
				foreach ($carts as $k => $v) {
					$goodsObj=$goods->field('goods_name,thumb,shop_price')->find($v['goods_id']);
					$goodsArr=$goodsObj->toArray();
					$carts[$k]=array_merge($goodsArr,$v);
				}

				$address=db('address')->where(['user_id'=>$user_id,'deafult'=>1])->find();
				return json_encode(['status'=>true,'cartList'=>$carts,'address'=>$address]);
			}else{
				return json_encode(['status'=>false,'msg'=>'请重新登录']);
			}
		}else{
			return json_encode(['status'=>false,'msg'=>'请重新登录']);
		}
	}

	
}
