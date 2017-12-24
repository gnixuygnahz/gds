<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function loginAction(){

        \Think\Build::buildModel('Home','Tm');

        $data=D('Init','Logic')->run();

        if($data['err']==0){

            if($data['qx']==-1){
                $xs=D('Xs')->getxs($data['bh']);

                $data['xm']=$xs['xm'];

            }else{
                $js=D('Js')->getjs($data['bh']);

                $data['xm']=$js['xm'];
            }

        }else{



            redirect(U('Login/logout'),0,'');

        }

        $data['logout']=U('Login/logout');
        $data['CktzAction']=U('CktzAction/index');
        $data['JsTmglAction']=U('JsTmglAction/index');
        $data['JsCkxsAction']=U('JsCkxsAction/index');
        $data['XgmmAction']=U('Login/xgmmAction');
        //$data['GlyFbtzAction']=U('GlyFbtzAction/index');
        $data['GlyFbtzAction']=U('GlyFbtzAction/index');
        $data['GlyDsglAction']=U('GlyDsglAction/index');
        $data['GlyXsglAction']=U('GlyXsglAction/index');
        $data['JsJsxxAction']=U('JsJsxxAction/index');
        $data['JsDcwjAction']=U('JsDcwjAction/index');
        $data['GlyZyszAction']=U("GlyZyszAction/index");
        $data['GlyQtgnAction']=U("GlyQtgnAction/index");
        $data['GlyTmglAction']=U("GlyTmglAction/index");
        $data['GlyTzglAction']=U("GlyTzglAction/index");

        //=====================================================
        //这里开始是学生界面基本参数及其配置
        $data['StuXtAction']=U("StuXtAction/stuXt");//选课界面
        $data['StuXtResultAction']=U("StuXtResultAction/stuXtResult");//选课结果界面
        $data['StuUploadAction']=U("StuUploadAction/stuUpload");//提交毕业设计页面
        //=======================================================

        $this->assign($data);
        $this->display();
    }


    public function logout(){

        D('Init','Logic')->loginout();

        $data['comfirmAction']=U('Index/comfirm');
        $data['loginAction']=U('Login/loginAction');

        $this->assign($data);

        $this->display('Index:login');

    }

    public function xgmmAction(){


        $data=D('Init','Logic')->run();


        $new=I('post.new');
        $old=I('post.old');
        $con=I('post.con');

        if($data['err']==0){


            if($new==$con){

                switch($data['qx']){

                    case -1:
                    if(D('Xs')->getXsByMm($data['bh'],$old)){
                        D('Xs')->xgmm($data['bh'],$old,$new);
                    }else{
                        $data['err']="密码错误";
                    }
                       
                        break;
                    case 0:
                    case 1:

                    if(D('Js')->getJsByMm($data['bh'],$old)){
                        D('Js')->xgmm($data['bh'],$old,$new);
                    }else{
                        $data['err']="密码错误";
                    }
                    
                    break;
                }

            }else{

                $data['err']=401;

            }

            $this->ajaxReturn($data);

        }else{

            $this->ajaxReturn($data);

        }



    }

}