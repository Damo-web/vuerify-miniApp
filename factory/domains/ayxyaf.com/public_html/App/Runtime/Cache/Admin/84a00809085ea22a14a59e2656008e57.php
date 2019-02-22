<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<title><?php echo ($title); ?></title>
<link rel="stylesheet" type="text/css" href="../Public/Css/reset.css" />
<link rel="stylesheet" type="text/css" href="../Public/Css/base.css" />
<script type="text/javascript" src="../Public/Js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="../Public/Js/Validform/Validform.css" />
<script type="text/javascript" src="../Public/Js/Validform/Validform.js"></script>
<script type="text/javascript" src="../Public/Js/common.js"></script>
<script>
var url = "__ROOT__";
var type = "<?php echo (MODULE_NAME); ?>";
</script>
</head>
<div class="z_tips ">
<?php if(isset($message)): ?><span class="true red">操作成功</span>
<?php else: ?>
    <span class="false red">操作失败 : <?php echo($error); ?> <?php echo($message); ?></span><?php endif; ?>
<p class="detail"></p>
<p>将在<span class="red" id="wait"><?php echo($waitSecond); ?></span>秒钟后自动跳转页面 如果不想等待请点击  <a id="href" href="<?php echo($jumpUrl); ?>">这里</a> 返回</p>
</div>

<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
    var time = --wait.innerHTML;
    if(time == 0) {
        location.href = href;
        clearInterval(interval);
    };
}, 1000);
})();
</script>

</body>
</html>