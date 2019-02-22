<?php
	class ArticleAction extends PublicAction{
		
				/**
		 * 
		 * Enter description here ...
		 */
		function __construct()
		{
		

			Load("extend");
			parent::__construct();

		}
			
		public function index(){
			
				$id = intval($_GET['id']);
			    $article = M('article')->where("`id`=$id")->find();
		     	if(!$article) $this->_404();
			    $this->assign('article',$article);	
			    $this->assign('bz','a'.$id);
			    $this->assign('upclass',$article['upclass']);
				$this->assign('title_en',$article['title_en']);
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
			
			$this->display();
		}
	
	}
?>