<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-11 21:34:43
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-13 15:20:34
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
/**
 * 
 */
class Cate extends Controller
{
	


	public function lst()
	{
		if(request()->isAjax()){
            $data=input('sort');
            $arr=explode("-",$data);
            foreach ($arr as $k => $v) {
                Db::name('cate')->where('id',$v)->update(['sort'=>$k]);
            }
            echo 1;
            // echo($data);
            die;
        }
		$data=Db::name('Cate')->field('id,pid,cate_name,thumb')->order('sort','ASC')->select();
		$catetree=model('Cate')->catetree($data);
		$this->assign('cate',$catetree);
		return view();
	}

	public function add()
	{
		if (request()->isPost()) {
			$data=input('post.');
			$data=model('Cate')->imgupload($data);
			if($data===false){
				$this->error('未上传图片');
			}
			$add=Db::name('Cate')->insert($data);
			if($add){
				$this->success('新增成功', 'lst');
			}else{
				$this->error('新增失败');
			}
		}

		$data=Db::name('Cate')->field('id,pid,cate_name')->select();
		$catetree=model('Cate')->catetree($data);
		$this->assign('catetree',$catetree);
		return view();
	}

	public function edit($id)
	{
		if (request()->isPost()) {
			$data=input('post.');
			$data=model('Cate')->imgEdit($data);
			$edit=Db::name('cate')->where('id',$id)->update($data);
			if($edit!==false){
				$this->success('修改成功', 'lst');
			}else{
				$this->error('修改失败');
			}
		}
		// 当前栏目的基本信息
		$cate=Db::name('cate')->find($id);
		$this->assign('cate',$cate);

		// 当前栏目的子栏目
		$child=model('Cate')->children('cate',$id);
		$child[]=$id;
		// dump($child);die;
		$this->assign('child',$child);

		// 无限级栏目
		$data=Db::name('Cate')->field('id,pid,cate_name')->select();
		$catetree=model('Cate')->catetree($data);
		$this->assign('catetree',$catetree);
		return view();
	}

	public function del($id)
	{
		if (request()->isAjax()) {
			$child=model('Cate')->children('cate',$id);
			$child[]=$id;
			$del=model('Cate')::destroy($child);
			if($del){
				echo json_encode($child);
			}else{
				echo 0;
			}
		}
	}
	
}