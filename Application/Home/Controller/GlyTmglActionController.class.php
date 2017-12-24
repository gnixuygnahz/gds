<?php
namespace Home\Controller;
use Think\Controller;
class GlyTmglActionController extends Controller {
    public function index(){
        $data=D('Init','Logic')->run();

        if($data['err']==0&&$data['qx']==1){

			

        }

        $data['load']=U('GlyTmglAction/load');
        $data['saveTm']=U('GlyTmglAction/saveTm');
        $data['updataTm']=U('GlyTmglAction/updataTm');
        $data['destroyTm']=U('GlyTmglAction/destroyTm');

        $this->assign($data);
        $this->display();

    }

    public function load(){

        $data=D('Init','Logic')->run();

        //==============================获取数据

        $page = I('post.page',1);
        $rows = I('post.rows',10);

        //==============================
		
		if($data['err']==0&&$data['qx']==1){

			$data['data']=D('Tm')->getTmByGly($page,$rows);

        }

        

        $this->ajaxReturn($data['data']);
    }

    public function saveTm(){

        $data=D('Init','Logic')->run();
        //==============================获取数据

        $tmmc=I('post.tmmc');
        $kfjs=I('post.kfjs');
        $tmms=I('post.tmms');

        //==============================错误判断和权限判断

        if($data['err']==0&&$data['qx']==1){

			if(D("Settings")->get("ctgn")==1){
            D('Tm')->newTmByGly($tmms,$tmmc,$data['bh'],$kfjs);
        }

        }

        $this->ajaxReturn($data);

    }

    public function updataTm(){

        $data=D('Init','Logic')->run();
        //==============================获取数据

        $tmmc=I('post.tmmc');
        $kfjs=I('post.kfjs');
        $tmms=I('post.tmms');
        $tmbh=I('get.tmbh');

        //==============================错误判断和权限判断

        if($data['err']==0&&$data['qx']==1){

			D('Tm')->updataTmByGly($tmbh,$tmms,$tmmc,$kfjs);

        }

        

        $this->ajaxReturn($data);

    }

    public function destroyTm(){

        $data=D('Init','Logic')->run();

        $tmbh=I('post.tmbh');

        if($data['err']==0&&$data['qx']==1){

			D('Tm')->destroyTmByGly($tmbh);

        }

        

        $this->ajaxReturn($data);

    }

}