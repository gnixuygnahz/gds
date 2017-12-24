<?php
namespace Home\Controller;
use Think\Controller;
class JsCkxsActionController extends Controller {
    public function index(){

        $data=D('Init','Logic')->run();

        $data['load']=U('JsCkxsAction/load');

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

			$data['data']=D('Xs')->getXsByJs($page,$rows,$data['bh']);

        }

        

        $this->ajaxReturn($data['data']);
    }
}