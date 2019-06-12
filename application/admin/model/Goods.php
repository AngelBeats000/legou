<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-11 15:47:05
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-12 21:34:46
 */
namespace app\admin\model;
use think\Model;
use think\Db;
/**
 * 
 */
class Goods extends Model
{

	public function getThumbAttr($value)
	{
		return config('queue.http_cate').$value;
	}

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

	// 添加时的图片上传
	public function imgupload($data=array()){
		if($_FILES['thumb']['tmp_name']){
			$file=request()->file('thumb');
			if($file){
				$info=$file->move(ROOT_PATH . 'public' . DS . 'uploadimg' . DS . 'goods');
				if($info){
					$data['thumb']=date("Ymd").'/'.$info->getFilename();
				}
			}
		}else{
			return false;
		}

		if($_FILES['des_img']['tmp_name']){
			$file=request()->file('des_img');
			if($file){
				$info=$file->move(ROOT_PATH . 'public' . DS . 'uploadimg' . DS . 'goods');
				if($info){
					$data['des_img']=date("Ymd").'/'.$info->getFilename();
				}
			}
		}else{
			return false;
		}


		return $data;
	}

	public function imgEdit($data=array()){
		$good=db('goods')->field('thumb,des_img')->find($data['id']);
		if($_FILES['thumb']['tmp_name']){
			if(!empty($good['thumb'])){
				$imgurl=Img.'goods/'.$good['thumb'];
				if(file_exists($imgurl)){
					@unlink($imgurl);
				}
				
			}
			$file=request()->file('thumb');
			if($file){
				$info=$file->move(ROOT_PATH . 'public' . DS . 'uploadimg' . DS . 'goods');
				if($info){
					$data['thumb']=date("Ymd").'/'.$info->getFilename();
				}
			}
		}
		if($_FILES['des_img']['tmp_name']){
			if(!empty($good['des_img'])){
				$imgurl=Img.'goods/'.$good['des_img'];
				if(file_exists($imgurl)){
					@unlink($imgurl);
				}
				
			}
			$file=request()->file('des_img');
			if($file){
				$info=$file->move(ROOT_PATH . 'public' . DS . 'uploadimg' . DS . 'goods');
				if($info){
					$data['des_img']=date("Ymd").'/'.$info->getFilename();
				}
			}
		}
		return $data;
	}

	protected static function init()
	{
		// 商品相册添加
		Goods::event('after_insert', function ($goods) {
			$Id=$goods->id;
			$goods->uploadsome($Id);
		});

		// 删除操作
		Goods::event('before_delete', function ($goods) {
			$Id=$goods->id;
			
			$des=Img . 'goods/' . $goods->des_img;
			$thumb=Img . 'goods/' . $goods->getData('thumb');
			if(file_exists($thumb)){
				@unlink($thumb);
			}
			if(file_exists($des)){
				@unlink($des);
			}
			Db::name('goods_photo')->where('goods_id',$Id)->delete();
			$photo=Img.'goodsPhoto/'.$Id;
			$goods->delDirAndFile($photo);
		});

		// 商品相册添加
		Goods::event('before_update', function ($goods) {
			$Id=$goods->id;
			$goods->uploadsome($Id);
		});

	}

	//商品相册上传
	private function uploadsome($Id){
		if($this->_inImg($_FILES['goods_photo']['tmp_name'])){
			$files=request()->file('goods_photo');
			foreach ($files as $file) {
				$info=$file->move(ROOT_PATH . 'public' . DS . 'uploadimg' . DS . 'goodsPhoto' . DS . $Id);
				$photo=date("Ymd").'/'.$info->getFilename();
				Db::name('goods_photo')->insert(['goods_id'=>$Id,'goods_photo'=>$photo]);
			}
		}
	}

	//判断是否有商品图片
	private function _inImg($tmp){
		foreach ($tmp as $k => $v) {
			if($v){
				return true;
			}
		}
		return false;
	}

	//循环删除目录和文件函数 
	private function delDirAndFile($dirName)
	{
		if ( $handle = opendir($dirName) ) { 
			while ( false !== ( $item = readdir( $handle ) ) ) { 
				if ( $item != "." && $item != ".." ) { 
					if (is_dir( $dirName."/".$item )) { 
						$this->delDirAndFile( $dirName."/".$item ); 
					} else { 
						unlink($dirName."/".$item); 
					} 
				} 
			} 
			closedir($handle); 
			rmdir($dirName);
		} 
	} 
}