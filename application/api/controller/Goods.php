<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-14 19:51:41
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-20 20:57:34
 */
namespace app\api\controller;
use think\Controller;
use think\Db;
class Goods extends Common
{
    // 外部接口
	public function goodsList($cid,$page=1){
		$config=['page'=>$page,'list_rows'=>8];
		$goodsList=model('Goods')->field('id,goods_name,thumb,shop_price')->where('cate_id',$cid)->paginate(null,false,$config);
		return json_encode(['code'=>200,'msg'=>'成功','goods'=>$goodsList]);
	}

	public function getGoods($id){
		$goods=model('Goods')->find($id);
		if(!$goods){
			return json_encode(['status'=>400]);
		}else{
			if($goods['des_img']){
				list($height) = getimagesize($goods['des_img']);
				$goods['des_img_height']=$height;
			}else{
				$goods['des_img_height']=0;
			}
			$goods_photo=model('GoodsPhoto')->field('goods_id,goods_photo')->where('goods_id',$id)->select();
			return json_encode(['status'=>200,'goods'=>$goods,'photo'=>$goods_photo]);
		}
	}

	// 添加收藏
	public function addCollect(){
		if($this->check_token()){
			$openid=input('openid');
			$goods_id=input('goods_id');
			$user_id=$this->getUserId($openid);
			$collect=Db::name('collect')->where(['goods_id'=>$goods_id,'user_id'=>$user_id])->find();
			if($collect){
				Db::name('collect')->where(['goods_id'=>$goods_id,'user_id'=>$user_id])->delete();
				return json_encode(['status'=>true,'collect'=>-1,'msg'=>'已取消']);
			}else{
				Db::name('collect')->insert(['goods_id'=>$goods_id,'user_id'=>$user_id]);
				return json_encode(['status'=>true,'collect'=>1,'msg'=>'已收藏']);
			}
		}else{
			return json_encode(['status'=>false,'msg'=>'请重新登录']);
		}
	}

	//判断商品是否收藏
	public function doCollect($goods_id,$openid){
		$user_id=$this->getUserId($openid);
		$collect=Db::name('collect')->where(['goods_id'=>$goods_id,'user_id'=>$user_id])->find();
		if($collect){
			return json_encode(['status'=>1]);
		}else{
			return json_encode(['status'=>0]);
		}
	}
	
}
