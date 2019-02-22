<?php
/**
 * 后台用户管理
 * Enter description here ...
 * @author Administrator
 *
 */
class UserAction extends BaseAction {
	function __construct()
	{
		parent::__construct("User","User");
        $this->_checkUser();  // 检查权限
	}

    /**
     * 显示用户列表
     * @return [type] [description]
     */
    public function index()
    {
        //导入分页类
        import('ORG.Util.Page');
        // 查询满足要求的总记录数
        $count = $this->_model->count();
        // 实例化分页类 传入总记录数和每页显示的记录数
        $Page = new Page($count);
        $Page->setConfig('theme','<span>%totalRow% %header% %nowPage%/%totalPage% 页</span>  %first%  %upPage% %linkPage%  %downPage% %end% %select%');
        // 分页显示输出
        $show = $Page->show();
        $user_list = $this->_model->field('id,username')->limit($Page->firstRow.','.$Page->listRows)->order('id asc')->select();
        // 赋值分页输出
        $this->assign('page',$show);
        $this->assign('user_list', $user_list);
        $this->display();
    }
    
    public function _before_ajax()
    {
        switch($_REQUEST['t'])
        {
            case 'del':
                $id = $_REQUEST['id'];
                if ($id == 1) {
                    $this->error('超级管理员无法删除！');
                }
                break;
            case 'batch_del':
                $ids = $_REQUEST['ids'];
                if (strpos(','.$ids, ',1,')) {
                    $this->error('超级管理员无法删除！');
                }
                break;
        }
    }

    /**
     * ajax检测用户是否已经存在
     * @return [type] [description]
     */
    public function ajaxValidUser()
    {
        $value = $_POST['param'];
        $name = $_POST['name'];

        $data[$name] = $value;
        $res = $this->_model->where($data)->field('id')->find();

        $respond = array('status' => 'n', 'info'=>'该用户名已经存在！');
        if($res === NULL){
            $respond['status'] = 'y';
            $respond['info'] = '该用户名可以注册！';
        }
        $this->ajaxReturn($respond);
    }
	
    /**
     * 检查权限
     * @return [type] [description]
     */
    private function _checkUser()
    {
        // 修改自己的密码为公共操作  
        if (ACTION_NAME=='edit'&&$_SESSION['user_id']==$_REQUEST['id'] ) {            
            return;
        }
        
        // ID为1的为超级管理员
        if($_SESSION['user_id']!='1')
        {
            $this->error('您无权访问该页面');
        }
    }
}