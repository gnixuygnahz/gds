<?php
namespace Home\Model;
use Think\Model;
class SettingsModel extends Model {
    public function get($name){
        return $this->where("name = '".$name."'")->getField('value');
    }

    public function set($name,$value){
        return $this->where("name = '".$name."'")->setField('value',$value);
    }

    public function getAll(){
        return $this->where("1")->select();
    }
}