<?php
namespace Home\Controller;
use Think\Controller;
class JsDcwjActionController extends Controller {
    public function index(){

        $data=D('Init','Logic')->run();
		
		if($data['err']==0&&$data['qx']==0){

			D("File","Api")->getAllFileByJs($data['bh']);

        }

        

    }
}

