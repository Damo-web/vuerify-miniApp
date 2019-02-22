<?php

	class IndexAction extends PublicAction{
		function __construct()
		{
			Load("extend");
			parent::__construct();
		}

		public function index(){
			$news_id  = $this->getTypeID(NEWS);
			$product_id = $this->getTypeID(PRODUCT);
			
			$this->assign('bz','0');
			$in_products=$this->pro_goods(2,4);
			$this->assign('in_products',$in_products);
			$in_case1=$this->ar_news(9,4);
			$this->assign('in_case1',$in_case1);
			$in_case2=$this->ar_news(10,4);
			$this->assign('in_case2',$in_case2);
			$in_case3=$this->ar_news(8,4);
			$this->assign('in_case3',$in_case3);
			
			$in_news=$this->ar_news(4,7);
			$this->assign('in_news',$in_news);

			$in_news2=$this->ar_news(11,7);
			$this->assign('in_news2',$in_news2);
			
			$in_video = M('article')->where('`id`=10')->find();
			$this->assign('in_video',$in_video);
			$article = M('article')->where('`id`=3')->find();
			$this->assign('intro',$article);
		
			$article2 = M('article')->where('`id`=6')->find();
			$this->assign('intro2',$article2);
            $in_newstop = M('article')->where("`pid` in(".$news_id.") AND `is_top`=1")->find();	
            $this->assign('in_newstop',$in_newstop);
			//页面title
			$title = $this->config('web_name');
			$this->assign('title',$title);
			$keywords=$this->config('web_keywords');
			$this->assign('keywords',$keywords);
			$description=$this->config('web_description');
			$this->assign('description',$description);
			$this->display();
		
		}

		public function sitemap(){
			$single=M('article')->where("`pid`=0 and `system`='0'")->select();
			$listpage=M('type')->where("`parent`='1' and `id` != '4' and `id` !='5'")->select();
			$this->assign('single',$single);
			$this->assign('listpage',$listpage);
			$this->display();
		}

		
	}
?>