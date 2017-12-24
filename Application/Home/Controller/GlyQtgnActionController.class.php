<?php
namespace Home\Controller;
use Think\Controller;
class GlyQtgnActionController extends Controller {
    public function index(){
        $data=D('Init','Logic')->run();



        $data['xssc']=U("GlyQtgnAction/xssc");
        $data['jssc']=U("GlyQtgnAction/jssc");
		$data['jsdc']=U("GlyQtgnAction/jsdc");
        $data['xsdc']=U("GlyQtgnAction/xsdc");
        $data['tmdc']=U("GlyQtgnAction/tmdc");
        $data['xsmb']=U("GlyQtgnAction/xsmb");
        $data['jsmb']=U("GlyQtgnAction/jsmb");

        $this->assign($data);
        $this->display();
    }

    public function xssc(){
        $data=D('Init','Logic')->run();
		
		if($data['err']==0&&$data['qx']==1){

			$upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728 ;// 设置附件上传大小
        $upload->exts = array('xls','xlsx');// 设置附件上传类型
        $upload->rootPath = './Uploads/'; // 设置附件上传根目录
		//上传单个文件
		$info = $upload->uploadOne($_FILES['file1']);
		if(!$info) {// 上传错误提示错误信息
		    $this->error($upload->getError());
		}else{// 上传成功 获取上传文件信息
	
	    echo "上传成功";
	
	    D("PHPExcel","Logic")->xsDaoru("./Uploads/".$info['savepath'].$info['savename']);

}

        }

        

    }

    public function jssc(){
        $data=D('Init','Logic')->run();
		
		if($data['err']==0&&$data['qx']==1){

			$upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728 ;// 设置附件上传大小
        $upload->exts = array('xls','xlsx');// 设置附件上传类型
        $upload->rootPath = './Uploads/'; // 设置附件上传根目录
//上传单个文件
        $info = $upload->uploadOne($_FILES['file1']);
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息

           echo "上传成功";

            D("PHPExcel","Logic")->jsDaoru("./Uploads/".$info['savepath'].$info['savename']);





        }

        }

        

    }

    public function jsdc(){
    $data=D('Init','Logic')->run();

	if($data['err']==0&&$data['qx']==1){

			 D("PHPExcel","Logic")->jsDaochu();

        }
	
   


}
    public function xsdc(){
        $data=D('Init','Logic')->run();

		if($data['err']==0&&$data['qx']==1){

			D("PHPExcel","Logic")->xsDaochu();

        }
		
        


    }


    public function tmdc(){
        $data=D('Init','Logic')->run();
		
		if($data['err']==0&&$data['qx']==1){

			D("PHPExcel","Logic")->tmDaochu();

        }

        


    }

    public function xsmb(){
        $data=D('Init','Logic')->run();
		
		if($data['err']==0&&$data['qx']==1){

			D("File","Api")->getDb("学生信息统计表.xls");

        }
        
    }

    public function jsmb(){
        $data=D('Init','Logic')->run();
		
		if($data['err']==0&&$data['qx']==1){

			D("File","Api")->getDb("教师信息统计表.xls");

        }
        
    }

    public function beifen(){

    }

}