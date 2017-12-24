<?php
namespace Home\Model;
use Think\Model;
class TzModel extends Model {

    public function getTzByGly($page,$rows){

        $data['total']=$this->count();

        $data['rows']=$this->where('1')->limit((($page-1)*$rows).','.$rows)->select();

        return $data;
    }

    public function getall(){
        return $this->where('1')->select();
    }

    public function getTz($Id){
        return $this->where('Id ='.$Id)->find();
    }

    public function getTzByFy($page,$rows){
        $data['total']=$this->count();


        $data['rows']=$this->limit((($page-1)*$rows).','.$rows)->order("fbrq desc")->select();

        return $data;
    }

    public function newTz($bt,$nr){
        $data['bt']=$bt;
        $data['nr']=$nr;
        $data['fbrq']=date("Y-m-d H:i:s",time());
        $this->create($data);
        $this->add();
    }
    public function destroyTzByGly($id){
        return $this->where("Id = $id")->delete();
    }

}