<?php
namespace Home\Controller;
use Think\Controller;
class JsJsxxActionController extends Controller {



    public function index(){

        $data=D('Init','Logic')->run();
        if($data['err']!=0){

        }

        $data['load']=U('JsJsxxAction/load');

        $data['updataJs']=U('JsJsxxAction/updataJs');

        $this->assign($data);
        $this->display();

    }

    public function load(){
        $data=D('Init','Logic')->run();

        
/*
        foreach($data['data'][0] as $key => $value){
            $data['data2'][]=array("name"=>$key,"value"=>$value);
        }
*/

		if($data['err']==0&&$data['qx']==0){

			$data['data']=D('Js')->getInfoByJs($data['bh']);
			
			$data['data3'][]=array("name"=>"姓名","value"=>$data['data'][0]['xm']);
        $data['data3'][]=array("name"=>"专业","value"=>$data['data'][0]['zy']);
        $data['data3'][]=array("name"=>"职称","value"=>$data['data'][0]['zc']);
$data['data3'][]=array("name"=>"联系电话","value"=>$data['data'][0]['tel']);
        $data['data3'][]=array("name"=>"QQ","value"=>$data['data'][0]['qq']);

        }
		
        
        

        $this->ajaxReturn($data['data3']);
    }

    public function updataJs(){

        $data=D('Init','Logic')->run();
        //==============================获取数据

        $qq=I('post.qq');
        $tel=I('post.tel');
        $zc=I('post.zc');

        //==============================错误判断和权限判断

        if($data['err']==0&&$data['qx']==0){

			D('Js')->updataInfoByJs($data['bh'],$qq,$tel,$zc);

        }

        

        $this->ajaxReturn($data);

    }
}