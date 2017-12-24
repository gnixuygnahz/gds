<?php
namespace Home\Controller;
use Think\Controller;
class CktzActionController extends Controller {

    public function index(){

        $data=D('Init','Logic')->run();

        if($data['err']==0){

            $data['load']=U('CktzAction/load');
            $data['tzview']=U('CktzAction/tzviewAction');

        }else{

dump($data['err']);


        }

        $this->assign($data);
        $this->display();
    }

    public function load(){

        $data=D('Init','Logic')->run();

        //==============================获取数据

        $page = I('post.page',1);
        $rows = I('post.rows',10);

        //==============================


        if($data['err']==0){

            $data['data']=D('Tz')->getTzByFy($page,$rows);

        }else{


        }
        $this->ajaxReturn($data['data']);
    }

    public function tzviewAction(){
        $data=D('Init','Logic')->run();

        $data['id']=I('get.id');

        $data['data']=U("CktzAction/tzviewActioni");
        $this->assign($data);
        $this->display();
    }

    public function tzviewActioni(){
        $data=D('Init','Logic')->run();

        $data['data']=D('Tz')->getTz(I('get.id'));

        $this->assign($data);
        $this->display();
    }
}