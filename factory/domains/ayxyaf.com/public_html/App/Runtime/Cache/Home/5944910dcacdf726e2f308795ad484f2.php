<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<title><?php echo ($title); ?></title>
	<meta name="keywords" content="<?php echo ($keywords); ?>">
	<meta name="description" content="<?php echo ($description); ?>">
	<!--<?php if($config["switch_mbaidu"] == '1'): ?><link rel="alternate" type="application/vnd.wap.xhtml+xml" media="handheld" href="http://<?php echo ($config["web_url"]); ?>/m/"/><?php endif; ?>-->
 <!--[if lt IE 9]>
<script src="__TMPL__Public/Js/html5.js"></script>
<![endif]-->
<!--[if IE 6]>
<script src="__TMPL__Public/Js/DD_belatedPNG_0.0.8a.js"></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
    <link rel="stylesheet" href="__TMPL__Public/Css/css.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="__TMPL__Public/icon/css/font-awesome.min.css">
    <script src="__TMPL__Public/Js/jquery-1.4.3.min.js" language="JavaScript" type="text/javascript"></script>
    <script src="__TMPL__Public/Js/all.js" language="JavaScript" type="text/javascript"></script>
    <script type="text/javascript" src="__TMPL__Public/Js/jquery.SuperSlide.2.1.1.js"></script> 
    <link rel="stylesheet" type="text/css" href="__TMPL__Public/Js/fancybox/jquery.fancybox-1.3.4.css" />
    <script type="text/javascript" src="__TMPL__Public/Js/fancybox/jquery.fancybox-1.3.4.js"></script>
    <script>
$(function(){
$(".mesmore").fancybox();
});
</script>
</head>
<body>

<div id="top">
<div class="top mar">
<span class="left top_sp1">您好，欢迎光临<?php echo ($config['web_title']); ?>官网！</span>
<span class="right top_sp2">
<a href="javascript:void(0)" onclick="SetHome(this,window.location)">设为首页</a> ┆ <a href="javascript:void(0)" onclick="shoucang(document.title,window.location)">加入收藏</a></span>
</div>
</div>
<!--top-->
<div id="header">
<div class="header mar ovfl">
<a href="__APP__/" class=" logo"><img src="__TMPL__Public/images/logo.jpg" alt="" /></a>
<a href="__APP__/contact" class=" tel"><span>服务热线：</span><b><?php echo ($config['mobile']); ?></b></a>

<div class="nav">
<ul>
<li id="nav_0"><a href="__APP__/">首页</a></li>
	<li class="nav_line"></li>
<li id="nav_a1"><a href="__APP__/article/1">公司简介</a></li>
<li class="nav_line"></li>
<li id="nav_2"><a href="__APP__/product/2">产品中心</a></li>
<li class="nav_line"></li>
<li id="nav_4"><a href="__APP__/news/4">新闻动态</a></li>
<li class="nav_line"></li>
<li id="nav_7"><a href="__APP__/custom/7">仓库现货</a></li>
<li class="nav_line"></li>
<li id="nav_a12"><a href="__APP__/article/12">商务洽谈</a></li>
<li class="nav_line"></li>
<li id="nav_101"><a href="__APP__/message">在线留言</a></li>
<li class="nav_line"></li>
<li id="nav_a2"><a href="__APP__/contact">联系我们</a></li>
</ul>
</div>

<!--nav-->
<script type="text/javascript">
	try{
	document.getElementById("nav_<?php echo ($bz); ?>").className="selectli";
	}catch(e){}
	</script>
</div>
</div>
<!--header-->
<?php if($bz == '0'): ?><div class="banner">
<link rel="stylesheet" href="__TMPL__Public/Css/banner.css">
<div class="slide_container">
<ul class="rslides slide slide1" id="slider">
<?php if(is_array($scoll)): $i = 0; $__LIST__ = $scoll;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($vo["link"]); ?>" title="<?php echo ($vo["title"]); ?>"><img src="__ROOT__/__UPLOAD__/<?php echo ($vo["img"]); ?>" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<a class="slide_nav slide1_nav prev">Previous</a><a class="slide_nav slide1_nav next">Next</a>
</div>
<script src="__TMPL__Public/Js/responsiveslides.min.js"></script>
<script src="__TMPL__Public/Js/slide.js"></script>
</div>
<?php else: ?>
<div class="page_banner"></div><?php endif; ?>
<script type="text/javascript"> 
// 设置为主页 
function SetHome(obj,vrl){ 
try{ 
obj.style.behavior='url(#default#homepage)';obj.setHomePage(vrl); 
} 
catch(e){ 
if(window.netscape) { 
try { 
netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect"); 
} 
catch (e) { 
alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。"); 
} 
var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch); 
prefs.setCharPref('browser.startup.homepage',vrl); 
}else{ 
alert("您的浏览器不支持，请按照下面步骤操作：1.打开浏览器设置。2.点击设置网页。3.输入："+vrl+"点击确定。"); 
} 
} 
} 
// 加入收藏 兼容360和IE6 
function shoucang(sTitle,sURL) 
{ 
try 
{ 
window.external.addFavorite(sURL, sTitle); 
} 
catch (e) 
{ 
try 
{ 
window.sidebar.addPanel(sTitle, sURL, ""); 
} 
catch (e) 
{ 
alert("加入收藏失败，请使用Ctrl+D进行添加"); 
} 
} 
} 
</script> 

<div class="wrap mar">

<div class="left_side">
<p class="left_sidep1"><a href="__APP__/product/2">产品中心</a></p>
<ul class="left_sideul">
<?php if(is_array($in_proclass1)): $i = 0; $__LIST__ = $in_proclass1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li id="left_<?php echo ($vo["id"]); ?>"><a href="__APP__/product/<?php echo ($vo["id"]); ?>"  title="<?php echo ($vo["name"]); ?>"><?php echo (msubstr($vo["name"],0,10,'utf-8',false)); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<script type="text/javascript">
	try{
	document.getElementById("left_<?php echo ($bz1); ?>").className="selectli";
	}catch(e){}
	</script>
<div class="pcontact_us ovfl">
<a href="__APP__/contact" class="pcontact_a3"><img src="__TMPL__Public/images/pweixin.jpg" /></a>
<div class="pcontact_us_01">
<?php echo ($intro1["content"]); ?>
</div>
</div>
<!--contactus-->
</div>
<!--left_side-->
<div class="right_side ">
<div class="right_title">
<div class="right_title_left"><?php echo ($titles); ?></div>
<div class="right_title_right"><span class="right_title_right_sp1"></span><span class="right_title_right_sp2">当前位置：<a href="__APP__/">网站首页</a><?php echo ($get_category_menu); ?> > <?php echo (msubstr($list['title'],0,10,'utf-8',false)); ?></span></div>
</div>
<!--right_title-->
<div class="right_content">

<h2 id="newTitle"><strong><?php echo ($list['title']); ?></strong></h2>
                        <h6 id="newsInfo">发布：<?php echo ($user['username']); ?><span class="newsinfoleft">浏览：<?php echo ($list['click']); ?>次</span></h6>
                        <?php if($list['img'] != ''): ?><p id="infoImage"><a href="__ROOT__/__UPLOAD__/<?php echo ($list['img']); ?>" class="mesmore"><img src="__ROOT__/__UPLOAD__/<?php echo ($list['img']); ?>" alt="<?php echo ($list['title']); ?>"/></a></p><?php endif; ?>
                         <div class="recruit_info_tit_bg">
                	<div class="recruit_info_tit">
                    详细说明
                    </div>
                </div>
                        <div id="newsContent">
                             <div class="newsContent"><?php echo ($list['content']); ?></div>
                              <?php if($list['link'] != ''): ?><div class="alink"><strong>外部链接：</strong><a href="<?php echo ($list['link']); ?>" target="_blank"><?php echo ($list['link']); ?></a></div><?php endif; ?>    
                        </div>
                               <div class="pageslist">
                            <p class="pageslistp1">
                                <i class=" fa fa-arrow-circle-left"></i>
                                <strong>上一条信息：</strong><?php if($prev_title != ''): ?><a href="<?php echo ($prev); ?>" title="<?php echo ($prev_title); ?>"><?php echo (msubstr($prev_title,0,15)); ?></a><?php else: ?>
                                                    <span>没有了！</span><?php endif; ?>
                            </p>
                            <p class="pageslistp2">
                            <i class=" fa fa-arrow-circle-right"></i>
                              <strong>下一条信息：</strong><?php if($next_title != ''): ?><a href="<?php echo ($next); ?>"  title="<?php echo ($next_title); ?>"><?php echo (msubstr($next_title,0,15)); ?></a><?php else: ?>
                                                    <span>没有了！</span><?php endif; ?>
                            </p>
                            
                        </div>

</div>
<!--right_content-->
</div>
<!--right_side-->
<div class="clear"></div>
</div>
<!--wrap-->

<div id="footer">
<div class="footer mar">
<div class="footer_01">
<a href="__APP__/">首页</a>|<a href="__APP__/article/1">公司简介</a>|<a href="__APP__/news/4">新闻动态</a>|<a href="__APP__/product/2">产品中心</a>|<a href="__APP__/custom/22">成功案例</a>|<a href="__APP__/article/12">商务合作</a>|<a href="__APP__/message">在线留言</a>|<a href="__APP__/contact">联系我们</a>
</div>

<div style="width:800px;padding-top:5px;margin-bottom:-10px;height:20px;line-height:20px;color:#fff;text-align: left;margin-left:auto;margin-right:auto;">
  <?php $flink = M('article')->where("`pid`=6")->select();?>
  <b>友情链接：</b>
  <?php if(is_array($flink)): $i = 0; $__LIST__ = $flink;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li style="display: inline-block;"><a href="<?php echo ($vo["content"]); ?>" target="_blank" style="color:#fff;"><?php echo ($vo["title"]); ?></a>　</li><?php endforeach; endif; else: echo "" ;endif; ?>
</div>

<div class="footer_02">
<?php echo ($config['other']); if($config['icp_num'] != ''): ?>　<a href="http://www.miitbeian.gov.cn" target="_blank"><?php echo ($config['icp_num']); ?></a><?php endif; ?>
<?php if($config['address'] != ''): ?>&nbsp;&nbsp;地址：<?php echo ($config['address']); endif; ?>&nbsp;&nbsp;<a href="http://www.ayqingfeng.com/mzsm.htm" title="免责声明" target="_blank">免责声明</a>&nbsp;&nbsp;<a href="__APP__/admin" target="_blank">【管理登录】</a>&nbsp;&nbsp;技术支持：<a href="http://www.ayqingfeng.com/" target="_blank">青峰网络</a>&nbsp;&nbsp;<?php echo ($config["scode"]); ?>
</div>
</div>
</div>
<!--footer-->

<div class="kefu1" id="kefu1">
<ul>
<li class="kefu1li1">
<a href="__APP__/message"><img src="__TMPL__Public/images/kficon1.png" alt=""/><span>在线留言</span></a>
</li>
<li class="kefu1li1" id="kefu1li2">
<a href="__APP__/contact"><img src="__TMPL__Public/images/kficon2.png" alt=""/><span>关注微信</span><i></i></a>
</li>
<li class="kefu1li1">
<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($config['qq']); ?>&site=<?php echo ($config['web_url']); ?>&menu=yes" target="_blank"><img src="__TMPL__Public/images/kficon3.png" alt=""/><span>在线客服</span></a>
</li>
<li class="kefu1li1">
<a href="__APP__/contact"><img src="__TMPL__Public/images/kficon4.png" alt=""/><span><?php echo ($config['mobile']); ?></span></a>
</li>
<li class="kefu1li1">
<a href="#" class="cd-top"><img src="__TMPL__Public/images/kficon5.png" alt=""/><span>返回顶部</span></a>
</li>
</ul>
</div>
<script type="text/javascript">
    $(function () {
        $('#kefu1').css({ 'top': $(window).scrollTop() + $(window).height() / 2 - $('#kefu1').height() / 2 });
        $(window).scroll(function () {
            $('#kefu1').stop(true).animate({ 'top': $(window).scrollTop() + $(window).height() / 2 - $('#kefu1').height() / 2 }, { duration: 500 });
        });
    });
            </script>
               <script type="text/javascript">
		jQuery("#kefu1").slide({titCell:"ul li",autoPlay:true,delayTime:2000});
		</script>

<script src="__TMPL__Public/Js/topbtn.js"></script>

<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?55debe9cbb36194b0dd821484b7ea12f";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>



<div class="bdsharebuttonbox" style="display:none;">
<a href="javascript:document.getElementById('bds_weixin').click();">
<a href="#" class="bds_more" data-cmd="more"></a>
<a href="#" class="bds_qzone" data-cmd="qzone" id="bds_qzone" title="分享到QQ空间">
</a><a href="#" class="bds_tsina" data-cmd="tsina" id="bds_tsina" title="分享到新浪微博">
</a><a href="#" class="bds_tqq" data-cmd="tqq" id="bds_tqq" title="分享到腾讯微博">
</a><a href="#" class="bds_renren" data-cmd="renren" id="bds_renren" title="分享到人人网">
</a><a href="#" class="bds_weixin" data-cmd="weixin" id="bds_weixin" title="分享到微信"></a>
<a href="#" class="bds_sqq" data-cmd="sqq" id="bds_sqq" title="分享到QQ好友"></a>
<a href="#" class="bds_mail" data-cmd="mail" id="bds_mail" title="分享到邮件分享"></a>
</div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"16"},"share":{},"":{"viewList":["qzone","tsina","tqq","renren","weixin","sqq","mail"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin","sqq","mail"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>           
<script src="http://tools.bce216.greensp.cn/xinnian/xn.js" language="JavaScript"></script>

</body>	
</html>