<?php

/**
 * 文章数据模型
 * Enter description here ...
 * @author Administrator
 *
 */
class ArticleModel extends BaseModel {
	function __construct()
	{
		parent::__construct();
	}

	protected $_validate = array(
    	array('title','require','文章名称不允许为空！'), //默认情况下用正则进行验证
	);	

}

?>