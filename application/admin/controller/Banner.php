<?php

/**
 * @Author: Huang LongPan
 * @Date:   2019-05-11 15:27:52
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-13 15:19:16
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
/**
 * 
 */
class Banner extends Controller
{
	
	
	public function lst(){
		if(request()->isAjax()){
            $data=input('sort');
            $arr=explode("-",$data);
            foreach ($arr as $k => $v) {
                Db::name('banner')->where('id',$v)->update(['sort'=>$k]);
            }
            echo 1;
            // echo($data);
            die;
        }
		$banner=Db::name('Banner')->where('status',1)->order('sort','ASC')->select();
		$this->assign('banner',$banner);
		return view();
	}

	public function add()
	{
		if (request()->isPost()) {
			$data=input('post.');
			$data=model('Banner')->imgupload($data);
			if($data===false){
				$this->error('未上传图片');
			}
			// dump($data);die;
			$add=Db::name('banner')->insert($data);
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
			$data=model('Banner')->imgEdit($data);
			$edit=Db::name('Banner')->where('id',$id)->update($data);
			if($data!==false){
				$this->success('修改成功', 'lst');
			}else{
				$this->error('修改失败');
			}
		}
		// 查询当前banner的信息
		$banner=Db::name('banner')->find($id);
		$this->assign('banner',$banner);
		return view();
	}

	public function del($id)
	{	
		// 假删除,修改status状态表示
		if(request()->isAjax()){
			$del=Db::name('banner')->where('id',$id)->update(['status'=>'0']);
			if($del){
				echo 1;
			}else{
				echo 0;
			}
		}
	}

}