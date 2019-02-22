<?php
/**
 * 后台招聘管理
 * Enter description here ...
 * @author Administrator
 *
 */
class JobsAction extends BaseAction {
	/**
	 * 
	 * Enter description here ...
	 */
	public function __construct()
	{
		parent::__construct("Jobs",'jobs');
	}
	
	public function index()
	{
		$type=$this->_get('type');

		$_SESSION['check_type'] = $type;

		if(!$type){
			import('ORG.Util.Page');
			$count      = $this->_model->where($this->_where)->count();// 查询满足要求的总记录数
			$Page       = new Page($count);// 实例化分页类 传入总记录数和每页显示的记录数
			$Page->setConfig('theme','<span>%totalRow% %header% %nowPage%/%totalPage% 页</span>  %first%  %upPage% %linkPage%  %downPage% %end% %select%');
			$show       = $Page->show();// 分页显示输出
			$list = $this->_model->where($this->_where)->limit($Page->firstRow.','.$Page->listRows)->order('`order` desc,id desc')->select();
			$result = D('Type')->select();
			foreach($result as $key=>$value)
			{
				$category[$value['id']] = $value['name'];
			}
			foreach($list as $key=>$value)
			{
				$list[$key]['cate_name'] = $category[$value['pid']];
			}
			$this->select_category();
			
			$search = array('value'=>'job');
			$this->assign('search', $search);
			$this->assign('list',$list);// 赋值数据集
			$this->assign('page',$show);// 赋值分页输出
			
			$this->display('index');
		}else{
			//显示该类别下所有产品
	    	import('ORG.Util.Page');
	    	$w['code']=array('like','%,'.$type.',%');
	    	$result=M("Type")->where($w)->order('code')->select();
	    	foreach ($result as $key => $value) {
	    		$pidarray.=$value['id'].',';
	    	}
	    	$pidarray=substr($pidarray, 0,-1);
	    	$where['pid']=array('in',$pidarray);

			$count      = M('Jobs')->where($where)->count();// 查询满足要求的总记录数
			$Page       = new Page($count);// 实例化分页类 传入总记录数和每页显示的记录数
			$Page->setConfig('theme','<span>%totalRow% %header% %nowPage%/%totalPage% 页</span>  %first%  %upPage% %linkPage%  %downPage% %end% %select%');
			$show       = $Page->show();// 分页显示输出
			$list = M('Jobs')->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('`order` desc,id desc')->select();

			//类别
			foreach($list as $key=>$value)
			{
				$list[$key]['cate_name'] = M('Type')->where("`id`={$value['pid']}")->getField('name');
			}
			$this->select_category();
			$search = array('name'=>'code', 'value'=>'title');
			$this->assign('search', $search);
			$this->assign('list',$list);// 赋值数据集
			$this->assign('page',$show);// 赋值分页输出
			$this->display('index');
		}
		
		
	}
	
  /**
     * 基础添加方法
     * Enter description here ...
     */
    function add($template = null)
    {
    	if($_POST)
    	{
    		// print_r($_POST);
    		// exit;
    		if($_FILES['img']['size'] != 0)
    		{
				$img_name = $this->UploadFile();
				//z($img_name);
				$_POST['img'] = $img_name[1];
    		}
			
			if($this->_model->create())
			{
				$id = $this->_model->add($_POST);
	    		if($id)
	    		{
	    			$url = '__GROUP__/'.$this->_action_name.'/Index';
	    			$this->success('添加成功',$url, C('JUMP_TIME'));
	    		}else
	    		{
	    			$this->error('添加失败');
	    		}
			}else
			{
				$this->error($this->_model->getError());
			}
    		exit;
    	}
    	
		$search = array('value'=>'job');
		$this->assign('search', $search);
    	$this->select_category();
    	$this->assign('title_type', '新增');
    	if($template == null)
		{
			$this->display('edit');
		}else{
			$this->display($template);
		}
    	//$this->display('edit');
    }
        
    /**
     * 基础编辑方法
     * Enter description here ...
     */
    function edit($template = null)
    {
    	if($_POST)
    	{
    		if($_FILES['img']['size'] != 0)
    		{
				$img_name = $this->UploadFile();
				$_POST['img'] = $img_name[1];
    		}
    		
    		if($this->_model->create())
			{
	    		$id = $this->_model->save($_POST);
	    		if($id)
	    		{
	    			$check_type = $_SESSION['check_type'];
	    			unset($_SESSION['check_type']);

	    			if($check_type != null){
	    				$url = '__GROUP__/'.$this->_action_name.'/Index/type/'.$check_type;
	    			}else{
	    				$url = '__GROUP__/'.$this->_action_name.'/Index';
	    			}
	    			$this->success('更新成功',$url);
	    		}else
	    		{
	    			$this->error('数据没有保存或没有修改');
	    		}
			}else 
			{
				$this->error($this->_model->getError());
			}
    		exit;
    	}
    	$this->select_category();
    	
		$search = array('value'=>'job');
		$this->assign('search', $search);
    	$this->assign('title_type', '修改');
    	
    	$info = D($this->_model_name)->find($_REQUEST['id']);
    	$this->assign('info',$info);
    	if($template == null)
		{
			$this->display();
		}else{
			$this->display($template);
		}
    }
	
	public function search()
    {
    	 //z($_POST);
    	//print_r($_REQUEST);
    	foreach($_REQUEST as $key=>$value)
    	{
    		if($key !== '_URL_'){
    			$value = trim($value);
    			$this->_where[$key] = array('like','%'.$value.'%');
    		}
    	}
    	
    	//z($this->_where);
    	
    	import('ORG.Util.Page');
		$count      = $this->_model->where($this->_where)->count();// 查询满足要求的总记录数
		$Page       = new Page($count);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出
		$list = $this->_model->where($this->_where)->order('`order` desc,id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		$result = D('Type')->select();
		foreach($result as $key=>$value)
		{
			$category[$value['id']] = $value['name'];
		}
		foreach($list as $key=>$value)
		{
			$list[$key]['cate_name'] = $category[$value['pid']];
		}
		$this->select_category();
		
    	$search = array('value'=>'job');
		$this->assign('search', $search);
		$this->assign('set_title', $_REQUEST['job']);
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display('index');
    }
	
    //青峰招聘
    public function qfjob(){
    	$w['key']='qfjob';
    	if($this->_post()){
    		$qfcode=$this->_post('qfcode');
    		$data['value']=$qfcode;
    		$r=M('config')->where($w)->save($data);
    		if($r){
    			$this->success('修改成功！','__GROUP__/Jobs/qfjob',C('JUMP_TIME'));
    		}else{
    			$this->error('添加失败！','__GROUP__/Jobs/qfjob');
    		}
    	}
    	$qfcode=M('config')->where($w)->getField('value');
    	$status=M('config')->where($w)->getField('group_id');
    	$this->assign('qfcode',$qfcode);
    	$this->assign('status',$status);
    	$this->display();

    }

}