<?php
namespace Home\Controller;
use Think\Controller;
class GlyFbtzActionController extends Controller {
    public function index(){
        $data=D('Init','Logic')->run();
        $data['fbtz']=U("GlyFbtzAction/fbtz");
        $this->assign($data);
        $this->display();
    }

    public function fbtz(){
        $data=D('Init','Logic')->run();

        $bt=I("post.bt");
        $nr=$_POST['nr'];

		if($data['err']==0&&$data['qx']==1){

			$data['data']=D('Tz')->newTz($bt,$nr);

        }
		

        
        $this->ajaxReturn($data);
    }

}