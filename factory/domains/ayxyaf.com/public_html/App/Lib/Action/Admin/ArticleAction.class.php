<?php
/**
 * 后台首页框架首页
 * @author Administrator
 *
 */
class ArticleAction extends BaseAction {
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function __construct()
	{
		parent::__construct("Article",'Article');
	}

	public function index()
	{
		$p=$this->_get('p');
		if(!$p){
			$p = '1';
		}
		$type=$this->_get('type');

		$_SESSION['check_type'] = $type;

		if(!$type){
			$this->assign('p',$p);
			$where = 'pid != 0';
			$this->setWhere($where);
			parent::index_cate();
		}else{

			//显示该类别下所有信息
	    	import('ORG.Util.Page');
	    	$w['code']=array('like','%,'.$type.',%');
	    	$result=M("Type")->where($w)->order('code')->select();
	    	foreach ($result as $key => $value) {
	    		$pidarray.=$value['id'].',';
	    	}
	    	$pidarray=substr($pidarray, 0,-1);
	    	$where['pid']=array('in',$pidarray);


			$count      = M('Article')->where($where)->count();// 查询满足要求的总记录数
			$Page       = new Page($count);// 实例化分页类 传入总记录数和每页显示的记录数
			$Page->setConfig('theme','<span>%totalRow% %header% %nowPage%/%totalPage% 页</span>  %first%  %upPage% %linkPage%  %downPage% %end% %select%');
			$show       = $Page->show();// 分页显示输出
			$list = M('Article')->where($where)->order('id')->limit($Page->firstRow.','.$Page->listRows)->order('id desc')->select();

			//类别
			foreach($list as $key=>$value)
			{
				$list[$key]['cate_name'] = M('Type')->where("`id`={$value['pid']}")->getField('name');
			}
			$this->select_category_1();
			$search = array('name'=>'code', 'value'=>'title');
			$input_hidden = '<input type="hidden" name="category_type" value="'.$type.'" >';

    		$this->assign('input_hidden', $input_hidden);

    		$this->assign('selected_id', $_GET['type']);//查询选择分类后，保存当前分类

			$this->assign('search', $search);
			$this->assign('list',$list);// 赋值数据集

			$this->assign('page',$show);// 赋值分页输出
			$this->display('index');			
		}
	}


	public function links()
	{
		$where = 'pid = 6';

		import('ORG.Util.Page');
		$count = M('Article')->where($where)->count();
		$Page = new Page($count);
		$Page->setConfig('theme','<span>%totalRow% %header% %nowPage%/%totalPage% 页</span>  %first%  %upPage% %linkPage%  %downPage% %end% %select%');
		$show = $Page->show();// 分页显示输出

		$list = $this->_model->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('`order` desc,id desc')->select();
		$search = array('name'=>'code', 'value'=>'title');
		$input_hidden = '<input type="hidden" name="pid" value="6" >';
    	$this->assign('input_hidden', $input_hidden);
		$this->assign('search', $search);

		$this->assign('list',$list);
		$this->assign('page',$show);// 赋值分页输出
		$this->display();
	}

    public function search()
    {
    	$_REQUEST['title'] = trim($_REQUEST['title']);
    	if($_REQUEST['pid'] == 6){

			$this->_where['title'] = array('like','%'.$_REQUEST['title'].'%');

			$this->_where['pid'] = array('EQ', '6');

			import('ORG.Util.Page');
			$count = M('Article')->where($this->_where)->count();
			$Page = new Page($count);
			$Page->setConfig('theme','<span>%totalRow% %header% %nowPage%/%totalPage% 页</span>  %first%  %upPage% %linkPage%  %downPage% %end% %select%');
			$show = $Page->show();// 分页显示输出

			$list = $this->_model->where($this->_where)->limit($Page->firstRow.','.$Page->listRows)->order('`order` desc,id desc')->select();

			$search = array('name'=>'code', 'value'=>'title');
			$input_hidden = '<input type="hidden" name="pid" value="6" >';
    		$this->assign('input_hidden', $input_hidden);
			$this->assign('search', $search);

			$this->assign('set_title', $_REQUEST['title']);
			
			$this->assign('list',$list);
			$this->assign('page',$show);// 赋值分页输出
			$this->display('links');
			exit;
    	}else{
    		if($_REQUEST['pid'] == 1){
    			$this->_where['title'] = array('like','%'.$_REQUEST['title'].'%');
    			$this->_where['pid'] = array('NEQ', '0');
    			$re = $this->_model->where($this->_where)->select();
    			if($re){
			    	foreach ($re as $key => $value) {
			    		if($value['pid'] != 6){
			    			$id_all .= ','.$value['id'];
			    		}
			    	}
			    }
			    $this->assign('set_title', $_REQUEST['title']);
    		}else{
    			$where = "`id` = {$_REQUEST['pid']}";
    			$re = M('Type')->where($where)->select();
    			$code = $re[0]['code'];
    			$where1 = "code like '{$code}%'";

    			$re1 = M('Type')->where($where1)->select();

    			foreach ($re1 as $key => $value) {
    				$pid_all .= ','.$value['id'];
    			}
    			$pid_all = substr($pid_all,1);

    			$re2 = $this->_model->where("`pid` in ($pid_all)")->select();

    			if($_REQUEST['title'] == ''){
    				foreach ($re2 as $key => $value) {
	    				$id_all .= ','.$value['id'];
	    			}
    			}else{
    				$arr1 = array();
    				$arr2 = array();
    				foreach ($re2 as $key => $value) {
	    				$arr1[] = $value['id'];
	    			}
    				$this->_where['title'] = array('like','%'.$_REQUEST['title'].'%');
    				$this->_where['pid'] = array('NEQ', '0');
    				$re3 = $this->_model->where($this->_where)->select();
	    			if($re3){
				    	foreach ($re3 as $key => $value) {
				    		if($value['pid'] != 6){
				    			$arr2[] = $value['id'];
				    		}
				    	}
				    }
				    $arr = array_intersect($arr1,$arr2);
				    foreach ($arr as $key => $value) {
				    	$id_all .= ','.$value;
				    }
				    $this->assign('set_title', $_REQUEST['title']);
    			}
    		}
    		
		    $id_all = substr($id_all,1);
		    //print_r($id_all);  	
	    	import('ORG.Util.Page');
			$count      = $this->_model->where("`id` in ($id_all)")->count();// 查询满足要求的总记录数
			$Page       = new Page($count);// 实例化分页类 传入总记录数和每页显示的记录数
			$show       = $Page->show();// 分页显示输出

			$list = $this->_model->where("`id` in ($id_all)")->order('`order` desc,id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		}
			$result = D('Type')->select();

			foreach($result as $key=>$value)
			{
				$category[$value['id']] = $value['name'];
			}
			foreach($list as $key=>$value)
			{
				$list[$key]['cate_name'] = $category[$value['pid']];
			}

			$this->select_category_1();
			$search = array('name'=>'pid', 'value'=>'title');
			$this->assign('search', $search);

			$this->assign('selected_id', $_REQUEST['pid']);//查询选择分类后，保存当前分类


			$this->assign('list',$list);// 赋值数据集
			$this->assign('page',$show);// 赋值分页输出
			if($template == null)
			{
				$this->display('index');
			}else{
				$this->display($template);
			}
		
    }
    
	//删除图片
	public function delpic(){
		$id=$this->_get('id');
		$img_id=$this->_get('img_id');
		if($id){
			$arr = M('Article')->where("`id` = {$id}")->select();

			$w['id']=$id;
			for($i=1;$i<7;$i++){
				if($img_id == $i){
					$r=M('Article')->where($w)->setField('img'.$i,'');
					$img_name_del = $arr[0]['img'.$i];
					if($r){
						$this->del_image($img_name_del);
						$rrr = true;
					}else{
						$rrr = false;
					}
				}
			}
			
			$arrs = M('Article')->where("`id` = {$id}")->select();
			$arr_1 = array();
			for($i=1;$i<7;$i++){
				if($arrs[0]['img'.$i] != ''){
					$arr_1[] = $arrs[0]['img'.$i];
				}
			}
			
			$img_name = $arr_1[0];

			for($i=1;$i<7;$i++){
				if($arr_1[$i-1]){
					M('Article')->where($w)->setField('img'.$i,$arr_1[$i-1]);
				}else{
					M('Article')->where($w)->setField('img'.$i,'');
				}
			}

			$rr=M('Article')->where($w)->setField('img',$img_name);
			if($rrr){
				$flag='1';
			}else{
				$flag='0';
			}
			
		}
		return $this->ajaxReturn($flag,'JSON');
	}	
	


	public function delpic_1(){
		$id=$this->_get('id');
		if($id){
			$arr = M('Article')->where("`id` = {$id}")->select();
			$img_name = $arr[0]['img'];
			$w['id']=$id;
			
				$r=M('Article')->where($w)->setField('img','');
			
			if($r){
				$this->del_image($img_name);
				$flag='1';
			}else{
				$flag='0';
			}
			
		}
		return $this->ajaxReturn($flag,'JSON');
	}

	



}