<?php
namespace Home\Controller;
use Think\Controller;
class GlyTzglActionController extends Controller {
    public function index(){
        $data=D('Init','Logic')->run();

        if($data['err']!=0){


        }

        $data['load']=U('GlyTzglAction/load');
        $data['saveTz']=U('GlyTzglAction/saveTz');
        $data['updataTz']=U('GlyTzglAction/updataTz');
        $data['destroyTz']=U('GlyTzglAction/destroyTz');

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

			$data['data']=D('Tz')->getTzByGly($page,$rows);

        }

        

        $this->ajaxReturn($data['data']);
    }



    public function destroyTz(){

        $data=D('Init','Logic')->run();

        $tzbh=I('post.tzbh');

        if($data['err']==0&&$data['qx']==1){

			D('Tz')->destroyTzByGly($tzbh);

        }

        

        $this->ajaxReturn($data);

    }
}