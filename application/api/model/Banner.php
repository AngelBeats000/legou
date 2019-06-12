<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-13 15:18:35
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-13 15:24:51
 */
namespace app\api\model;
use think\Model;
/**
 * 
 */
class Banner extends Model
{
	
	public function getImgSrcAttr($value){
		return config('queue.http_banner').$value;
	}

}