<?php
namespace Home\Model;
use Think\Model;
class TmModel extends Model {
    public function getAllTmByZy($bj){
        $Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
        $data=$Model->query("select gds_tm.tmbh,gds_tm.tmmc,gds_tm.kfjs,gds_js.zy,gds_js.xm,gds_xs.bj from gds_tm INNER JOIN  gds_js  ON gds_js.jsbh=gds_tm.jsbh  LEFT JOIN gds_xs ON gds_xs.tmbh=gds_tm.tmbh and gds_xs.bj='".$bj."'");
        return $data;
    }

    public function getAll(){
        return $this->field("gds_tm.*,gds_js.xm as jsxm")->where("1")->join('gds_js ON gds_tm.jsbh = gds_js.jsbh')->select();
    }

    public function getTm($page,$rows,$jsbh){



        $data['rows']=$this->where("jsbh = '$jsbh'")->limit((($page-1)*$rows).','.$rows)->select();
        $data['total']=$this->where("jsbh = '$jsbh'")->count();
        return $data;
    }

    public function getJsbhByTmbh($tmbh){
        $data=$this->where("tmbh = $tmbh")->find();
        return $data['jsbh'];
    }

    public function newTm($tmms,$tmmc,$jsbh,$kfjs){

        $data['tmms']=$tmms;
        $data['tmmc']=$tmmc;
        $data['jsbh']=$jsbh;
        $data['kfjs']=$kfjs;
        $this->create($data);
        $this->add();

    }

    public function updataTm($tmbh,$tmms,$tmmc,$jsbh,$kfjs){
        $data['tmms']=$tmms;
        $data['tmmc']=$tmmc;
        $data['jsbh']=$jsbh;
        $data['kfjs']=$kfjs;
        $data['tmbh']=$tmbh;
        $this->where("tmbh= $tmbh and jsbh= '$jsbh'")->save($data);
    }

    public function destroyTm($id,$jsbh){
        return $this->where("tmbh = $id and jsbh= '$jsbh'")->delete();
    }

    public function destroyTzByGly($id){
        return $this->where("tmbh = $id")->delete();
    }
    public function getTmByGly($page,$rows){

        $data['total']=$this->count();

        $data['rows']=$this->where('1')->join('LEFT JOIN gds_js ON gds_js.jsbh = gds_tm.jsbh')->limit((($page-1)*$rows).','.$rows)->order('xm desc')->select();

        return $data;
    }

    public function newTmByGly($tmms,$tmmc,$jsbh,$kfjs){

        $data['tmms']=$tmms;
        $data['tmmc']=$tmmc;
        $data['jsbh']=$jsbh;
        $data['kfjs']=$kfjs;
        $this->create($data);
        $this->add();

    }

    public function updataTmByGly($tmbh,$tmms,$tmmc,$kfjs){
        $data['tmms']=$tmms;
        $data['tmmc']=$tmmc;

        $data['kfjs']=$kfjs;
        $data['tmbh']=$tmbh;
        $this->where("tmbh= $tmbh ")->save($data);
    }

    public function destroyTmByGly($id){
        return $this->where("tmbh = $id")->delete();
    }
}