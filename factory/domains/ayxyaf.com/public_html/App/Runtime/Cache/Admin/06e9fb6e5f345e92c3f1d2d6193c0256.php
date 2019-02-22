<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
	<title>引用页</title>
	<link rel="stylesheet" type="text/css" href="../Public/Css/reset.css" />
	<link rel="stylesheet" type="text/css" href="../Public/Css/base.css" />
	<script type="text/javascript" src="../Public/Js/jquery.js"></script>
	<script type="text/javascript" src="../Public/Js/common.js"></script>	
</head>
<body class="main">
            <div class="subTit">
                <div class="tit">
                    <a href="javascript:;">系统</a>&gt;<a href="javascript:;">系统设置</a>
                </div>
                </div>
            <div class="tableMod">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="3">网站统计</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td align="center" width='10%'>文章发布</td>
                                <td>已发布文章共<?php echo ($total["article"]); ?>个</td>
                                <td width='30%'><a href="__GROUP__/Article" >查看详情</a></td>
                            </tr>
                            <tr>
                                <td align="center">产品发布:</td>
                                <td>已发布产品共<?php echo ($total["goods"]); ?>个</td>
                                <td><a href="__GROUP__/Goods" >查看详情</a></td>
                            </tr>
                            <tr>
                                <td align="center">招聘发布:</td>
                                <td>已发布招聘信息共<?php echo ($total["jobs"]); ?>个</td>
                                <td><a href="__GROUP__/Jobs" >查看详情</a></td>
                            </tr>
                            <tr>
                                <td align="center">申请应聘:</td>
                                <td>申请应聘信息共<?php echo ($total["apply"]); ?>个</td>
                                <td><a href="__GROUP__/Apply" >查看详情</a></td>
                            </tr>
                            <tr>
                                <td align="center">网络订单:</td>
                                <td>网络订单共有<?php echo ($total["order"]); ?>个</td>
                                <td><a href="__GROUP__/Order" >查看详情</a></td>
                            </tr>
                            <tr>
                                <td align="center">网站留言:</td>
                                <td>网站留言共<?php echo ($total["message"]); ?>个</td>
                                <td><a href="__GROUP__/Message" >查看详情</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php if(isset($qt)): ?><div class="tableMod">
                <table>
                    <thead>
                        <tr>
                            <th colspan="3">移动网站</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="200px" align="center" >QFTouch二维码:</td>
                            <td>
                                <img src="http://www.qftouch.com/api.php?action=qrcode&appid=<?php echo ($qt["id"]); ?>" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div><?php endif; ?> 
            <div class="tableMod">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="3">登陆日志</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td  align="center" >用户名</td>
                                <td  align="center" >IP</td>
                                <td  align="center" >时间</td>
                            </tr>
                            <?php if(is_array($log)): $i = 0; $__LIST__ = $log;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                            	<td align="center"><?php echo ($vo["user"]); ?></td>
                                <td align="center"><?php echo ($vo["ip"]); ?></td>
                                <td align="center"><?php echo ($vo["time"]); ?></td>
                            </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                        </tbody>
                    </table>
                </div>         
</body>
</html>