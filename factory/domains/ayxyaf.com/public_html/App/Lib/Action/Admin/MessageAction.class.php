<?php
/**
 * 后台留言管理
 * Enter description here ...
 * @author Administrator
 *
 */
class MessageAction extends BaseAction {
	/**
	 * 
	 * Enter description here ...
	 */
	public function __construct()
	{
		parent::__construct("Message",'message');
	}
	public function index()
	{
		
		import('ORG.Util.Page');
		$count      = $this->_model->where($this->_where)->count();// 查询满足要求的总记录数
		$Page       = new Page($count);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig('theme','<span>%totalRow% %header% %nowPage%/%totalPage% 页</span>  %first%  %upPage% %linkPage%  %downPage% %end% %select%');
		$show       = $Page->show();// 分页显示输出

		$list = $this->_model->where($this->_where)->limit($Page->firstRow.','.$Page->listRows)->order('`order` desc,id desc')->select();
		//z($list);
		$search = array('value'=>'name');
		$this->assign('search', $search);
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('is_shows','-1');
		$this->display('index');
	}
	public function edit()
	{
		if($_POST)
        {
		$_POST['is_show'] = 1;
		}
		parent::edit();
	}
	public function more()
	{
		   $info = D($this->_model_name)->find($_REQUEST['id']);
    	    $this->assign('info',$info);
		    
		  $this->display("more");
	}
	function search()
	{
		
		if($_REQUEST['is_shows'] != '-1')
        {
			 $where['is_show']=$_REQUEST['is_shows'];
        }
		$this->assign('is_shows',$_REQUEST['is_shows']);
		
		import('ORG.Util.Page');
		$count      = $this->_model->where($where)->count();// 查询满足要求的总记录数
		$Page       = new Page($count);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig('theme','<span>%totalRow% %header% %nowPage%/%totalPage% 页</span>  %first%  %upPage% %linkPage%  %downPage% %end% %select%');
		$show       = $Page->show();// 分页显示输出

		$list = M('Message')->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('`order` desc,id desc')->select();
		//z($list);
		$search = array('value'=>'name');
		$this->assign('search', $search);
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display('index');
		
    }
}