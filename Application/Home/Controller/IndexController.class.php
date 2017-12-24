<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function login(){

    



        //==================
		if(I('get.refresh',0)==0){
			redirect(U('Index/login?refresh=1'),0.1,'  ');
		}else{
			$data['comfirmAction']=U('Index/comfirm');
        $data['loginAction']=U('Login/loginAction');
		$data['err']=I('get.err','');
		}
     

        $this->assign($data);
        $this->display();
    }

    public function comfirm(){

        $bh=I('post.zh');
        $mm=I('post.mm');




        $data=D('Init','Logic')->login($bh,$mm);


        if($data['err']==0){

            redirect(U('Login/loginAction'),0,"");

        }else{
            redirect(U('Index/login?err=用户名或密码错误&refresh=1'),0,'');
        }


    }
}