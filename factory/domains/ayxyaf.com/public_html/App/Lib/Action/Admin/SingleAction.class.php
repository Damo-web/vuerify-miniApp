<?php
/**
 * 后台单页管理
 * Enter description here ...
 * @author Administrator
 *
 */
class SingleAction extends BaseAction {
	/**
	 * 
	 * Enter description here ...
	 */
	public function __construct()
	{
		parent::__construct("Single",'Article');
	}
	
	/**
	 * 单页管理
	 * Enter description here ...
	 */
    public function index()
    {
		$where = 'pid = 0';
		$this->setWhere($where);
    	$search = array('value'=>'title');
		$this->assign('search', $search);
		$input_hidden = '<input type="hidden" name="pid" value="0" >';
    	$this->assign('input_hidden', $input_hidden);
		parent::index();
    }

    /**
     * 新增单页
     * Enter description here ...
     */
    public function add()
    {
    	$this->assign('single','1');

    	$search = array('value'=>'title');
		$this->assign('search', $search);
		$input_hidden = '<input type="hidden" name="pid" value="0" >';
    	$this->assign('input_hidden', $input_hidden);
    	parent::add();
    }
    
 	/**
     * 编辑单页
     * Enter description here ...
     */
    public function edit()
    {
    	$this->assign('single','1');
    	
   
    	parent::edit();
    }
    
    public function search()
    {
    	 $input_hidden = '<input type="hidden" name="pid" value="0" >';
    	 $this->assign('input_hidden', $input_hidden);
		 $this->assign('set_title', $_REQUEST['title']);
    	 parent::search();
    }
}