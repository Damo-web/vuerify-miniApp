<?php

class PublicAction extends BaseAction{
	function __construct()
		{
			parent::__construct();
		    $in_proclass=$this->sub_nav(2,4);
			$this->assign('in_proclass',$in_proclass);
	        $in_proclass1=$this->sub_nav(2,0);
			$this->assign('in_proclass1',$in_proclass1);
			$scoll=$this->link(6);
			$this->assign('scoll',$scoll);
			$scoll1=$this->link1(6);
			$this->assign('scoll1',$scoll1);
			$link=$this->flink(0);
			$this->assign('link',$link);
			$in_news1=$this->ar_news(4,0);
			$this->assign('in_news1',$in_news1);
		    $article1 = M('article')->where('`id`=4')->find();
			$this->assign('intro1',$article1);
			//页面title
			//$title = $this->get_title().$this->config('web_name');
//			$this->assign('title',$title);
			$this->assign('MODULE_NAME',MODULE_NAME);
		}
	
        //子菜单	
		function sub_nav($k,$n)
		{

			$sub_nav = M('type')->where("`parent`='$k'")
							   	 ->order('`order` asc,`id` desc')
                                 ->limit($n)
							   	 ->select();
		    return $sub_nav;
			
		}
		function sub_navs($k,$n,$m,$m1)
		{

			$onetype = M('type')->where("`parent`='$k'")
							   	 ->order('`order` asc,`id` desc')
                                 ->limit($n)
							   	 ->select();
			if($onetype)
			{
				foreach($onetype as $n=>$val)
			    {
					

						$onetype[$n]['voo']= M('goods')->where("`pid`=".$val['id']."")
							   	 ->order('`order` asc,`id` desc')
                                 ->limit($m1)
							   	 ->select();
								 foreach($onetype[$n]['voo'] as $key=>$value)
				                {
					                $onetype[$n]['voo'][$key]['title'] = $value['title'];
				                }

			    }
			}

		    return $onetype;
			
		}
		//链接
		function link($n)
		{

			$link = M('flash')->where("`pc_m`='0' AND `open`='1' AND `is_home`='0'")
							   	 ->order('`order` asc,`id` desc')
								 ->limit($n)
							   	 ->select();
		    return $link;

		}	
		
		//链接
		function link1($n)
		{

			$link = M('flash')->where("`pc_m`='0' AND `open`='1' AND `is_home`='1'")
							   	 ->order('`order` asc,`id` desc')
								 ->limit($n)
							   	 ->select();
		    return $link;

		}	
		function flink($n)
		{

			$link = M('article')->where("`pid`='6'")
							   	 ->order('`order` asc,`id` desc')
								 ->limit($n)
							   	 ->select();
		    return $link;

		}	
		 //产品	
		function pro_goods($k,$n)
		{
            $pid = $this->getTypeID($k);
			$pro_goods = M('goods')->where("`pid` in ($pid)")
							   	 ->order('`order` desc,`id` desc')
                                 ->limit($n)
							   	 ->select();
		    return $pro_goods;
			
		}
		function pro_goods1($k,$n)
		{
            $pid = $this->getTypeID($k);
			$pro_goods = M('goods')->where("`pid` in ($pid) and `is_best`='1'")
							   	 ->order('`order` asc,`time` desc')
                                 ->limit($n)
							   	 ->select();
		    return $pro_goods;
		}

		 //新闻	
		function ar_news($k,$n)
		{
            $pid = $this->getTypeID($k);
			$ar_news = M('article')->where("`pid` in ($pid)")
							   	 ->order('`order` asc,`time` desc')
                                 ->limit($n)
							   	 ->select();
		    return $ar_news;
			
		}
		function ar_news1($k,$n)
		{
            $pid = $this->getTypeID($k);
			$ar_news = M('article')->where("`pid` in ($pid) and `is_top`='1'")
							   	 ->order('`order` asc,`time` desc')
                                 ->limit($n)
							   	 ->select();
		    return $ar_news;
		}
		//面包屑
		function get_category_menu($urlKey, $symbol,$category_id)
		{
		   static $strTxt;
		   $parent=0;
			if($category_id>0)
			{
				$type=M('type')->where("`id`=".$category_id."")->find();
				if(($type['parent']==1) or ($type['parent']==2) or ($type['parent']==3))
				{
					$parent=0;
				}
				else
				{
					$parent=$type['parent'];
				}
			    if($parent>0)
			    {
				   $this->get_category_menu($urlKey, $symbol, $parent);
			    }
		        $strTxt.='&nbsp;&gt;&nbsp;<a href="__APP__/'.$urlKey.'/'.$category_id.'">'.$type['name'].'</a>';
			}
			return $strTxt;
		}

	/* 定制扩展位置 */
	
		
}
?>