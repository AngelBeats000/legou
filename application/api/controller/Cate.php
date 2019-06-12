<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
class Cate extends Controller
{
	// 小程序接口
	// 查询一级栏目
	public function appCate(){
		$cate=Db::name('cate')->field('id,cate_name')->where('pid',0)->order('sort','ASC')->select();
		return json_encode($cate);
	}

	// 查询默认分类数据
	public function get_one_cate($id=0){
		if($id==0){
			$one=model('Cate')->field('id,cate_name,thumb')->where('pid',0)->order('sort','ASC')->limit(1)->find();
		}else{
			$one=model('Cate')->field('id,cate_name,thumb')->where('id',$id)->find();
		}
		

		return json_encode($one);
	}

	//默认子栏目
	public function get_son_cate($pid=0){
		$sonCate=model('Cate')->field('id,cate_name,thumb')->where('pid',$pid)->order('sort','ASC')->select();
		return json_encode($sonCate);
	}



	//查询前栏目的同级栏目
	public function getCates($id){
		$pid=Db::name('cate')->field('pid')->find($id);
		$cates=Db::name('cate')->field('id,cate_name')->where('pid',$pid['pid'])->select();
		return json_encode($cates);
	}
}
