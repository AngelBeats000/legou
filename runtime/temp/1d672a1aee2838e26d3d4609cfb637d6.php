<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:81:"D:\phpstudy\PHPTutorial\WWW\legou\public/../application/admin\view\banner\lst.htm";i:1557565136;s:71:"D:\phpstudy\PHPTutorial\WWW\legou\application\admin\view\public\top.htm";i:1557558538;s:72:"D:\phpstudy\PHPTutorial\WWW\legou\application\admin\view\public\left.htm";i:1557836105;}*/ ?>
<!DOCTYPE html>
<html><head>
	    <meta charset="utf-8">
    <title>童老师ThinkPHP交流群：484519446</title>

    <meta name="description" content="Dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--Basic Styles-->
    <link href="/legou/public/static/admin/style/bootstrap.css" rel="stylesheet">
    <link href="/legou/public/static/admin/style/font-awesome.css" rel="stylesheet">
    <link href="/legou/public/static/admin/style/weather-icons.css" rel="stylesheet">

    <!--Beyond styles-->
    <link id="beyond-link" href="/legou/public/static/admin/style/beyond.css" rel="stylesheet" type="text/css">
    <link href="/legou/public/static/admin/style/demo.css" rel="stylesheet">
    <link href="/legou/public/static/admin/style/typicons.css" rel="stylesheet">
    <link href="/legou/public/static/admin/style/animate.css" rel="stylesheet">

    <link href="/legou/public/static/admin/style/jquery-ui.min.css" rel="stylesheet">
</head>
<body>
	<!-- 头部 -->
	<!-- /**
 * @Author: Huang LongPan
 * @Date:   2019-05-11 15:08:40
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-11 15:08:58
 */ -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="navbar-container">
            <!-- Navbar Barnd -->
            <div class="navbar-header pull-left">
                <a href="#" class="navbar-brand">
                    <small>
                            <img src="/legou/public/static/admin/images/logo.png" alt="">
                        </small>
                </a>
            </div>
            <!-- /Navbar Barnd -->
            <!-- Sidebar Collapse -->
            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="collapse-icon fa fa-bars"></i>
            </div>
            <!-- /Sidebar Collapse -->
            <!-- Account Area and Settings -->
            <div class="navbar-header pull-right">
                <div class="navbar-account">
                    <ul class="account-area">
                        <li>
                            <a class="login-area dropdown-toggle" data-toggle="dropdown">
                                <div class="avatar" title="View your public profile">
                                    <img src="/legou/public/static/admin/images/adam-jansen.jpg">
                                </div>
                                <section>
                                    <h2><span class="profile"><span>admin</span></span></h2>
                                </section>
                            </a>
                            <!--Login Area Dropdown-->
                            <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                                <li class="username"><a>David Stevenson</a></li>
                                <li class="dropdown-footer">
                                    <a href="/admin/user/logout.html">
                                            退出登录
                                        </a>
                                </li>
                                <li class="dropdown-footer">
                                    <a href="/admin/user/changePwd.html">
                                            修改密码
                                        </a>
                                </li>
                            </ul>
                            <!--/Login Area Dropdown-->
                        </li>
                        <!-- /Account Area -->
                        <!--Note: notice that setting div must start right after account area list.
                            no space must be between these elements-->
                        <!-- Settings -->
                    </ul>
                </div>
            </div>
            <!-- /Account Area and Settings -->
        </div>
    </div>
</div>
	<!-- /头部 -->
	
	<div class="main-container container-fluid">
		<div class="page-container">
			            <!-- Page Sidebar -->
           <!-- /**
 * @Author: Huang LongPan
 * @Date:   2019-05-11 15:09:31
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2019-05-14 20:15:05
 */ -->
<div class="page-sidebar" id="sidebar">
                <!-- Page Sidebar Header-->
                <div class="sidebar-header-wrapper">
                    <input class="searchinput" type="text">
                    <i class="searchicon fa fa-search"></i>
                    <div class="searchhelper">Search Reports, Charts, Emails or Notifications</div>
                </div>
                <!-- /Page Sidebar Header -->
                <!-- Sidebar Menu -->
                <ul class="nav sidebar-menu">
                    <!--Dashboard-->
                   
                    <li>
                        <a href="/admin/main/index.html">
                            <i class="menu-icon fa fa-gear"></i>

                            <span class="menu-text">
                                控制面板                            </span>

                            <i class="menu-expand"></i>
                        </a>
                    </li>                        
                    <li>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-gear"></i>

                            <span class="menu-text">
                                banner管理                            </span>

                            <i class="menu-expand"></i>
                        </a>
                                                <ul class="submenu">
                                                        <li>
                                <a href="<?php echo url('admin/banner/lst'); ?>">
                                    <span class="menu-text">
                                        banner列表                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                                            </li>
                                                            <li>
                                <a href="<?php echo url('admin/banner/add'); ?>">
                                    <span class="menu-text">
                                        banner添加                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                                            </li>
                                                            <li>
                                <a href="<?php echo url('admin/banner/add'); ?>">
                                    <span class="menu-text">
                                        banner回收站                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                                            </li>
                            
                        </ul>                            
                    </li> 
                    <li>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-gear"></i>

                            <span class="menu-text">
                                栏目管理                            </span>

                            <i class="menu-expand"></i>
                        </a>
                                                <ul class="submenu">
                                                        <li>
                                <a href="<?php echo url('admin/cate/lst'); ?>">
                                    <span class="menu-text">
                                        栏目列表                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                                            </li>
                                                            <li>
                                <a href="<?php echo url('admin/cate/add'); ?>">
                                    <span class="menu-text">
                                        栏目添加                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                                            </li>
                                                           
                            
                        </ul>                            
                    </li> 
                    <li>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-gear"></i>

                            <span class="menu-text">
                                商品管理                            </span>

                            <i class="menu-expand"></i>
                        </a>
                                                <ul class="submenu">
                                                        <li>
                                <a href="<?php echo url('admin/goods/lst'); ?>">
                                    <span class="menu-text">
                                        商品列表                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                                            </li>
                                                            <li>
                                <a href="<?php echo url('admin/goods/add'); ?>">
                                    <span class="menu-text">
                                        商品添加                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                                            </li>
                                                           
                            
                        </ul>                            
                    </li> 
                    <li>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-gear"></i>

                            <span class="menu-text">
                                板块管理                            </span>

                            <i class="menu-expand"></i>
                        </a>
                                                <ul class="submenu">
                                                        <li>
                                <a href="<?php echo url('admin/special/lst'); ?>">
                                    <span class="menu-text">
                                        板块列表                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                                            </li>
                                                            <li>
                                <a href="<?php echo url('admin/special/add'); ?>">
                                    <span class="menu-text">
                                        板块添加                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                                            </li>
                                                           
                            
                        </ul>                            
                    </li> 

                                        <li>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-gear"></i>

                            <span class="menu-text">
                                系统                            </span>

                            <i class="menu-expand"></i>
                        </a>
                                                <ul class="submenu">
                                                        <li>
                                <a href="/admin/user/index.html">
                                    <span class="menu-text">
                                        用户管理                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                                            </li>
                                                        <li>
                                <a href="/admin/auth_group/index.html">
                                    <span class="menu-text">
                                        角色管理                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                                            </li>
                                                        <li>
                                <a href="/admin/auth_rule/index.html">
                                    <span class="menu-text">
                                        权限列表                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                                            </li>
                            
                        </ul>                            
                                            </li>                        
                    
                </ul>
                <!-- /Sidebar Menu -->
            </div>
            <!-- /Page Sidebar -->
            <!-- Page Content -->
            <div class="page-content">
                <!-- Page Breadcrumb -->
                <div class="page-breadcrumbs">
                    <ul class="breadcrumb">
                                        <li>
                        <a href="#">系统</a>
                    </li>
                                        <li class="active">banner管理</li>
                                        </ul>
                </div>
                <!-- /Page Breadcrumb -->

                <!-- Page Body -->
                <div class="page-body">
                    
<button type="button" tooltip="添加banner" class="btn btn-sm btn-azure btn-addon" onClick="javascript:window.location.href = '<?php echo url('admin/banner/add'); ?>'"> <i class="fa fa-plus"></i> Add
</button>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-body">
                <div class="flip-scroll">
                    <table class="table table-bordered table-hover">
                        <thead class="">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">banner名称</th>
                                <th class="text-center">banner图片</th>
                                <th class="text-center">banner链接</th>
                                <th class="text-center">banner类型</th>
                                <th class="text-center">操作</th>
                            </tr>
                        </thead>
                        <tbody  class="sortable">
                            <?php if(is_array($banner) || $banner instanceof \think\Collection || $banner instanceof \think\Paginator): $i = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <tr  class="ui-state-default" delid="tr_<?php echo $vo['id']; ?>">
                                <td align="center" class="m_ttitle" style="cursor:move;background:#00FFFF;"><i style="float:left;cursor:move" class="fa fa-arrows-v"></i><?php echo $vo['id']; ?></td>
                                <td align="center"><?php echo $vo['title']; ?></td>
                                <td align="center">
                                    <?php if($vo['img_src']): ?><img src="/legou/public/uploadimg/banner/<?php echo $vo['img_src']; ?>" height="30"><?php else: ?>暂无<?php endif; ?>
                                </td>
                                <td align="center"><?php echo $vo['link_url']; ?></td>
                                <td align="center"><?php if($vo['type'] == 1): ?>商品<?php else: ?>专题<?php endif; ?></td>
                                <td align="center">
                                    <a href="<?php echo url('edit',array('id'=>$vo['id'])); ?>" class="btn btn-primary btn-sm shiny">
                                        <i class="fa fa-edit"></i> 编辑
                                    </a>
                                    <a href="#" delid="<?php echo $vo['id']; ?>" onClick="ajaxdel(this)" class="btn btn-danger btn-sm shiny">
                                        <i class="fa fa-trash-o"></i> 删除
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; endif; else: echo "" ;endif; ?>                           
                                                    </tbody>
                    </table>
                </div>
                <div>
                	                </div>
            </div>
        </div>
    </div>
</div>

                </div>
                <!-- /Page Body -->
            </div>
            <!-- /Page Content -->
		</div>	
	</div>

	    <!--Basic Scripts-->
    <script src="/legou/public/static/admin/style/jquery_002.js"></script>
    <script src="/legou/public/static/admin/style/bootstrap.js"></script>
    <script src="/legou/public/static/admin/style/jquery.js"></script>
    <!--Beyond Scripts-->
    <script src="/legou/public/static/admin/style/beyond.js"></script>

    <script src="/legou/public/static/admin/style/jquery-ui.min.js"></script>

    <script src="/legou/public/static/admin/plus/layer/layer.js"></script>
    <script type="text/javascript">
    $(function() {
        //  自定义排序
        $(".sortable" ).sortable({
            connectWith: ".column",
            handle: ".m_ttitle",
            placeholder: "portlet-placeholder ui-corner-all",
            update:function(){
                var save=[];
                $(".m_ttitle").each(function(){
                    save.push($(this).text());
                });
                var arr = save.join("-");
                $.ajax({
                    type:"post",
                    dataType:"json",
                    data:{sort:arr},
                    url:"<?php echo url('lst'); ?>",
                    beforeSend:function(){
                        var index = layer.load(1);
                    },
                    success:function(data){    
                        layer.msg('排序成功', {icon: 1});
                        layer.closeAll("loading");
                    },
                    error:function(){
                        layer.msg('排序失败',{anim: 6,icon: 5});
                        layer.closeAll("loading");
                        
                    },
                });
            
            }
       
        });
        $( ".sortable" ).disableSelection(); 
    });
    </script>
    <script type="text/javascript">
    function ajaxdel(o){
        layer.confirm('确认删除该banner吗?', {icon: 3, title:'提示'}, function(index){
            var id=$(o).attr('delid');
            $.ajax({
                type:"post",
                dataType:"json",
                data:{id:id},
                url:"<?php echo url('del'); ?>",
                ajaxSend:function(){
                    var index = layer.load(0); //换了种风格
                },
                success:function(data){
                    layer.close(index);
                    if(data==1){
                        $("[delid=tr_"+id+"]").remove();
                        layer.msg('删除成功',{icon: 1});
                    }else{
                        layer.msg('删除失败',{anim: 6,icon: 5});
                    }

                },
                error:function(){
                    layer.close(index);
                    layer.msg('删除失败',{anim: 6,icon: 5});
                }
            });

        });
    }

    </script>

</body></html>