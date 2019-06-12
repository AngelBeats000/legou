<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-11 15:27:52
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-18 21:50:02
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
/**
 * 
 */
class Special extends Controller
{
	// 外部接口
	public function appbanner(){
		$banner=model('Banner')->field('img_src,link_url')->where('status',1)->order('sort','ASC')->limit(3)->select();
		return json_encode($banner);
	}
	
	public function lst(){
		if(request()->isAjax()){
            $data=input('sort');
            $arr=explode("-",$data);
            foreach ($arr as $k => $v) {
                Db::name('special')->where('id',$v)->update(['sort'=>$k]);
            }
            echo 1;
            // echo($data);
            die;
        }
		$special=Db::name('special')->order('sort','ASC')->select();
		$this->assign('special',$special);
		return view();
	}

	public function add()
	{
		if (request()->isPost()) {
			$data=input('post.');
			$data=model('Special')->imgupload($data);
			if($data===false){
				$this->error('未上传图片');
			}
			// dump($data);die;
			$add=Db::name('special')->insert($data);
			if($add){
				$this->success('新增成功', 'lst');
			}else{
				$this->error('新增失败');
			}
		}
		return view();
	}

	public function edit($id){
		if(request()->isPost()){
			$data=input('post.');
			$data=model('special')->imgEdit($data);
			$edit=Db::name('special')->where('id',$id)->update($data);
			if($data!==false){
				$this->success('修改成功', 'lst');
			}else{
				$this->error('修改失败');
			}
		}
		// 查询当前banner的信息
		$special=Db::name('special')->find($id);
		$this->assign('special',$special);
		return view();
	}

	public function del($id)
	{	
		if(request()->isAjax()){
			$spec=Db::name('special')->find($id);
			if(!empty($spec['thumb'])){
				$imgurl=Img.'special/'.$spec['thumb'];
				if(file_exists($imgurl)){
					unlink($imgurl);
				}
			}
			$del=Db::name('special')->where('id',$id)->delete();
			if($del){
				echo 1;
			}else{
				echo 0;
			}
		}
	}

}