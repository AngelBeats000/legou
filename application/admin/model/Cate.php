<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-11 15:47:05
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-13 15:20:24
 */
namespace app\admin\model;
use think\Model;
use think\Db;
/**
 * 
 */
class Cate extends Model
{

	// 无限级栏目
	public function catetree($data){
		return $this->_catetree($data);
	}

	private function _catetree($data=array(),$level=0,$pid=0){
		static $arr=array();
		foreach ($data as $k => $v) {
			if($v['pid']==$pid){
				$v['level']=$level;
				$arr[]=$v;
				$this->_catetree($data,$level+1,$v['id']);
			}
			
		}
		return $arr;
	}

	// 查询子栏目
	public function children($table,$id){
		$data=$this->field('id,pid')->select();
		return $this->_children($data,$id);
	}

	private function _children($data,$id){
		static $arr=array();
		foreach ($data as $k => $v) {
			if($v['pid']==$id){
				$arr[]=$v['id'];
				$this->_children($data,$v['id']);
			};
		}

		return $arr;
	}

	// 添加时的图片上传
	public function imgupload($data=array()){
		if($_FILES['thumb']['tmp_name']){
			$file=request()->file('thumb');
			if($file){
				$info=$file->move(ROOT_PATH . 'public' . DS . 'uploadimg' . DS . 'cate');
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
			if(isset($data['old_img'])){
				$imgurl=Cate.$data['old_img'];
				if(file_exists($imgurl)){
					@unlink($imgurl);
				}
				
			}
			$file=request()->file('thumb');

			if($file){
				$info=$file->move(ROOT_PATH . 'public' . DS . 'uploadimg' . DS . 'cate');
				if($info){
					$data['thumb']=$info->getSaveName();
				}
			}
		}
		unset($data['old_img']);
		return $data;
	}

	protected static function init()
	{
		Cate::event('before_delete', function ($user) {
			if($user->thumb){
				$imgurl=Cate.$user->thumb;
				if(file_exists($imgurl)){
					@unlink($imgurl);
				}
			}
		});
	}
}