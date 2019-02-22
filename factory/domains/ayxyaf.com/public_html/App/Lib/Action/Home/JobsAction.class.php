<?php
	class JobsAction extends PublicAction{
		function __construct()
		{
		

			Load("extend");
			parent::__construct();

		}
		public function index(){
			import("ORG.Util.Page");
			
			$job_id = $this->getTypeID(JOBS);

			$count   = M('jobs')->where("`pid` in ($job_id)")->count();

			$page_jobs = $this->config('page_jobs');
			$page    = new Page($count,$page_jobs ? $page_jobs : $this->config('page_default'));
			
			$jobs = M('jobs')->where("`pid` in ($job_id)")
							 ->order('`order` desc,`id` desc')
							 ->limit($page->firstRow.','.$page->listRows)
							 ->select();
						 
			foreach($jobs as $key=>$value)
			{
				$jobs[$key]['url'] = __APP__.'/jobs/'.$value['id'];
			}
			$this->header_seo();		 
			$this->assign('page',$page->show());
			$this->assign('list',$jobs);
			$this->assign('bz','100');
			$this->assign('upclass','人才招聘');
			//页面title
			$title = '人才招聘_'.$this->config('web_name');
			$this->assign('title',$title);
			$keywords=$this->config('web_keywords');
			$this->assign('keywords',$keywords);
			$description=$this->config('web_description');
			$this->assign('description',$description);
			$this->display();
		}

		public function jobs_info(){
			
			$id = intval($_GET['id']);
			
			$jobs = M('jobs')->where("`id`=$id")->find();

			if(!$jobs) $this->_404();

			$this->assign('jobs',$jobs);
			$this->assign('bz','100');
			$this->assign('upclass','人才招聘');
			//页面title
			$title = $jobs['job'].'_'.'人才招聘_'.$this->config('web_name');
			$this->assign('title',$title);	
			if(isset($jobs['keywords']))
			{
				$keywords=$jobs['keywords'];
			}
			else
			{
				$keywords=$this->config('web_keywords');
			}
			$this->assign('keywords',$keywords);
			if(isset($jobs['description']))
			{
				$description=$jobs['description'];
			}
			else
			{
				$description=$this->config('web_description');
			}
			$this->assign('description',$description);
			$this->display();
		}

		public function seek_job(){
			$id  = intval($_GET['id']);
			$job = M('jobs')->where("`id`=$id")->find();
			if(!$job){
				$this->_404();	
			}
			$this->assign('job',$job);
			$this->assign('bz','100');
			$this->assign('upclass','人才招聘');
			//页面title
			$title = $job['job'].'_'.'人才招聘_'.$this->config('web_name');
			$this->assign('title',$title);	
			if(isset($job['keywords']))
			{
				$keywords=$job['keywords'];
			}
			else
			{
				$keywords=$this->config('web_keywords');
			}
			$this->assign('keywords',$keywords);
			if(isset($job['description']))
			{
				$description=$job['description'];
			}
			else
			{
				$description=$this->config('web_description');
			}
			$this->assign('description',$description);
			$this->display();
		}

		public function add_job(){
			if($_SESSION['verify']!=md5($_POST['captcha'])){
				$this->error('验证码错误');
			}

			$order = M('apply');
			$this->safe();
			if($order->add($_POST)){
				$this->success('信息提交成功');	
			}else{
				$this->error('信息提交失败,请稍候再试');
			}
		}
	}
?>