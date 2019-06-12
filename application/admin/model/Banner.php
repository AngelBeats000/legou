<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-11 15:47:05
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-13 15:19:16
 */
namespace app\admin\model;
use think\Model;

/**
 * 
 */
class Banner extends Model
{
	
	public function imgupload($data=array()){
		if($_FILES['img_src']['tmp_name']){
			$file=request()->file('img_src');

			if($file){
				$info=$file->move(ROOT_PATH . 'public' . DS . 'uploadimg' . DS . 'banner');
				if($info){
					$data['img_src']=date("Ymd").'/'.$info->getFilename();
				}
			}
		}else{
			return false;
		}

		return $data;
	}

	public function imgEdit($data=array()){
		if($_FILES['img_src']['tmp_name']){
			if(isset($data['old_img'])){
				$imgurl=Banner.$data['old_img'];
				if(file_exists($imgurl)){
					@unlink($imgurl);
				}
			}
			$file=request()->file('img_src');

			if($file){
				$info=$file->move(ROOT_PATH . 'public' . DS . 'uploadimg' . DS . 'banner');
				if($info){
					$data['img_src']=date("Ymd").'/'.$info->getFilename();
				}
			}
		}

		unset($data['old_img']);
		return $data;
	}
	
}