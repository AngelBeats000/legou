<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-13 15:18:35
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-15 19:50:56
 */
namespace app\api\model;
use think\Model;
/**
 * 
 */
class Goods extends Model
{
	
	public function getThumbAttr($value){
		return config('queue.http_Img').'/goods/'.$value;
	}

	public function getDesImgAttr($value){
		return config('queue.http_Img').'/goods/'.$value;
	}

}