<?php
/**
 * 更新操作接口，系统内置，请勿删除修改
 * @version 1.0 
 */
class UpdateAction extends Action
{
    // API入口函数
    public function index($action)
    {
        header("Content-Type: text/html; charset=utf-8");
        $action = $this->_get('action');
        // 操作类型未定义退出执行
        if (!method_exists($this, $action)) {
            echo '参数错误';
            die;
        }
        // 仅能访问public权限方法
        $action_ref = new ReflectionMethod($this, $action);
        if ($action_ref->isPublic() != ture) {
            echo '无权访问该接口';
            die;
        }
        // 执行相应操作
        $this->{$action}();
        die;
    }

    public function url()
    {
        $api_file = CONF_PATH . 'api.php';
        if (!file_exists(CONF_PATH . 'api.php')) {
            $data['code'] = '1001';
            $data['msg'] = '未对接QFTouch站点';
            echo json_encode($data);
            exit();            
        }
    	$api = include CONF_PATH . 'api.php';
        $params['action'] = 'url';
        $params['url_no'] = $this->_get('url_no');
        $params['appid'] = $api['API_ID'];
        $params['signature'] = md5($api['API_SECRET']);
    	$params['version'] = $api['API_VERSION'];
        $url = http_transport($api['API_URL'], $params, 'GET');
        if ($url) {
            $api['M_URL'] = 'http://' . $url;
            $configStr = "<?php\n return " . var_export($api, true) . ";";
            if(file_put_contents($api_file, $configStr)) {
                $data['code'] = '2001';
                $data['msg'] = 'ok';
                echo json_encode($data);
                exit();
            }else{
                $data['code'] = '1002';
                $data['msg'] = '文件无法写入，更新失败';
                echo json_encode($data);
                exit();            
            }
        }
    }

}