<?php
	class OrderAction extends PublicAction{
		function __construct()
		{
		

			Load("extend");
			parent::__construct();

		}
		public function index(){
			$pid     = $this->getTypeID(PRODUCT);
			$product = M('goods')->field('`id`,`title`')->where("pid in ($pid)")->select();

			$this->assign('product',$product);
			$this->assign('bz','102');
			$title = '在线订单_'.$product['title'].'_'.$this->config('web_name');
			$this->assign('title',$title);
			$keywords=$this->config('web_keywords');
			$this->assign('keywords',$keywords);
			$description=$this->config('web_description');
			$this->assign('description',$description);
			$this->display();
		}
		public function add_order(){
			if($_SESSION['verify']!=md5($_POST['captcha'])){
				$this->error('验证码错误','index');
			}

			$order = M('order');
			$this->safe();
			$data  = $_POST;
			if(M('order')->add($data)){
				$this->success('订单成功');	
			}else{
				$this->error('订单失败,请稍候再试');
			}
			
		}
	}
?>