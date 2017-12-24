<?php
namespace Home\Controller;
use Think\Controller;

class StuXtActionController extends Controller{
	public function stuXt(){
		$status=D("Init","Logic")->run();
		if($status['err']==0){
			$xh=$status['bh'];
			$result=M()->query("SELECT * FROM `gds_xs` where `xh`='$xh'");
			if($result[0]['tmbh']){
				$data['judge']=0;
			}
			else{
				$data['judge']=1;
				$data['url']=U('StuXtAction/page');
				$data['XtUrl']=U("StuXtAction/Xt");//用来ajax的url
				//StuXtResultAction
				$data['StuXtResultAction']=U("StuXtResultAction/stuXtResult");
				$this->assign($data);
			}
			$this->display();
		}
		else{
			die;
		}
	}
	
	public function page(){
		$status=D("Init","Logic")->run();
		if($status['err']==0){
			$xh=$status['bh'];
			$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
			$offset = ($page-1)*$rows;
			$result = array();
			$result["total"]=M("tm")->count(); //这个就是查询tm表里总条数
			$rs = M()->query("SELECT a.tmbh,a.tmmc,a.kfjs,a.tmms,b.xm,b.zy,b.zc FROM `gds_tm` as a,`gds_js` as b WHERE a.jsbh=b.jsbh order by b.xm desc limit $offset,$rows");
			$rows = array();
			for ($i=0;$i<count($rs);++$i){
				if($this->IsSelected($rs[$i]['tmbh'], $xh)){
					$rs[$i]['judge']=$this->addRed("不可以");
					$rs[$i]['_tmms']=$this->addRed(mb_substr($rs[$i]['tmms'],0,70,'utf-8')."...");
					$rs[$i]['tmmc']=$this->addRed($rs[$i]['tmmc']);
					$rs[$i]['kfjs']=$this->addRed($rs[$i]['kfjs']);
					$rs[$i]['xm']=$this->addRed($rs[$i]['xm']);
					$rs[$i]['zc']=$this->addRed($rs[$i]['zc']);
				}
				else{
					$rs[$i]['judge']="可以";
					$rs[$i]['_tmms']=mb_substr($rs[$i]['tmms'],0,70,'utf-8')."...";
				}
				//$rs[$i]['judge']=$this->IsPersonSelected($rs[$i]['tmbh'], $xh);	
				//$rs[$i]['_tmms']=mb_substr($rs[$i]['tmms'],0,70,'utf-8')."...";
				array_push($rows, ($rs[$i]));
			}
			$result["rows"] = $rows;
			echo json_encode($result);
		}
		else{
			die;
		}
	}
	
	public function Xt(){
		$status=D("Init","Logic")->run();
		if($status['err']==0){//当前学生登录状况是正常情况
			$xh=$status['bh'];//该学生学号
			$tmbh=I("post.tmbh");//该学生选择的题目编号
			//得到用户选择的题目的唯一编号，接下来将对用户的行为进行处理
			//首先，我们判断当前是否可以选择这道题目(这里我们重新的检测了一遍当前的操作是否合法就是为了解决root临时改变选题情况导致客户端未能及时改变的情况)
			if($this->IsSelected($tmbh, $xh)){
				$arr=array(
						'info'=>'不可选择,请刷新页面重试!',
						'status'=>'-2',
						
				);
				echo json_encode($arr);
			}
			else{
				//这里我们为该同学选题,其实这里就是直接将该同学的tmbh填一下就行了

				$jsbh=D('Tm')->getJsbhByTmbh($tmbh);

				$tupdate=M()->execute("UPDATE `gds_xs` SET `tmbh`=$tmbh ,`jsbh`= '$jsbh' where `xh`=$xh");
				$arr=array(
						'info'=>"选题成功",
						'status'=>1,	
				);
				echo json_encode($arr);
			}			
		}
		else{
			$ajax['info']="非法入侵，请停止当前操作";
			$ajax['status']=-1;
			$this->ajaxReturn($ajax,"JSON");
		}
	}
	
	/*
	 * 这个函数接受两个参数
	 * val1:题目编号
	 * val2:学生学号
	 * 
	 * 返回结果为bool类型  
	 * true表示本题对于当前学生不可选择
	 * false表示本体对于当前学生可选
	 * 
	 * *：函数设计原因：应付不同时刻不同的需求进行动态的模块化调整
	 * */
	private function IsSelected($tmbh,$xh){
		//1、首先查询数据库设置,检测当前的数据库中对选题具体要求
		$sql="select `value` from gds_settings where `name`='xtgn'";
		$status=M()->query($sql);
		if($status[0]['value']==1){//检测选题功能是否打开
			$sql="select `value` from gds_settings where `name`='bjxt'";
			$status=M()->query($sql);
			if($status[0]['value']==0){//检测选题功能具体要求
				//等于0表示不允许不同班级人员选择相同的题目,这里我们默认一道题目只允许一个人选
				$res=M()->query("select count(*) as count from gds_xs where `tmbh`='$tmbh' ");
			}
			else if($status[0]['value']==1){
				//等于1表示当前允许不同班级选择相同的题目，但是我们不允许同班同学选择相同的题目
				$res=M()->query("select count(*) as count from gds_xs where `tmbh`='$tmbh' AND `bj` in(select bj from gds_xs where `xh`='$xh' )");
			}
			$count = $res[0]['count'];
			if(($count)>0)
				return true;//本题对于当前同学已经被其本班同学选择
			else
				return false;
		}
		else{
			return true;
		}		
	}	
	
	private function IsPersonSelected($tmbh,$xh){
		if($this->IsSelected($tmbh, $xh)){
			return "<span style='color: red;'>不可以</span>";
		}
		else{
			return "可以";
		}
	}
	
	private function addRed($str){
		return "<span style='color: red;'>".$str."</span>";
	}
	
}




?>

