<?php
/**
 * 后台分类管理
 * Enter description here ...
 * @author Administrator
 *
 */
class CategoryAction extends BaseAction {
    /**
     * 
     * Enter description here ...
     */
    public function __construct()
    {
        parent::__construct("Category",'Type');
    }
    /**
     * 栏目列表
     * @see BaseAction::index()
     */
    function index()
    {        
        $list = $this->_model->list_column();
        $this->assign('list', $list);
        $this->display();
    }
    
    function add()
    {
        if($_POST)
        {
            $_POST['type'] = $_REQUEST['type'];
            if($_FILES['img']['size'] != 0)
            {
                $img_name = $this->UploadFile();
                $_POST['img'] = $img_name[0];
            }
            // 配置当前API参数
            $type_id = $this->_model->add($_POST);

            if($type_id)
            {
                $this->make_code($type_id);               

                // 增加选中父级分类判断
                $_SESSION['sele']=$_POST['parent'];
                $this->success('添加成功');
            }else
            {
                $this->error('添加失败');
            }
            exit;
        }
        if($_GET['type'])
        {
            $parent = $this->_model->select_column_2($_GET['type'], true);
        }else
        {
            $parent = $this->_model->select_column('0', true);
        }
        switch($_REQUEST['type'])
        {
            case "1":
                $column = "文章";
                break;
            case "2":
                $column = "产品";
                break;
            case "3":
                $column = "招聘";
                break;
        }
        $this->assign('column', $column);        
        $sele=$_SESSION['sele'];
        $this->assign('sele', $sele);
        unset($_SESSION['sele']);        
        $title = "新增分类";
        $this->assign('title',$title);
        $this->assign('parent',$parent);
        parent::add();
    }
    
    /**
     * 编辑栏目(non-PHPdoc)
     * @see BaseAction::edit()
     */
    function edit()
    {
        if($_POST)
        {
            if($_POST['id'] != $_POST['parent'])
            {
                $old = $this->_model->find($_POST['id']);
                $old_code = $old['code'];
                $length = strlen($old_code);
                $where['code'] = array('like',$old_code.'%');
                $old_arr = $this->_model->where($where)->select();

                if($_FILES['img']['size'] != 0)
                {
                    if($_POST['img'] != null){
                        $this->del_image($_POST['img']);
                    }
                    $img_name = $this->UploadFile();
                    $_POST['img'] = $img_name[0];
                }
                //
                $type_id = $this->_model->save($_POST);

                if($type_id)
                {
                    $new_code = $this->make_code($_POST['id']);

                    foreach ($old_arr as $key => $value) {
                        if($value['id'] != $_POST['id']){
                            $value['code'] = $new_code.substr($value['code'],$length);
                            $Type = D('Type');
                            $Type->save($value);
                        }
                    }
                    switch($_REQUEST['type'])
                    {
                        case "1":
                            $this->success('更新成功',__GROUP__.'/Category/article');
                            break;
                        case "2":
                            $this->success('更新成功',__GROUP__.'/Category/goods');
                            break;
                        case "3":
                            $this->success('更新成功',__GROUP__.'/Category/jobs');
                            break;
                        default:
                            $this->success('更新成功',__GROUP__.'/Category/Index');
                    }
                    
                }else{
                    $this->error('数据没有保存或没有修改');
                }
            }else
            {
                $this->error('更新失败');
            }
            exit;
        }
        $title = "编辑栏目";
        if($_GET['type'])
        {
            if($_GET['t_id']){
                $parent = $this->_model->select_arrange_3();
            }else{
                $parent = $this->_model->select_column_2($_GET['type'], true);
            }
        }else
        {
            $parent = $this->_model->select_column('0', true);
        }
        $info = $this->_model->find($_REQUEST['id']);
        //z($info);
        $selected = $info['parent'];
        //z($selected);
        switch($_REQUEST['type'])
        {
            case "1":
                $column = "文章";
                break;
            case "2":
                $column = "产品";
                break;
            case "3":
                $column = "招聘";
                break;
        }
        $this->assign('edit_type', '1');
        $this->assign('column', $column);
        $this->assign('title','编辑分类');
        $this->assign('sele',$selected);
        $this->assign('parent',$parent);
        $this->assign('info',$info);
        parent::edit();
    }
    function article()
    {
        $input_hidden = '<input type="hidden" name="type" value="1">';
        $input_hidden .= '<input type="hidden" name="action" value="'.ACTION_NAME.'">';
        $this->assign('input_hidden', $input_hidden);
        $search = array('value'=>'name');
        $this->assign('search', $search);
        
        //z($this->_model_name);
        $list = $this->_model->list_column(C('article'));
        $type = C('article');
        $this->assign('type', $type);
        $this->assign('list', $list);
        $title = "文章";
        $this->assign('title',$title);
        $this->display('index');
    }
    
    function jobs()
    {
        $input_hidden = '<input type="hidden" name="type" value="3">';
        $input_hidden .= '<input type="hidden" name="action" value="'.ACTION_NAME.'">';
        $this->assign('input_hidden', $input_hidden);
        $search = array('value'=>'name');
        $this->assign('search', $search);
        //z($this->_model_name);
        $list = $this->_model->list_column(C('jobs'));
        $type = C('jobs');
        $this->assign('type', $type);
        $this->assign('list', $list);
        $title = "招聘";
        $this->assign('title',$title);
        $this->display('index');
    }
    
    function goods()
    {
        $input_hidden = '<input type="hidden" name="type" value="2">';
        $input_hidden .= '<input type="hidden" name="action" value="'.ACTION_NAME.'">';
        $this->assign('input_hidden', $input_hidden);
        $search = array('value'=>'name');
        $this->assign('search', $search);
        
        //z($this->_model_name);
        $list = $this->_model->list_column(C('goods'));
        $type = C('goods');
        $this->assign('type', $type);
        $this->assign('list', $list);
        $title = "产品";
        $this->assign('title',$title);
        $this->display('index');
    }
    
    /**
     * Ajax获取数据
     * Enter description here ...
     */
    function ajax()
    {
        switch($_REQUEST['t'])
        {
            //获取不同类型栏目的ajax数据
            case 'type':
                $data = $this->_model->select_column($_REQUEST['tpye']);
                $this->ajaxReturn($data,'JSON');
                break;
            case 'del':
                $where = array('id'=>$_REQUEST['id']);
                $result = $this->_model->where($where)->select();
                $this->del_images($result);
                if($data = $this->_model->where($where)->delete())
                {
                    $this->ajaxReturn('删除成功','JSON', 1);
                }else 
                {
                    $this->ajaxReturn('删除失败','JSON', 0);
                }
                break;

            case 'cate_del':
                if(!$_REQUEST['id']){
                    exit();
                }
                $where = array('id'=>$_REQUEST['id']);
                $w1['code']=array('like','%'.$_REQUEST['id'].',%');
                $r=D('Type')->where($w1)->select();
                foreach ($r as $key => $value) {
                    $id_array=$value['id'].','.$id_array;
                }
                $id_array=rtrim($id_array, ",");
                //删除类别图片
                $result_1 = $this->_model->where($w1)->select();
                foreach ($result_1 as $key => $value) {
                    if($value['img'] !=null){
                        $this->del_image($value['img']);
                    }

                }

                $end_array = end($result_1);

                //删除类别
                $data = $this->_model->where($w1)->delete();

                if($data)
                {
                    //删除记录
                    $w['pid']=array('in',$id_array);
                    //因为类别 id唯一，所以goods表和Article表不会同时存在同一个pid
                    $result_2 = D('Goods')->where($w)->select();
                    $this->del_images($result_2);
                    $data2 = D('Goods')->where($w)->delete();
                    $result_3 = D('Article')->where($w)->select();
                    $this->del_images($result_3); 
                    $data3 = D('Article')->where($w)->delete();
                    $result_4 = D('Jobs')->where($w)->select();
                    $this->del_images($result_4); 
                    $data4 = D('Jobs')->where($w)->delete();                  
                    $this->ajaxReturn('删除成功','JSON', 1);
                }else 
                {
                    $this->ajaxReturn('删除失败','JSON', 0);
                }
                break;

            case 'batch_del':
                $where = array('id'=> array('in', $_REQUEST['ids']));
                $result = $this->_model->where($where)->select();

                foreach ($result as $key => $value) {
                    //是否同步数据
                    $r = $this->del_type($value['id']);
                }

                if($r)
                {
                    $this->ajaxReturn('删除成功','JSON', 1);
                }else 
                {
                    $this->ajaxReturn('删除失败','JSON', 0);
                }
                break;

            case 'order':
                $where = array('id'=>$_REQUEST['id']);
                //删除上除图片
                $info = $this->_model->find($_REQUEST['id']);
                $info['order'] = (int)$_REQUEST['value'];
                $id = $this->_model->save($info);
                if($id)
                {
                    $this->ajaxReturn('修改成功','JSON', 1);
                }else
                {
                    $this->ajaxReturn('修改失败','JSON', 0);
                }
                break;
        }
    }
    
    
/**
     * 分类后台搜索
     * Enter description here ...
     */
    public function search($template = null)
    {
        //print_r($_POST['type']);
        $input_hidden = '<input type="hidden" name="type" value="'.$_POST['type'].'">';
        $input_hidden .= '<input type="hidden" name="action" value="'.$_POST['action'].'">';
        $this->assign('input_hidden', $input_hidden);
        $search = array('value'=>'name');
        $this->assign('search', $search);
        
         foreach($_POST as $key=>$value)
        {
            $value = trim($value);
            $this->_where[$key] = array('like','%'.$value.'%');
        }
        switch($_POST['action'])
        {
            case 'goods':
                $title = "产品";
                $this->_where['id'] = array('NEQ', '2');
                break;
            case 'jobs':
                $title = "招聘";
                $this->_where['id'] = array('NEQ', '3');
                break;
            case 'article':
                $title = "文章";
                break;
        }
        $this->assign('title',$title);
        $this->assign('action_type',$_POST['action']);
        
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
        $this->assign('search', $search);
        $this->assign('set_title', $_REQUEST['name']);
        $this->assign('type', $_POST['type']);
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        if($template == null)
        {
            //$this->display('index');
            $this->display('search');
        }else{
            $this->display($template);
        }
    }
    /**
     * 生成code值
     * Enter description here ...
     * @param unknown_type $parent_id当前分类ID
     */
    private function make_code($id)
    {
        $data = $this->_model->find($id);
        $parent_data = $this->_model->find($data['parent']);
        $data['code'] = $parent_data['code'].$data['id'].",";
        $Type = D('Type');
        $Type->save($data);

        return $data['code'];
    }

    public function delpic(){
        $id=$this->_get('id');
        if($id){
            $arr = D('Type')->where("`id` = {$id}")->select();
            $img_name = $arr[0]['img'];
            $w['id']=$id;
            
                $r=D('Type')->where($w)->setField('img','');
            
            if($r){
                $this->del_image($img_name);
                $flag='1';
            }else{
                $flag='0';
            }
            
        }
        return $this->ajaxReturn($flag,'JSON');
    }

    //删除带有子分类的分类名称以及属于该分类的所有内容
     public function del_type($id){
        $result_1 = D('Type')->where("`id` = {$id}")->select();
        if($result_1 != null){
            $result = D('Type')->where("`parent` = {$id}")->select();
            if($result != null){
                foreach ($result as $key => $value) {
                     $this->del_type($value['id']);
                }
            }
            $data = D('Type')->where("`id` = {$id}")->delete();

            if($data){
                $result_2 = D('Goods')->where("`pid` = {$id}")->select();
                $this->del_images($result_2);
                $data2 = D('Goods')->where("`pid` = {$id}")->delete(); 
                $result_3 = D('Article')->where("`pid` = {$id}")->select();
                $this->del_images($result_3);
                $data3 = D('Article')->where("`pid` = {$id}")->delete();
                $result_4 = D('Jobs')->where("`pid` = {$id}")->select();
                $this->del_images($result_4);
                $data4 = D('Jobs')->where("`pid` = {$id}")->delete();
            }else{
                return false;
                break;
            }

            if($result_1[0]['img'] !=null){
                $this->del_image($result_1[0]['img']);
            }
        }
        return true;
    }


    public function change(){
        $id=$this->_get('id');
        $change_id=$this->_get('change_id');
            
        $result_1 = D('Type')->where("`id` = {$id}")->select();
        $code_1 = $result_1[0]['code'];
        $result_2 = D('Type')->where("`id` = {$change_id}")->select();
        $code_2 = $result_2[0]['code'];
        if(strstr($code_2,$code_1)){
            $flag='1';
        }else{
            $flag='0';
        }           
        
        return $this->ajaxReturn($flag,'JSON');
    }

}