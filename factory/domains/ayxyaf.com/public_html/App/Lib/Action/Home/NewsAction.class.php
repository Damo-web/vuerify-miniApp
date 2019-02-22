<?php
	class NewsAction extends PublicAction{
        function __construct()
		{
		

			Load("extend");
			parent::__construct();

		}
		public function index(){
			import("ORG.Util.Page");

			$news_id = $this->getTypeID(NEWS);
			
			$news_id = $this->getTypeID(5);
			
			$count   = M('article')->where("`pid` in ($news_id)")->count();
			if($count){
				$page    = new Page($count,$this->config('page_default'));

			    $news    = M('article')->where("`pid` in ($news_id)")
							   	   ->order('`order` asc,`time` desc')
							   	   ->limit($page->firstRow.','.$page->listRows)
							       ->select();
			}   
								   
			foreach($news as $key=>$value)
			{
				$news[$key]['url'] = __APP__.'/news/'.$value['pid'].'_'.$value['id'];
			}
			$this->header_seo();
			
			if($count) 
			{
				$this->assign('exist',true);
				$this->assign('page',$page->show());
			}
			$this->assign('list',$news);
			//页面title
			$title = $this->config('web_name');
			$this->assign('title',$title);
			$keywords=$this->config('web_keywords');
			$this->assign('keywords',$keywords);
			$description=$this->config('web_description');
			$this->assign('description',$description);
			$this->display();
			
		}

		public function news_info(){
			//新闻ID
			$id   = intval($_GET['id']);
			if($id > 0){
				$list = M('article')->where("`id`=$id")->find();
			}
			if(!$list){
				$this->_404();
				exit;
			}else{
				M('article')->where("`id`=$id")->setInc('click');
				$this->assign('list',$list);
			}
			$user=M('user')->field('username')->find();
			$this->assign('user',$user);
			
			//上下一条
			$all_list = M('article')->where("`pid` = ".$list['pid'])
							   	   ->order('`order` asc,`time` desc')
                                   ->select();//查询该类别下所有信息,注意这里的查询条件一定要与列表页面的查询条件一致
            $count=count($all_list);//获取所得数组总数
            for($i=0;$i<=$count;$i++)//循环数组
            {
                if($id==$all_list[$i]['id'])//匹配与本条id相同的元素
                {
                    $list_key=$i;//得到本条id的索引
                }
            }
            $prev=M('article')->where("`id`=".$all_list[$list_key-1]['id'])->find();//上一条
            $next=M('article')->where("`id`=".$all_list[$list_key+1]['id'])->find();//下一条
            $array['prev'] =  __APP__."/news/".$list['pid']."_".$prev['id'];//上一条url
            $array['next'] =  __APP__."/news/".$list['pid']."_".$next['id'];//下一条url
            $array['back'] =  __APP__."/news/".$list['pid'];//返回列表url
            $array['prev_title'] = $prev['title'];//上一条title
            $array['next_title'] = $next['title'];//下一条title
			$this->assign($array);
			//相关信息（待优化随机）
			$related=M('article')->where("`id`<>".$all_list[$list_key]['id']." AND `pid`=".$list['pid'])->order('`order` desc,`id` desc')->limit(8)
							   	 ->select();
			$this->assign("related",$related);
			$this->assign('type',$list['pid']);
			$this->assign('bz',$list['pid']);
			//面包屑
			$get_category_menu= $this->get_category_menu('news',' > ',$list['pid']);
			$this->assign('get_category_menu',$get_category_menu);
			//页面title
			$category=M('type')->where("`id`=".$list['pid'])->find();
			$this->assign('upclass',$category['upclass']);
			$title = $list['title'].'_'.$category['name'].'_'.$this->config('web_name');
			$this->assign('title',$title);
			$this->assign('titles',$category['name']);
			$this->assign('title_en',$category['title_en']);
			if(is_null($list['keywords']))
			{
				$keywords=$list['keywords'];
			}
			else
			{
				$keywords=$this->config('web_keywords');
			}
			$this->assign('keywords',$keywords);
			if(is_null($list['description']))
			{
				$description=$list['description'];
			}
			else
			{
				$description=$this->config('web_description');
			}
			$this->assign('description',$description);
			$this->display();
		}
		public function news_type(){
			import("ORG.Util.Page");
			//商品类型
			$type = intval($_GET['type']);
            $this->assign('type',$type);
			$this->assign('bz',$type);
			if($type > 0){
				$pid   = $this->getTypeID($type);
				$count = M('article')->where("`pid` in ($pid)")->count();
				if($count){
					$page    = new Page($count,$this->config('page_default'));
					
					$list = M('article')->where("`pid` in ($pid)")
									  ->order('`order` asc,`time` desc')
								      ->limit($page->firstRow.','.$page->listRows)
								      ->select();	
				}
			}else{
				$this->_404();
				exit;
			}

			if(!$count){
				$this->assign('exist',false);
			}else{
				foreach($list as $key=>$value)
				{
					$list[$key]['url'] = __APP__.'/news/'.$value['pid'].'_'.$value['id'];
				}
				$this->assign('exist',true);
				$this->assign('list',$list);
				$this->assign('page',$page->show());
			}
			//面包屑
			$get_category_menu= $this->get_category_menu('news',' > ',$type);
			$this->assign('get_category_menu',$get_category_menu);
			//页面title
			$category=M('type')->where("`id`=".$type)->find();
			$this->assign('category',$category);
			$this->assign('upclass',$category['upclass']);
			$title = $category['name'].'_'.$this->config('web_name');
			$this->assign('title',$title);
			$this->assign('titles',$category['name']);
			$this->assign('title_en',$category['title_en']);
			if(is_null($category['keywords']))
			{
				$keywords=$category['keywords'];
			}
			else
			{
				$keywords=$this->config('web_keywords');
			}
			$this->assign('keywords',$keywords);
			if(is_null($category['description']))
			{
				$description=$category['description'];
			}
			else
			{
				$description=$this->config('web_description');
			}
			$this->assign('description',$description);
			$this->display('index');
		}
	}
?>