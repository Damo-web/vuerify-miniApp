<?php
	class ContactAction extends PublicAction{
		function __construct()
		{
		

			Load("extend");
			parent::__construct();

		}
		public function index(){
			$_GET['id']='2';
			if($_GET['id'])
			{
				$id = intval($_GET['id']);
			    $article = M('article')->where("`id`=$id")->find();
			    $this->assign('article',$article);	
			    $this->assign('bz','a'.$id);
			    $this->assign('upclass',$article['upclass']);
				$this->assign('title_en',$article['title_en']);
			    $contact_us = M('article')->where("`id`=4")->find();
				$this->assign('contact_us',$contact_us);
				//页面title
			$title = $article['title'].'_'.$this->config('web_name');
			$this->assign('title',$title);
			if(is_null($article['keywords']))
			{
				$keywords=$article['keywords'];
			}
			else
			{
				$keywords=$this->config('web_keywords');
			}
			$this->assign('keywords',$keywords);
			if(is_null($article['description']))
			{
				$description=$article['description'];
			}
			else
			{
				$description=$this->config('web_description');
			}
			$this->assign('description',$description);
                
			}
			else
			{
				
			}
			$this->display();
		}
	}
?>