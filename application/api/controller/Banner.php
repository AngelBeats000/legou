<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
class Banner extends Controller
{
    // 外部接口
	public function appbanner(){
		$banner=model('Banner')->field('img_src,link_url')->where('status',1)->order('sort','ASC')->limit(3)->select();
		return json_encode($banner);
	}


	
}
