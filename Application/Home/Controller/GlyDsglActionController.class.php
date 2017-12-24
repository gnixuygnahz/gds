<?php
namespace Home\Controller;
use Think\Controller;
class GlyDsglActionController extends Controller {
    public function index(){

        $data=D('Init','Logic')->run();

        if($data['err']!=0){


        }

        $data['load']=U('GlyDsglAction/load');
        $data['saveJs']=U('GlyDsglAction/saveJs');
        $data['updataJs']=U('GlyDsglAction/updataJs');
        $data['destroyJs']=U('GlyDsglAction/destroyJs');
        $data['resetMm']=U('GlyDsglAction/resetMm');
        $this->assign($data);

        $this->display();
    }

    public function resetMm(){

        $data=D('Init','Logic')->run();

        $jsbh=I('post.jsbh');

        if($data['err']==0&&$data['qx']==1){

			D('Js')->resetJs($jsbh);

        }

        

        $this->ajaxReturn($data);

    }

    public function load(){

        $data=D('Init','Logic')->run();

        //==============================获取数据

        $page = I('post.page',1);
        $rows = I('post.rows',10);

        //==============================
		
		if($data['err']==0&&$data['qx']==1){

			if(!I('post.sort',0)==0){
 
            $data['data']=D('Js')->getJsByGlySort($page,$rows,I('post.sort'),I('post.order'));
        }else{
            
            $data['data']=D('Js')->getJsByGly($page,$rows);
        }

        }

        

        $this->ajaxReturn($data['data']);
    }

    public function saveJs(){

        $data=D('Init','Logic')->run();
        //==============================获取数据



        $jsbh=I('post.jsbh');
        $xm=I('post.xm');
        $zy=I('post.zy');
        $zc=I('post.zc');
        $qq=I('post.qq');
        $tel=I('post.tel');
        $xy=I('post.xy');
        $qx=I('post.qx');
        //==============================错误判断和权限判断

        if($data['err']==0&&$data['qx']==1){

			if(!D('Js')->getjs($jsbh)){
            D('Js')->newJs($jsbh,$xm,$zy,$zc,$qq,$tel,$xy,$qx);
        }else{
            $data['err']='教师编号重复';
        }

        }

        
        $this->ajaxReturn($data);

    }

    public function updataJs(){

        $data=D('Init','Logic')->run();
        //==============================获取数据

        $jsbh=I('post.jsbh');
        $xm=I('post.xm');
        $zy=I('post.zy');
        $zc=I('post.zc');
        $qq=I('post.qq');
        $tel=I('post.tel');
        $xy=I('post.xy');
        $qx=I('post.qx');
        //==============================错误判断和权限判断

        if($data['err']==0&&$data['qx']==1){

			D('Js')->updataJs($jsbh,$xm,$zy,$zc,$qq,$tel,$xy,$qx);

        }

        

        $this->ajaxReturn($data);

    }

    public function destroyJs(){

        $data=D('Init','Logic')->run();

        $jsbh=I('post.jsbh');

        if($data['err']==0&&$data['qx']==1){

			D('Js')->destroyJs($jsbh);

        }

        

        $this->ajaxReturn($data);

    }
}