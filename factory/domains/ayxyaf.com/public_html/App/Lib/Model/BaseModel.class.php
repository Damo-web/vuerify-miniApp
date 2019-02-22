<?php
/**
 * 基础模型数据库
 * 所有数据模型必须继承这个继承模型库
 * @author Administrator
 *
 */
class BaseModel extends Model
{  
    private $type_arr = array(
        'Article' => 1, 
        'Goods'   => 2, 
        'Type'    => 3,
        'Config'  => 4,
    );
    private $_type, $_option, $_obj; //数据同步参数
    private $synchroing = false;
    
    function __construct()
    {
        parent::__construct();
    }
    
    protected function _after_insert($data, $options)
    {
        // 仅API启用执行
        if ($this->synchro_check()) {            
            $this->_type   = $this->type_arr[$options['model']];
            $this->_option = 1;

            $data = array($data);

            $this->synchro_analyse($data);        
            $this->synchro();
        }
    }
    
    protected function _before_delete(&$data, $options)
    {
        // 仅API启用执行
        if ($this->synchro_check()) {
            // 批量删除前处理
            $this->_type   = $this->type_arr[$options['model']];
            $this->_option = 2;
            
            // 根据原始数据，筛选需同步列表
            $field    = $this->_type == 3 ? 'id,parent' : 'id,pid'; //计算需要获取的列
            $old_data = $this->field($field)->select($options);
            
            $this->synchro_analyse($old_data);         
        }
    }
    
    protected function _after_delete($data, $options)
    {
        // 仅API启用执行
        if ($this->synchro_check()) {
            $this->synchro();
        }
    }
    
    protected function _before_update(&$data, $options)
    {
        // 仅API启用执行
        if ($this->synchro_check()) {
            $this->_type   = $this->type_arr[$options['model']];
            $this->_option = 3;
            
            // 如果是网参修改或者是修改关于我们，不需要前置处理
            if ($this->_type == 4 || ($this->_type == 1 && $data['id'] == 1)) {
                
            } else {
                // 根据原始数据，筛选需同步列表
                $field = $this->_type == 3 ? 'id,parent' : 'id,pid'; //计算需要获取的列
                if ($options['where']) { //批量编辑
                    $old_data = $this->field($field)->select($options);
                } else { //单个编辑
                    $where      = array(
                        'id' => $data['id']
                    );
                    $old_data[] = $this->field($field)->where($where)->find();
                }
                $this->synchro_analyse($old_data); 
            }
        }
    }
    
    protected function _after_update($data, $options)
    {
        // 仅API启用执行
        if ($this->synchro_check()) {
            if ($this->_type == 4) { // 网站参数是批量修改，防止发送多次事件  每次修改发送两个事件，1个是默认网参，1个是联系我们
                if ($options['where']['_string'] == '`key`="fax"') {
                    $this->synchroing = true;
                    $this->synchro(); //网参
                    $this->_type = 5;
                    $this->_obj  = -2;
                    $this->synchro(); //联系我们
                }
            } else if ($this->_type == 1 && $data['id'] == 1) {
                $this->_type = 5;
                $this->_obj  = -1;
                $this->synchro();
            } else {
                $field = $this->_type == 3 ? 'id,parent' : 'id,pid'; //计算需要获取的列
                if ($options['where']) { //批量编辑
                    $new_data = $this->field($field)->select($options);
                } else { //单个编辑
                    $where = array(
                        'id' => $data['id']
                    );
                    $new_data[] = $this->field($field)->where($where)->find();
                }
                $old_need_data = $this->_obj;
                $this->synchro_analyse($new_data);
                $new_need_data = $this->_obj;
                
                // 在新数据中有，在老数据也有，表示该数据需要编辑
                $need_data = array_intersect(explode(',', $new_need_data), explode(',', $old_need_data));
                if ($need_data) {
                    $this->_option = 3;
                    $this->_obj    = implode(',', $need_data);
                    // z($this->_obj);
                    $this->synchro();
                }
                // 在新数据中有，在老数据中没有，表示该数据需要添加
                $need_data = array_diff(explode(',', $new_need_data), explode(',', $old_need_data));
                if ($need_data && $need_data[0] != '') {
                    $this->_option = 1;
                    $this->_obj    = implode(',', $need_data);
                    $this->synchro();
                }
                
                // 在老数据中有，在新数据中没有，表示该数据需要删除
                $need_data = array_diff(explode(',', $old_need_data), explode(',', $new_need_data));
                if ($need_data && $need_data[0] != '') {
                    $this->_option = 2;
                    $this->_obj    = implode(',', $need_data);
                    $this->synchro();
                }
            }            
        }        
    }

    /**
     * 检查同步接口状态，是否需要同步
     * @return bool 
     */
    protected function synchro_check()
    {
        // 在接口已配置完成，并且未在同步中执行
        return C('API_STATUS') == 'ok' && $this->synchroing == false;
    }
    
    /**
     * 计算需要同步的数据
     * @param  array $data 待计算数据数组
     * @return boolean     是否有需要同步的数据
     */
    protected function synchro_analyse($data)
    {
        // 判断是否是需要同步的数据
        $type = $this->_type;
        switch ($type) {
            case '1': //新闻筛选规则：新闻分类_type=1 单页(分类=0)_type=5 其它分类_type=6               
                $limit_type = array(
                    3,
                    6,
                );
                foreach ($data as $val) {                    
                    if ($val['pid'] == 0) {  // 单页 修正_type
                        $this->_type = 5;
                        if ($val['id'] == 1) { // 公司简介特殊处理
                            $this->_obj = -1;
                        }
                    }else{
                        $code = M('type')->where("id={$val['pid']}")->getField('code');
                        if (array_intersect(explode(',', $code), $limit_type)) {  // 过滤不同步数据
                            continue;
                        }else{
                            if (strpos($code, ',4,') === false) { // 非新闻 为其它分类
                                $this->_type = 6;
                            }
                        }
                    }                    
                    $data['id'] .= $val['id'] . ',';
                }
                $this->_obj = trim($data['id'], ',');
                break;
            case '2': //产品筛选规则：全部同步
                foreach ($data as $val) {                    
                    $ids .= $val['id'] . ',';                   
                }
                $this->_obj = trim($ids, ',');
                break;
            case '3': //分类筛选规则：排除人才招聘、友情链接
                $limit_type = array(
                    3,
                    6,
                );
                foreach ($data as $val) {
                    $code = M('type')->where("id={$val['parent']}")->getField('code');
                    if (array_intersect(explode(',', $code), $limit_type)) {
                        continue;
                    }
                    $ids .= $val['id'] . ',' ;
                }
                $this->_obj = trim($ids, ',');
                break;
            case '4': //网站设置筛选规则
                return true;
                break;
            default:
                break;
        }
        
        return empty($this->_obj);
    }
    
    /**
     * 发送同步事件
     */
    protected function synchro()
    {
        $api_url = C('API_URL'); //api地址
        $params  = $this->setParams(); //准备参数
        
        if ($api_url && $params) {
            $ret = http_transport($api_url, $params); //发送同步事件
            if ($ret != 'ok') {
                return false;
            }
            $p = $params;
            // 如果成功记录同步版本
            if ($p['option'] == 2) {
                // 删除同步 删除同步版本
                $where['type'] = $p['type'];
                $where['obj'] = array('in', $p['obj']);
                D('synchro')->where($where)->delete();
            }else{
                // 添加、编辑同步 保存同步版本
                $url = $_SERVER['HTTP_HOST'] . __ROOT__ . '/api';
                $p['action'] = 'data';
                foreach (explode(',', $p['obj']) as $id) {
                    $synchro['obj'] = $id;
                    $synchro['type'] = $p['type'];
                    $p['obj'] = $id;
                    $result = http_transport($url, $p);
                    if ($result) {                            
                        $data = json_decode($result);
                        $synchro['check'] = $data->check;
                    }
                    $where = $synchro;
                    unset($where['check']);                        
                    if (M('synchro')->where($where)->find()) {
                        M('synchro')->where($where)->setField('check', $synchro['check']);
                    }else{
                        M('synchro')->add($synchro);
                    }
                }
            }
            
            $this->synchroing = true;  // 已经发送一次
        }
    }
    
    /**
     * 构建发送数据数组
     * @param  int     $type   type取值1,2,3,4
     * @param  int     $option type取值1,2,3
     * @param  string  $result obj取值1或者1,2,3字符串
     * @return array
     */
    protected function setParams()
    {
        // 只有网站参数config同步时，无需obj
        if ($this->_type != 4 && $this->_obj == '') {
            return null;
        }
        
        $data = array(
            'action'    => 'notice', //事件通知
            'type'      => $this->_type, //数据类型
            'option'    => $this->_option, //操作类型
            'obj'       => $this->_obj, //操作对象
            'appid'     => C('API_ID'), //API编号
            'signature' => md5(C('API_SECRET')), //加密签名 
            'version'   => C('API_VERSION'), //版本号
        );
        
        return $data;
    }
    
}
?>