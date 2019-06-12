<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-13 15:18:35
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-13 15:24:44
 */
namespace app\api\model;
use think\Model;
/**
 * 
 */
class Cate extends Model
{
	
	public function getThumbAttr($value)
	{
		return config('queue.http_cate').$value;
	}
	
}