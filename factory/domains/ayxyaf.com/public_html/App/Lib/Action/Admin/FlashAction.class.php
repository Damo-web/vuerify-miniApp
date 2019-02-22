<?php
/**
 * 系统配置管理
 * Enter description here ...
 * @author Administrator
 *
 */
class FlashAction extends BaseAction {
    function __construct()
    {
    	parent::__construct('Flash','Flash');
    }
    
    public function pc()
	{
		$where = 'pc_m = 0';
		$list = $this->_model->where($where)->order('`order` desc,id desc')->select();
		$this->assign('pc_m',$pc_m);
		$this->assign('list',$list);
		$this->display();
	}

	public function m()
	{
		$where = 'pc_m = 1';
		$list = $this->_model->where($where)->order('`order` desc,id desc')->select();
		$this->assign('pc_m',$pc_m);
		$this->assign('list',$list);
		$this->display();
	}
}