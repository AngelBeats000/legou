<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-11 15:27:52
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-13 15:48:36
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Goods as GoodsModel; 
/**
 * 
 */
class Goods extends Controller
{
	// 外部接口
	public function appbanner(){
		$banner=model('Banner')->field('img_src,link_url')->where('status',1)->order('sort','ASC')->limit(3)->select();
		return json_encode($banner);
	}
	
	public function lst(){
		$Goods=Db::name('Goods')->alias('g')->join('cate c','g.cate_id=c.id','LEFT')->field('g.*,c.cate_name')->paginate(10);
		$this->assign('Goods',$Goods);
		return view();
	}

	public function add()
	{
		$model=new GoodsModel();

		if (request()->isPost()) {
			$data=input('post.');
			$data=$model->imgupload($data);
			if($data===false){
				$this->error('请检查主图和描述图');
			}
			// dump($data);die;
			$add=$model->save($data);
			if($add){
				$this->success('新增成功', 'lst');
			}else{
				$this->error('新增失败');
			}
		}
		// 无限级栏目
		$cateRes=Db::name('cate')->field('id,pid,cate_name')->select();
		$cateTree=$model->catetree($cateRes);
		$this->assign('cateRes',$cateTree);
		return view();
	}

	public function edit($id){
		$model=new GoodsModel();
		if(request()->isPost()){
			$data=input('post.');
			$data=model('Goods')->imgEdit($data);
			$edit=model('goods')->save($data,['id'=>$id]);
			if($data!==false){
				$this->success('修改成功', 'lst');
			}else{
				$this->error('修改失败');
			}
		}
		//商品相册信息
		$photo=Db::name('goods_photo')->where('goods_id',$id)->select();
		$this->assign('photo',$photo);
		//无限级
		$cateRes=Db::name('cate')->field('id,pid,cate_name')->select();
		$cateTree=$model->catetree($cateRes);
		$this->assign('cateRes',$cateTree);
		// 查询当前商品的信息
		$goods=Db::name('goods')->find($id);
		$this->assign('goods',$goods);
		return view();
	}

	public function del($id)
	{	
		if(request()->isAjax()){
			$del=model('Goods')->destroy($id);
			if($del){
				echo 1;
			}else{
				echo 0;
			}
		}
	}

	public function delimg($photoid,$goodsid){
		if (request()->isAjax()) {
			$photo=Db::name('goods_photo')->find($goodsid);
			$imgurl=Img.'goodsPhoto/'.$goodsid . '/'.$photo['goods_photo'];
			@unlink($imgurl);
			$del=Db::name('goods_photo')->where('id',$photoid)->delete();
			if($del){
				echo 1;
			}else{
				echo 0;
			}
		}
	}

}