<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-13 15:18:35
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-15 22:19:22
 */
namespace app\api\model;
use think\Model;
/**
 * 
 */
class GoodsPhoto extends Model
{
	
	public function getGoodsPhotoAttr($value,$data){
		return config('queue.http_Img').'/goodsPhoto/'.$data['goods_id'].'/'.$value;
	}

}