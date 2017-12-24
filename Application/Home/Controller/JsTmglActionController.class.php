<?php
namespace Home\Controller;
use Think\Controller;
class JsTmglActionController extends Controller {
    public function index(){
        $data=D('Init','Logic')->run();

        if($data['err']!=0){


        }

        $data['load']=U('JsTmglAction/load');
        $data['saveTm']=U('JsTmglAction/saveTm');
        $data['updataTm']=U('JsTmglAction/updataTm');
        $data['destroyTm']=U('JsTmglAction/destroyTm');
        $data['chuti']=D("Settings")->get("ctgn");

        $this->assign($data);
        $this->display();

    }

    public function load(){

        $data=D('Init','Logic')->run();

        //==============================获取数据

        $page = I('post.page',1);
        $rows = I('post.rows',10);

        //==============================
		
		if($data['err']==0&&$data['qx']==0){

			$data['data']=D('Tm')->getTm($page,$rows,$data['bh']);

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

        if($data['err']==0&&$data['qx']==0){

			if(D("Settings")->get("ctgn")==1){
            D('Tm')->newTm($tmms,$tmmc,$data['bh'],$kfjs);
        }else{
			$data['err']='非出题阶段禁止出题';
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

        if($data['err']==0&&$data['qx']==0){

			if(D("Settings")->get("ctgn")==1) {
            D('Tm')->updataTm($tmbh, $tmms, $tmmc, $data['bh'], $kfjs);
        }

        }
        
        $this->ajaxReturn($data);

    }

    public function destroyTm(){

        $data=D('Init','Logic')->run();

        $tmbh=I('post.tmbh');

        if($data['err']==0&&$data['qx']==0){

			if(D("Settings")->get("ctgn")==1) {
            D('Tm')->destroyTm($tmbh, $data['bh']);
        }

        }
        
        $this->ajaxReturn($data);

    }

}