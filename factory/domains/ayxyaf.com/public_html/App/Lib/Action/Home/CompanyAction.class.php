<?php
	class CompanyAction extends PublicAction{
		function __construct()
		{
		

			Load("extend");
			parent::__construct();

		}
		public function index(){
			$article = M('article')->where('`id`=1')->find();			
			    $this->assign('article',$article);	
			    $this->assign('bz','a'.$id);
			    $this->assign('upclass',$article['upclass']);
				$this->assign('title_en',$article['title_en']);
				//seo
				$title = $article['title'].'_'.$this->config('web_name');
			    $keywords   = $article['keywords'];
			    $description = $article['description'];
                $this->header_seo($title, $keywords, $description);
			$this->display();
		}
	}
?>