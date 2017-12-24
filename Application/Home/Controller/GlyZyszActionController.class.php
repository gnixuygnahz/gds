<?php
namespace Home\Controller;
use Think\Controller;
class GlyZyszActionController extends Controller {

    public function index(){
        $data=D('Init','Logic')->run();
        $data['zysz']=U("GlyZyszAction/zysz");
        $this->assign($data);
        $this->display();
    }

    public function zysz(){

        $data=D('Init','Logic')->run();


        $name=I("get.name");
        $set=I("get.set");
		
		if($data['err']==0&&$data['qx']==1){

			if($name!=null&&$set!=null){

            D("Settings")->set($name,$set);

        }

        $data['comfrim']=U("GlyZyszAction/zysz");

        $data['data']=D("Settings")->getAll();

        }

        

        $this->assign($data);
        $this->display();
    }


}