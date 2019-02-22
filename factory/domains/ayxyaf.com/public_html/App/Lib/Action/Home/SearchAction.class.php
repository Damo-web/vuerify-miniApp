<?php
/**
 * 产品搜索控制器
 */
class SearchAction extends PublicAction{
        function __construct()
		{
		

			Load("extend");
			parent::__construct();

		}
	public function index(){
		$keyword=htmlspecialchars($_GET['keyword']);
		if (!$keyword) {
			$this->_404();
		}
		import("ORG.Util.Page");
		$pid = $this->getTypeID(PRODUCT);
		$count   = M('goods')->where("`pid` in ($pid) and `title` like '%$keyword%'")->count();		
		if($count){
			$page_product = $this->config('page_product');
			$page    = new Page($count,$page_product ? $page_product : $this->config('page_default'));
			
			$product = M('goods')->where("`pid` in ($pid) and `title` like '%$keyword%'")
							     ->order('`order` desc,`id` desc')
							     ->limit($page->firstRow.','.$page->listRows)
							     ->select();
		}
		foreach($product as $key=>$value)
		{
			$product[$key]['url'] = __APP__.'/product/'.$value['pid'].'_'.$value['id'];
		}

		if($count) 
		{
			$this->assign('exist',true);
			$this->assign('page',$page->show());
		}				       
		$this->assign('list',$product);
		$this->assign('keyword',$keyword);


		$this->display();
		
	}	
}
?>
