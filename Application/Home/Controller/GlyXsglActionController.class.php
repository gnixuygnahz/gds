<?php
namespace Home\Controller;
use Think\Controller;
class GlyXsglActionController extends Controller {
    public function index(){

        $data=D('Init','Logic')->run();

        if($data['err']!=0){


        }

        $data['load']=U('GlyXsglAction/load');
        $data['saveXs']=U('GlyXsglAction/saveXs');
        $data['updataXs']=U('GlyXsglAction/updataXs');
        $data['destroyXs']=U('GlyXsglAction/destroyXs');
        $data['loadJs']=U('GlyXsglAction/loadJs');
        $data['xgjs']=U('GlyXsglAction/xgjs');
        $data['resetMm']=U('GlyXsglAction/resetMm');
		$data['resetTm']=U('GlyXsglAction/resetTm');
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

			$data['data']=D('Xs')->getXsByGly2($page,$rows,I('post.sort'),I('post.order'),I('post.xs_search_xh',""),I('post.xs_search_xm',""),I('post.xs_search_bj',""));

        }

        
        $this->ajaxReturn($data['data']);
    }

     public function resetMm(){

        $data=D('Init','Logic')->run();

        $xh=I('post.xh');

        if($data['err']==0&&$data['qx']==1){

			D('Xs')->resetXs($xh);

        }

        

        $this->ajaxReturn($data);

    }
	
	public function resetTm(){

        $data=D('Init','Logic')->run();

        $xh=I('post.xh');

        if($data['err']==0&&$data['qx']==1){

			D('Xs')->resetTm($xh);

        }

        $this->ajaxReturn($data);

    }

    public function saveXs(){

        $data=D('Init','Logic')->run();
        //==============================获取数据



        $xh=I('post.xh');
        $xm=I('post.xm');
        $bj=I('post.bj');
        $zy=I('post.zy');
        $xy=I('post.xy');
        $qq=I('post.qq');
        $tel=I('post.tel');

        //==============================错误判断和权限判断

        if($data['err']==0&&$data['qx']==1){

			if(!D('Xs')->getxs($xh)){
            D('Xs')->newXs($xh,$xm,$bj,$zy,$xy,$qq,$tel);
        }else{
            $data['err']='学号重复';
        }

        }
        $this->ajaxReturn($data);

    }

    public function updataXs(){

        $data=D('Init','Logic')->run();
        //==============================获取数据

        $xh=I('post.xh');
        $xm=I('post.xm');
        $bj=I('post.bj');
        $zy=I('post.zy');
        $xy=I('post.xy');
	
        $cj=I('post.cj');
        $qq=I('post.qq');
        $tel=I('post.tel');

        //==============================错误判断和权限判断

        if($data['err']==0&&$data['qx']==1){

			 D('Xs')->updataXs($xh,$xm,$bj,$zy,$xy,$cj,$qq,$tel);

        }

        
       
        $this->ajaxReturn($data);
    }

    public function destroyXs(){

        $data=D('Init','Logic')->run();

        $xh=I('post.xh');

        if($data['err']==0&&$data['qx']==1){

			 D('Xs')->destroyXs($xh);

        }

       

        $this->ajaxReturn($data);

    }

    public function loadJs(){
        $data=D('Init','Logic')->run();
        // $xy=D('Js')->getXy($data['bh']);
        // $js=D('Js')->getJsByXy($xy);
        
		
		if($data['err']==0&&$data['qx']==1){

			$js=D('Js')->getAll();

        }
		
        $this->ajaxReturn($js);
    }

    public function xgjs(){
        $data=D('Init','Logic')->run();
		
		if($data['err']==0&&$data['qx']==1){

			$xh=I('post.xh');
        $jsbh=I('post.jsbh');
        D('Xs')->xgjs($xh,$jsbh);

        }
		
        
        $this->ajaxReturn($data['err']);
    }
}