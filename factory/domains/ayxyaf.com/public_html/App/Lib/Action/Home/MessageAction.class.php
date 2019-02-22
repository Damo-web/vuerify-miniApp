<?php
	class MessageAction extends PublicAction{
		
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
			$this->assign('bz','101');
			$this->assign('upclass','在线留言');
			//页面title
			$title = '在线留言_'.$this->config('web_name');
			$this->assign('title',$title);
			$keywords=$this->config('web_keywords');
			$this->assign('keywords',$keywords);
			$description=$this->config('web_description');
			$this->assign('description',$description);
			$this->display();
		}
		public function add_message(){
			if($_SESSION['verify']!=md5($_POST['captcha'])){
				$this->error('验证码错误！');
			}
			$message = M('message');
			$this->safe();
			$data   = $_POST;

			$data['ip'] = $_SERVER['REMOTE_ADDR'];

			if(M('message')->add($data)){
				$this->success('留言成功');	
			}else{
				$this->error('留言失败,请稍候再试');
			}	
		}
		//不带验证码的添加方法
		public function add_message1(){
			$message = M('message');
			$this->safe();
			$data   = $_POST;

			$data['ip'] = $_SERVER['REMOTE_ADDR'];

			if(M('message')->add($data)){
				$this->success('留言成功');	
			}else{
				$this->error('留言失败,请稍候再试');
			}	
		}
	}
?>