<?php
namespace Home\Controller;
use Think\Controller;
class StuXtResultActionController extends Controller{
	public function stuXtResult(){
		$status=D("Init","Logic")->run();//这里获得当前用户基本信息
		if($status['err']==0){
			$xh=$status['bh'];
			$xs=M();
			$result=$xs->query("SELECT gds_xs.tmbh FROM `gds_xs` where `xh`='$xh'");		
			if($result[0]['tmbh']){
				//这里直接显示选题的基本信息
				$data['judge']=1;
				$tmbh=$result[0]['tmbh'];
				$result_tm=$xs->query("SELECT * FROM `gds_tm` where `tmbh`='$tmbh'");
				$data['info_tm']=$result_tm[0];//学生选题基本信息
				$data['tmms']=mb_substr($result_tm[0]['tmms'],0,10,'utf-8')."...";
				$jsbh=$result_tm[0]['jsbh'];//学生选题出题教师编号
				
				$result_js=$xs->query("SELECT * FROM `gds_js` where `jsbh`='$jsbh'");
				$data['jsxm_tm']=$result_js[0]['xm'];//学生选题教师姓名
			}
			else{
				$data['judge']=0;
			}	
			$data['edit']=U("StuXtResultAction/edit");
			$data['XtResult']=U("StuXtResultAction/getResult");
			$this->assign($data);
			$this->display();
		}
		else{
			die;
		}
	}
	
	public function edit(){
		$status=D("Init","Logic")->run();//这里获得当前用户基本信息
		if($status['err']==0){
			//首先检测当前用户的状态
			$select=I("post.select");
			$xh=$status['bh'];
			//其次检测ajax过来的是什么东西
			if($select=="qq"){
				//最后处理信息
				$content=I("post.content");
				if(trim($content)=="" || !is_numeric(trim($content))){
					$row = array(
							'info'=>'输入内容不符合要求!',
							'status'=>2,
					);
					echo json_encode($row);
				}
				else{
					$sql="update `gds_xs` set `qq`='$content' where `xh`='$xh'";
					if(M()->execute($sql)){
						$row = array(
								'info'=>'qq',
								'status'=>1,
						);
						echo json_encode($row);
					}
					else{
						$row = array(
								'info'=>'qq',
								'status'=>-1,
						);
						echo json_encode($row);
					}
				}
			}
			else if ($select=="tel"){
				$content=I("post.content");
				if(trim($content)==""){
					$row = array(
							'info'=>'输入内容不符合要求!',
							'status'=>2,
					);
					echo json_encode($row);
				}
				else{
					$sql="update `gds_xs` set `tel`='$content' where `xh`='$xh'";
					if(M()->execute($sql)){
						$row = array(
								'info'=>'tel',
								'status'=>1,
						);
						echo json_encode($row);
					}
					else{
						$row = array(
								'info'=>'tel',
								'status'=>-1,
						);
						echo json_encode($row);
					}
				}
			}
			else{
				$row = array(
						'info'=>'内部错误',
						'status'=>-2,
				);
				echo json_encode($row);
			}
		}
		else{
			$row = array(
					'info'=>'非法入侵',
					'status'=>-1,
			);
			echo json_encode($row);
		}
	}
	
	public function getResult(){
		//这里我们使用ajax获取该学生的选课结果
		$status=D("Init","Logic")->run();//这里获得当前用户基本信息
		if($status['err']==0){
			$xh=$status['bh'];
			$stuSql="select qq as xsqq, tel as xstel, xh, xm, jsbh from gds_xs where xh='$xh'";
			$xs=M();
			$stuInfo=$xs->query($stuSql);
			$tmjsbh=$stuInfo[0]['jsbh'];
			
			$jsSql="select xm, zy, zc, qq as jsqq, tel from gds_js where jsbh='$tmjsbh'";
			
			$rs=$xs->query($jsSql);
			$row1 = array(
					'name'=>'学号',
					'value'=>$stuInfo[0]['xh'],
					'group'=>'学生个人信息',
					'editor'=>'editor',
			);
			$row2 = array(
					'name'=>'姓名',
					'value'=>$stuInfo[0]['xm'],
					'group'=>'学生个人信息',
					'editor'=>'editor',
			);
			if($stuInfo[0]['xsqq']==""){
				$row3 = array(
						'name'=>'QQ号',
						'value'=>"",
						'group'=>'学生个人信息',
						'editor'=>'text',
				);
			}
			else{
				$row3 = array(
						'name'=>'QQ号',
						'value'=>$stuInfo[0]['xsqq'],
						'group'=>'学生个人信息',
						'editor'=>'text',
				);
			}
			if($stuInfo[0]['xstel']==""){
				$row4 = array(
						'name'=>'电话号码',
						'value'=>"",
						'group'=>'学生个人信息',
						'editor'=>'text',
				);
			}
			else{
				$row4 = array(
						'name'=>'电话号码',
						'value'=>$stuInfo[0]['xstel'],
						'group'=>'学生个人信息',
						'editor'=>'text',
				);
			}
			
			$row5 = array(
					'name'=>'教师编号',
					'value'=>$tmjsbh,
					'group'=>'导师信息',
					'editor'=>'editor',
			);
			$row6 = array(
					'name'=>'姓名',
					'value'=>$rs[0]['xm'],
					'group'=>'导师信息',
					'editor'=>'editor',
			);
			$row7 = array(
					'name'=>'专业',
					'value'=>$rs[0]['zy'],
					'group'=>'导师信息',
					'editor'=>'editor',
			);
			$row8 = array(
					'name'=>'职称',
					'value'=>$rs[0]['zc'],
					'group'=>'导师信息',
					'editor'=>'editor',
			);
			$row9 = array(
					'name'=>'QQ号',
					'value'=>$rs[0]['jsqq'],
					'group'=>'导师信息',
					'editor'=>'editor',
			);
			$row10 = array(
					'name'=>'电话号码',
					'value'=>$rs[0]['jstel'],
					'group'=>'导师信息',
					'editor'=>'editor',
			);
			$rows=array();
			array_push($rows, $row1);
			array_push($rows, $row2);
			array_push($rows, $row3);
			array_push($rows, $row4);
			array_push($rows, $row5);
			array_push($rows, $row6);
			array_push($rows, $row7);
			array_push($rows, $row8);
			array_push($rows, $row9);
			array_push($rows, $row10);
			echo json_encode($rows);
		}
		else{
			$row = array(
					'name'=>'错误信息',
					'value'=>'你现在的登录状态是非法登陆，请返回',
					'group'=>'error',
					'editor'=>'editor',
			);
			$rows=array();
			array_push($rows, $row);
			echo json_encode($rows);
		}		
	}
}


?>