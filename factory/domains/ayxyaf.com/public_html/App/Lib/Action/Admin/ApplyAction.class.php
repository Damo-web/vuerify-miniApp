<?php

/**

 * 后台招聘申请管理

 * Enter description here ...

 * @author Administrator

 *

 */

class ApplyAction extends BaseAction {

	/**

	 * 

	 * Enter description here ...

	 */

	public function __construct()

	{

		parent::__construct("Apply",'apply');

	}

	

	public function index()

	{

		import('ORG.Util.Page');

		$count      = $this->_model->where($this->_where)->count();// 查询满足要求的总记录数

		$Page       = new Page($count);// 实例化分页类 传入总记录数和每页显示的记录数

		$show       = $Page->show();// 分页显示输出

		$list = $this->_model->where($this->where)->order('id')->limit($Page->firstRow.','.$Page->listRows)->order('`order` desc,id desc')->select();

		$result = D('jobs')->select();

		$category[] = '所有';

		foreach($result as $key=>$value)

		{

			$category[$value['id']] = $value['job'];

		}

		foreach($list as $key=>$value)

		{

			$list[$key]['jobs'] = $category[$value['a_id']];

		}

		//z($category);

		//z($list);

		$search = array('name'=>'a_id', 'value'=>'name');

		$this->assign('search', $search);

		

		$this->assign('category', $category);

		

		$this->assign('list',$list);// 赋值数据集

		$this->assign('page',$show);// 赋值分页输出

		

		$this->display('index');

	}

	

	function info()

    {

    	$info = $this->_model->find($_REQUEST['id']);

    	$jobs_info = M('jobs')->find($info['a_id']);

    	//z($jobs_info);

    	$info['jobs'] = $jobs_info['job'];

    	$this->assign('info',$info);

    	

		$this->display();  	

    }

    

    

 	public function search($template = null)

    {

    	//z($_POST);

    	foreach($_POST as $key=>$value)

    	{
    		if($value)

    		{
    			$value = trim($value);
    			$this->_where[$key] = array('like','%'.$value.'%');

    		}

    	}

    	

    	//z($this->_where);

    	

    	import('ORG.Util.Page');

		$count      = $this->_model->where($this->_where)->count();// 查询满足要求的总记录数

		$Page       = new Page($count);// 实例化分页类 传入总记录数和每页显示的记录数

		$show       = $Page->show();// 分页显示输出

		$list = $this->_model->where($this->_where)->order('id')->limit($Page->firstRow.','.$Page->listRows)->order('`order` desc,id desc')->select();

		//die();

		$result = D('jobs')->select();

		$category[] = '所有';

		foreach($result as $key=>$value)

		{

			$category[$value['id']] = $value['job'];

		}

		foreach($list as $key=>$value)

		{

			$list[$key]['jobs'] = $category[$value['a_id']];

		}

		//z($category);

		//z($list);

		$search = array('name'=>'a_id', 'value'=>'name');

		$this->assign('search', $search);

		$this->assign('set_title', $_REQUEST['name']);

		$this->assign('category', $category);

		

		$this->assign('list',$list);// 赋值数据集

		$this->assign('page',$show);// 赋值分页输出

		

		$this->display('index');

    	

    }

}