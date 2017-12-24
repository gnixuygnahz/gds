<?php
namespace Home\Controller;
use Think\Controller;
class StuUploadActionController extends Controller{
	public function stuUpload(){
		$status=D("Init","Logic")->run();//这里获得当前用户基本信息
		if($status['err']==0){
			$xh=$status['bh'];
			$xs=M();
			$result=$xs->query("SELECT gds_xs.tmbh FROM `gds_xs` where `xh`='$xh'");
			if($result[0]['tmbh']){//这里说明已经选题了
				$data['judge']=1;
				//这里需要显示每一个题目的提交时间，这里我们直接通过页面的加载判断即可!
				$sql="SELECT `sj_ktbg`,`sj_bylw`,`sj_cx` FROM `gds_xs` WHERE `xh`='$xh'";
				$result=M()->query($sql);
				if($result[0]['sj_ktbg']!=0){
					$data['ktbg']=date('Y-m-d H:i:s',$result[0]['sj_ktbg']);
				}
				else{
					$data['ktbg']=0;
				}
				if($result[0]['sj_bylw']!=0){
					$data['bylw']=date('Y-m-d H:i:s',$result[0]['sj_bylw']);
				}
				else{
					$data['bylw']=0;
				}
				if($result[0]['sj_cx']!=0){
					$data['cx']=date('Y-m-d H:i:s',$result[0]['sj_cx']);
				}
				else{
					$data['cx']=0;
				}
			}
			else{
				$data['judge']=0;
			}
			$data['uploadFile']=U("StuUploadAction/uploadFile");
			$data['StuUploadAction']=U("StuUploadAction/stuUpload");//提交毕业设计页面
			
			$data['xh']=$xh;
			$this->assign($data);
			$this->display();
		}
		else{
			//非法入侵!
			die;
		}
	}
	
	public function uploadFile(){
		$status=D("Init","Logic")->run();//这里获得当前用户基本信息
		if($status['err']==0){
			if(!isset($_POST['judgeFile'])){
				redirect(U("Login/loginAction"), 3, '非法入侵');
			}
			else{
				$judgeFile=$_POST['judgeFile'];
				$xh=$_POST['xh'];
				$res=M()->query("select `xy` ,  `zy` ,  `bj`,`xm` FROM  `gds_xs` WHERE xh =  '$xh'");
				$path="./".trim(iconv('UTF-8', 'GBK', $res[0]['xy']))."/".trim(iconv('UTF-8', 'GBK', $res[0]['zy']))."/".trim(iconv('UTF-8', 'GBK', $res[0]['bj']))."/".$xh."/";
				$time=time();
			};
		}		
		else{
			redirect(U("Login/loginAction"), 3, '非法入侵');
		}
		$upload = new \Think\Upload();// 实例化上传类
		$upload->rootPath  =     './Public/file/';  // 设置附件上传根目录
		$upload->replace=true;	//  允许覆盖
		$upload->autoSub = false;  //  不允许使用自动子目录
		if($judgeFile==1){
			//开题报告
			$upload->maxSize   =     3145728 ;// 设置附件上传大小 3M
			$upload->exts      =     array('docx','doc', 'zip', 'rar');// 设置附件上传类型
			$upload->maxSize   =     3145728 ;// 设置附件上传大小 3M	
			$upload->savePath  =     $path; // 设置附件上传（子）目录
			$upload->saveName  =     "ktbg";  //设置上传文件的保存文件名			
			$info   =   $upload->upload();
			if(!$info) {// 上传错误,提示错误信息
				$error=$upload->getError();
				$content="<script >alert('$error');window.history.back(-1);</script>";//弹出提示然后页面后退一步
				$this->show($content);
			}
			else{// 上传成功 获取上传文件信息
				//将信息存储进入数据库
				foreach ($info as $file){
					$savepath=iconv("GBK","UTF-8",$file['savepath'].$file['savename']);
					//$name=iconv("GBK","UTF-8",$file['name']);
					$name=$file['name'];
				}				
				$sql="UPDATE `gds_xs` SET `ktbg`='$savepath',`sj_ktbg`='$time' where `xh`='$xh'";
				if(M()->execute($sql)){
					//成功插入数据
					$content=$name.'上传成功!!!';
					$content="<script >alert('$content');window.history.back(-1);</script>";
					$this->show($content);
				}					
				else {
					//插入数据失败，这种几率十分小
					$content="<script >alert('网络连接不稳定，请重新上传文件');window.history.back(-1);</script>";
					$this->show($content);
				}					
			}
		}
		else if($judgeFile==2){
			//毕业论文
			$upload->maxSize   =     3145728 ;// 设置附件上传大小 3M
			$upload->exts      =     array('docx','doc', 'zip', 'rar');// 设置附件上传类型
			$upload->maxSize   =     3145728 ;// 设置附件上传大小 3M
			$upload->savePath  =     $path; // 设置附件上传（子）目录
			$upload->saveName  =     "bylw";  //设置上传文件的保存文件名
			$info   =   $upload->upload();
			if(!$info) {		// 上传错误,提示错误信息	
				$error=$upload->getError();
				$content="<script >alert('$error');window.history.back(-1);</script>";//弹出提示然后页面后退一步
				$this->show($content);			
			}
			else{// 上传成功 获取上传文件信息	
				//将信息存储进入数据库
				foreach ($info as $file){
					$savepath=iconv("GBK","UTF-8",$file['savepath'].$file['savename']);
					$name=$file['name'];
				}
				//UPDATE `gds_xs` SET `ktbg`="dadwa",`sj_ktbg`="" where `xh`="2009910145"
				$sql="UPDATE `gds_xs` SET `bylw`='$savepath',`sj_bylw`='$time' where `xh`='$xh'";
				if(M()->execute($sql)){
					//成功插入数据
					$content=$name.'上传成功!!!';
					$content="<script >alert('$content');window.history.back(-1);</script>";
					$this->show($content);
				}					
				else {
					//插入数据失败，这种几率十分小
					$content="<script >alert('网络连接不稳定，请重新上传文件');window.history.back(-1);</script>";
					$this->show($content);
				}	
			}			
		}
		else if($judgeFile==3){
			//程序设计
			$upload->maxSize   =     3145728 ;// 设置附件上传大小 3M
			$upload->exts      =     array('docx','doc', 'zip', 'rar');// 设置附件上传类型
			$upload->maxSize   =     3145728 ;// 设置附件上传大小 3M
			$upload->savePath  =     $path; // 设置附件上传（子）目录
			$upload->saveName  =     "cx";  //设置上传文件的保存文件名
			$info   =   $upload->upload();
			if(!$info) {// 上传错误提示错误信息
				$error=$upload->getError();
				$content="<script >alert('$error');window.history.back(-1);</script>";//弹出提示然后页面后退一步
				$this->show($content);	
			}
			else{// 上传成功 获取上传文件信息
				//将信息存储进入数据库
				foreach ($info as $file){
					$savepath=iconv("GBK","UTF-8",$file['savepath'].$file['savename']);
					$name=$file['name'];
				}
				$sql="UPDATE `gds_xs` SET `cx`='$savepath',`sj_cx`='$time' where `xh`='$xh'";
				if(M()->execute($sql)){
					//成功插入数据
					$content=$name.'上传成功!!!';
					$content="<script >alert('$content');window.history.back(-1);</script>";
					$this->show($content);
				}					
				else {
					//插入数据失败，这种几率十分小
					$content="<script >alert('网络连接不稳定，请重新上传文件');window.history.back(-1);</script>";
					$this->show($content);
				}
			}
		}
		
	}
	
}


?>