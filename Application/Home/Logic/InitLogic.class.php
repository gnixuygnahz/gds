<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/18
 * Time: 15:12
 *
 * 错误类型 err{
 * 101 异地登录
 * 102 未登录非法访问
 *
 * 201 无此用户
 * 202 密码错误
 * }
 *
 * $data['err']
 * $data['qx']  -1  0   1
 *
 *$data['bh']  xh  jsbh  
 */

namespace Home\Logic;
use Think\Controller;

class InitLogic
{

    /*
     *
     * 初始化模块
     *
     * 无参数
     *
     * 返回值 成功识别 返回用户相关信息
     *        失败  返回错误参数
     *
     * 功能：用于识别当前用户
     *
     * */
    public function run(){

        $data['err']=0;



        if(session('?qx')&&session('?bh')&&session('?sui')){
            if(session('qx')==-1){
                if(D('Xs')->getsui(session('bh'))==session('sui')){


                    $data['bh']=session('bh');
                    $data['qx']=-1;



                }else{

                    $data['err']=101;//异地登录


                }


            }else{
                $js=D('Js')->getjs(session('bh'));
                if(D('Js')->getsui(session('bh'))==session('sui')){

                    $data['bh']=$js['jsbh'];
                    $data['qx']=session('qx');



                }else{

                    $data['err']='帐户在别处被登录';//异地登录


                }

            }
        }else{

            $data['err']=102;//访问未登录

        }

        return $data;
    }

    /*
     * 登出模块
     *
     * 无参数
     *
     * 无返回值
     *
     * 功能：登出，重置session
     * */
    public function loginout(){



        session('[destroy]'); // 销毁session
        session('[regenerate]'); // 重新生成session id

    }

    /*
    * 登录模块
    *
    * 参数  登录类型：学生（-1）教师（0）
    *       编号
    *       密码
    *
    * 返回值  错误参数
    *
    * 功能：登录，设置session
    *
    * */
    public function login($bh,$mm){

        $data['err']=0;





            $xs=D('Xs')->getxs($bh);

            if($xs!=null){

                if($mm==$xs['mm']) {

                    $sui = \Org\Util\String::keyGen();
                    session('qx', -1);
                    session('bh', $bh);
                    session('sui', $sui);
                    D('Xs')->setsui($bh, $sui);

                    return $data;
                }else{

                    $data['err']=202;//密码错误
                    return $data;
                }

            }else{

                $data['err']=201;//无此用户

            }

        $data['err']=0;

            $js=D('Js')->getjs($bh);

            if($js!=null){

                if($mm==$js['mm']) {

                    $sui = \Org\Util\String::keyGen();
                    session('qx', $js['qx']);
                    session('bh', $bh);
                    session('sui', $sui);
                    D('Js')->setsui($bh, $sui);
                    return $data;
                }else{

                    $data['err']=202;//密码错误
                    return $data;
                }

            }else{

                $data['err']=201;//无此用户

            }



        return $data;

    }

}