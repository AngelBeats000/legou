<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-11 15:47:05
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-12 22:08:10
 */
namespace app\admin\model;
use think\Model;

/**
 * 
 */
class special extends Model
{
	public function getImgSrcAttr($value){
		return config('queue.http_banner').$value;
	}

	public function imgupload($data=array()){
		if($_FILES['thumb']['tmp_name']){
			$file=request()->file('thumb');

			if($file){
				$info=$file->move(ROOT_PATH . 'public' . DS . 'uploadimg' . DS . 'special');
				if($info){
					$data['thumb']=date("Ymd").'/'.$info->getFilename();
				}
			}
		}else{
			return false;
		}

		return $data;
	}

	public function imgEdit($data=array()){
		if($_FILES['thumb']['tmp_name']){
			if(isset($data['thumb'])){
				$imgurl=Img.'special/'.$data['old_img'];
				if(file_exists($imgurl)){
					@unlink($imgurl);
				}
			}
			$file=request()->file('thumb');

			if($file){
				$info=$file->move(ROOT_PATH . 'public' . DS . 'uploadimg' . DS . 'special');
				if($info){
					$data['thumb']=date("Ymd").'/'.$info->getFilename();
				}
			}
		}

		unset($data['old_img']);
		return $data;
	}
	
}