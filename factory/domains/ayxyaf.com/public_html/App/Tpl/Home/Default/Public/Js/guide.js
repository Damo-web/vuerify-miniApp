$(function(){
	//滚动事件
	$(window).scroll(function(){
		var height = $(window).height() +　$(window).scrollTop();
		
        var height2 = $('#products').offset().top;
        var height3 = $('.ys2').offset().top;
        var height4 = $('#about').offset().top;
        if(height >= height2)
		{
			$(".products_p1 a").addClass('animated pulse');
			
		}

		if(height >= height3)
		{
			$(".ys1a1").addClass('animated tada');
			setTimeout(function (){$('#ysli1').animate({ opacity: 1},300).addClass('animated slideInLeft');},300);
            setTimeout(function (){$('#ysli2').animate({ opacity: 1},300).addClass('animated fadeInDown');},300);
            setTimeout(function (){$('#ysli3').animate({ opacity: 1},300).addClass('animated fadeInUp');},300);
            setTimeout(function (){$('#ysli4').animate({ opacity: 1},300).addClass('animated fadeInDown');},300);
            setTimeout(function (){$('#ysli5').animate({ opacity: 1},300).addClass('animated slideInRight');},300);
	

		}
		if(height >= height4)
		{
			$(".abouta1").addClass('animated zoomIn');
			$(".about_ul").addClass('animated slideInRight');
			$(".about_a1").addClass('animated slideInLeft');
		   

		}
	
       
		
	});		

});
