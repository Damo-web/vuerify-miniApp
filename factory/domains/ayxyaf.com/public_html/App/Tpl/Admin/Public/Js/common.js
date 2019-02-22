//公用js函数库 需要jQuery支持
$(function(){

    $("#lay_menu").find(".item_cont").hide()
    function layout(){
        var reset = function(){
            var htmlHeight = $("html").height();
            var docHeight = document.documentElement.clientHeight;
            
            var iframe = $("#iframe");
            var sideHeight = $("#lay_sidebar").height();
            var topMenuHeight = $("#topMenu").height();
            var logoHeight = $("#logo").height();
            var lay_menuHeight = $("#lay_menu").height();
            var copyright = $("#copyright");
            var copyrightHeight = copyright.height();
            
            
            // 如果logo+左侧菜单的高度大于窗口高度
            if((copyrightHeight + logoHeight + lay_menuHeight) > docHeight){
                //copyright.css({position:"relative"})
                copyright.css({'position':"relative"});
                $('#lay_sidebar').css({'width':'250px','overflow':'auto'});
                iframe.stop().animate({height:logoHeight + lay_menuHeight + copyright.height() - topMenuHeight},100)
            }else{
                //copyright.css({position:"absolute"})
                copyright.css({'bottom':'0','position':'absolute'});
                iframe.stop().animate({height:docHeight - topMenuHeight - 2},100)
            }
        }

        reset()
        $(window).resize( function(){
            setTimeout(reset,100)
        });
    }
    layout()


    var f = false;
    $("#side_show").click(function(){
        if(f){
            $(this).removeClass("show_side")
            $("#lay_main").css({"margin-left":"233px"})
            $("#lay_sidebar").show();
            f = false;
        }else{
            $(this).addClass("show_side")
            $("#lay_main").css({"margin-left":"0px"})
            $("#lay_sidebar").hide();
            f = true;
        }
    
    })

    $("#lay_menu").find(".item_tit").each(function(){
        $(this).bind("click",function(i){
        	$(".item_cont").slideUp('normal');
            if( !$(this).hasClass("on") ){
            	$(".item_tit").removeClass("on");
                $(this).addClass("on");
                $(this).next().slideDown('normal');
            }else{
            	$(".item_tit").removeClass("on");
                $(this).next().slideUp('normal');
            }
        })
    })

    //变换浏览器可视窗口高度，目录随之改变设置
    $(window).resize(function() {
  		var docHeight = $(window).height();
  		var logoHeight = $("#logo").height();
        var lay_menuHeight = $("#lay_menu").height();
        var copyrightHeight = $("#copyright").height();
        if((copyrightHeight + logoHeight + lay_menuHeight) > docHeight){
        	$('#lay_sidebar').css({'width':'250px','overflow':'auto'});
			$("#copyright").css({'position':'relative','bottom':''});
        }else{
        	$('#lay_sidebar').css({'width':'233px','overflow':''});
			$("#copyright").css({'bottom':'0','position':'absolute'});
        }
	})



    $("#lay_menu").find(".item_cont a").click(function(){
        $("#lay_menu").find(".item_cont a").removeClass("on");
        $(this).addClass("on")
    
    })
    
    //登录框输入框默认选择
    $("#username").focus();
    
	$(".tableMod table tr").hover(
		function () {
			$(this).addClass("hover");
		},
		function () {
			$(this).removeClass("hover");
		}
	);
	
	//$("#web_watermark").parent().parent().hide();
	var s = $('input:radio[name="switch_watermark"]:checked').val();
	if(s == '0')
	{
		$("#web_watermark").parent().parent().hide();
	}
	$('input:radio[name="switch_watermark"]').click(function(){
		if($(this).val() == '0')
		{
			$("#web_watermark").parent().parent().hide();
		}else
		{
			$("#web_watermark").parent().parent().show();
		}
	});
	
	//点击修改排序
	$(".order").click(function(){
		var order_var = $(this).html();
		if(order_var >= 0)
		{
			$(this).html("<input type='text' id='order_ajax' class='txt'  size='2' value="+order_var+" />");
			$("#order_ajax").focus();
			$("#order_ajax").select();
		}
	});
	$("#order_ajax").live("blur", function(){
		var order_var = $("#order_ajax").val();
		var id = $("#order_ajax").parent().parent().children("td:first").children("input").val();
		$("#order_ajax").parent().html(order_var);
		
		//order_ajax();
		$.getJSON(url+"/Admin/"+type+"/ajax/t/order/id/"+id+"/value/"+order_var, function(data){
			//alert(data.data);//提示信息
		});		
	});

	try{
		// 加入表单验证
		$('.validform').Validform({
			tiptype:3,		
		}).addRule([
			{
		        ele:"#pid",
		        datatype:"/^(?!1$).+$/",	        
		        nullmsg:"请选择所属类别！",
		        errormsg:"该分类下不允许添加内容！" 
		    },
		]);
	}catch(e){}
})


var n;
function fun(n){
	//记录之前点击目录得到的标记 ‘0’标识刚登陆系统时，未点击过
	var num_old = $("#hiddenId").val();
	//记录本次点击目录得到的标记
	$("#hiddenId").val(n);
	var num_new = $("#hiddenId").val();
	//得到目录未点击过的目录的高度
	var num = $('#lay_menu').children('dt').size();
	var h = $('#lay_menu').children('dt').height();
	var dtHeight = num * (h+1) + 1;
	//本次点击目录得到子目录的高度
	var conHeight = $(".con"+n).height();
	//得到目录未变化时，目录的高度
	var lay_menuHeight = $("#lay_menu").height();
	//内容的头部条的高度
	var topMenuHeight = $("#topMenu").height();
	//logo的高度
	var logoHeight = $("#logo").height();
	//版本提示的  高度
	var copyrightHeight = $("#copyright").height();
	//浏览器当前窗口可视区域高度
	var docHeight = document.documentElement.clientHeight;
	var allHeight;
	if(parseInt(num_old) == parseInt(num_new)){
		if($('.item_tit').hasClass('on')){
			allHeight = dtHeight + logoHeight + copyrightHeight;
			if(allHeight > docHeight){
				$('#lay_sidebar').css({'width':'250px','overflow':'auto'});
				$("#copyright").css({'position':'relative','bottom':''});
				$("#copyright").animate({marginTop:'0px'});
			}else{
				$('#lay_sidebar').css({'width':'233px','overflow':''});
				$("#copyright").css({'bottom':'0','position':'absolute'});
				$("#copyright").animate({marginTop:'1px'});
			}
		}else{
			allHeight = dtHeight + conHeight + logoHeight + copyrightHeight;
			if(allHeight > docHeight){
				$('#lay_sidebar').css({'width':'250px','overflow':'auto'});
				$("#copyright").css({'position':'relative','bottom':''});
				$("#copyright").animate({marginTop:'0px'});
			}else{
				$('#lay_sidebar').css({'width':'233px','overflow':''});
				$("#copyright").css({'bottom':'0','position':'absolute'});
				$("#copyright").animate({marginTop:'1px'});
			}
		}
	}else{
		if(parseInt(num_old) == ''){
			allHeight = dtHeight + conHeight + logoHeight + copyrightHeight;
			if(allHeight > docHeight){
				$('#lay_sidebar').css({'width':'250px','overflow':'auto'});
				$("#copyright").css({'position':'relative','bottom':''});
				$("#copyright").animate({marginTop:'0px'});
			}
		}else{
			allHeight = dtHeight + conHeight + logoHeight + copyrightHeight;
			if(allHeight > docHeight){
				$('#lay_sidebar').css({'width':'250px','overflow':'auto'});
				$("#copyright").css({'position':'relative','bottom':''});
				$("#copyright").animate({marginTop:'0px'});
			}else{
				$('#lay_sidebar').css({'width':'233px','overflow':''});
				$("#copyright").css({'bottom':'0','position':'absolute'});
				$("#copyright").animate({marginTop:'1px'});
			}
		}
	}
}



/**
 * 
 */
function logout(url){

    //后台退出使用
    if(confirm('是否确认安全退出？'))
    {
    	window.location.href=url;
    	return true;
    }else
    {
    	return false;
    }
}
/**
 * 开发测试使用
 * @param n
 */
function returnHeight(n){
	alert(n)
}

/**
 * 验证码刷新
 * @author wangyong
 */
function refreshVerify(url)
{
	timestamp=new Date().getTime();
	$('#verifyImg').attr('src',url+timestamp);
}

/**
 * 全选checkbox,注意：标识checkbox id固定为为check_box
 * @param string name 列表check名称,如 uid[]
 */
function selectall(name) {
	if ($("#check_box").attr("checked")=='checked') {
		$("input[name='"+name+"']").each(function() {
			this.checked=true;
		});
	} else {
		$("input[name='"+name+"']").each(function() {
			this.checked=false;
		});
	}
}

function check_select(msg)
{
    var msg = msg;
    var ids = '';
    $("input[type=checkbox]").each(function(){ //由于复选框一般选中的是多个,所以可以循环输出 
        if($(this).attr("checked") == 'checked')
        {
            ids += $(this).val()+","; 
        }
    });
    ids=ids.substring(0,ids.length-1);
    if(ids == '')
    {
        if(!msg){
            msg = '请选择要删除的内容！';
        }
        alert(msg);
        return false;
    }else{
        return ids;
    }
}

function batch_del(e,type,confirm_msg)
{
	ids = check_select();
    if(ids == ''){
        return false;
    }
    var confirm_msg = confirm_msg;
    if(confirm_msg){
        confirm_msg = confirm_msg;
    }else{
        confirm_msg = '是否确认删除！';
    }
    if(confirm(confirm_msg))
	{
		$.getJSON(url+"/Admin/"+type+"/ajax/t/batch_del/ids/"+ids, function(data){			
			if(data.status == '1')
			{
				// $("input[type=checkbox]").each(function(){ //由于复选框一般选中的是多个,所以可以循环输出 
				// 	if($(this).attr("checked") == 'checked')
				// 	{
				// 		$(this).parent().parent().html('');
				// 	}
				// });
				window.location.reload();
			}else{
				alert(data.info);
			}
		})
	}
}


/**
 * 删除
 * @param type
 * @param id
 */
function del(e,type, id)
{
	if(confirm('是否确认删除！'))
	{
		$.getJSON(url+"/Admin/"+type+"/ajax/t/del/id/"+id, function(data){

			//alert(data.data);//提示信息
			if(data.status == '1')
			{
				// $(e).parent().parent().html('');
				window.location.reload();
			}else{
				alert(data.info);
			}
		})
	}
}
/**
 * 删除分类
 * @param type
 * @param id
 */
function cate_del(e,type, id)
{
	if(confirm('是否确认删除！删除分类将会删除该分类下的所有产品信息！'))
	{
		$.getJSON(url+"/Admin/"+type+"/ajax/t/cate_del/id/"+id, function(data){

			//alert(data.data);//提示信息
			if(data.status == '1')
			{
				// $(e).parent().parent().html('');
				window.location.reload();
			}
		})
	}
}

/**
 * smart 数据库表优化修复
 * @param e
 * @param type
 * @param names
 */
function optimization(type,names)
{
	if(names == '')
	{
		var ids = '';
		$("input[type=checkbox]").each(function(){ //由于复选框一般选中的是多个,所以可以循环输出 
			if($(this).attr("checked") == 'checked')
			{
				ids += $(this).val()+","; 
			}
		});
		ids=ids.substring(0,ids.length-1);
		if(ids == '')
		{
			alert('请先选择需要处理的表！');
			return false;
		}
		names = ids;
	}
	$.getJSON(url+"/Admin/Smart/ajax/t/"+type+"/name/"+names, function(data){
	
		//alert(data.data);//提示信息
		if(data.status == '1')
		{
			alert(data.data);
			window.location.reload();
		}else{
            alert(data.data);
            window.location.reload();
        }
	})
}
/**
 * 图标旋转
 * @param type
 * @param id
 */
$(document).ready(function(){
    $(".item_tit").hover(
			function(){$(this).find('i').addClass('rotate')},
			function(){$(this).find('i').removeClass('rotate')}
	);
});
/**
 * 修改信息
 * @param type
 * @param id
 */
function edit(type, id)
{
	
}

function filter($str)
{
	return trim($str);
}

function jump()
{
	
}