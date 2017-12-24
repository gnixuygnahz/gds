<?php
namespace Home\Model;
use Think\Model;
class JsModel extends Model {
    public function getsui($jsbh){
        return $this->where("jsbh = '$jsbh'")->getField('sui');
    }

    public function getXy($jsbh){
        return $this->where("jsbh = '$jsbh' and jsbh!='admin'")->getField('xy');
    }

    public function getJsByXy($xy){
        return $this->where("xy ='$xy' and jsbh!='admin'")->select();
    }

     public function getJsByMm($jsbh,$mm){
        return $this->where("jsbh = '$jsbh' and mm = '$mm'")->find();
    }

    public function getjs($jsbh){
        return $this->where("jsbh = '$jsbh'")->find();
    }
    
    public function resetJs($jsbh){
        $data['jsbh']=$jsbh;
        $data['mm']=$jsbh;
    
        $this->where("jsbh= '$jsbh'")->save($data);
    }

    public function getAll(){
        return $this->where("1 and jsbh!='admin'")->select();
    }

    public function setsui($jsbh,$sui){
        return $this->where("jsbh = '$jsbh'")->setField('sui',$sui);
    }

    public function xgmm($bh,$old,$new){

        return $this->where("jsbh = '".$bh."' and mm ='".$old."'")->setField('mm',$new);

    }

    public function getJsByGly($page,$rows){
        $data['total']=$this->count();
        $data['rows']=$this->where("1 and jsbh!='admin'")->limit((($page-1)*$rows).','.$rows)->select();
        return $data;
    }

    public function getJsByGlySort($page,$rows,$sort,$asc){
        $data['total']=$this->count();
        $data['rows']=$this->where("1 and jsbh!='admin'")->limit((($page-1)*$rows).','.$rows)->order($sort." ".$asc)->select();
        return $data;
    }


    public function newJs($jsbh,$xm,$zy,$zc,$qq,$tel,$xy,$qx){
        $data['jsbh']=$jsbh;
        $data['mm']=$jsbh;
        $data['xm']=$xm;
        $data['zy']=$zy;
        $data['zc']=$zc;
        $data['qq']=$qq;
        $data['qx']=$qx;
        $data['tel']=$tel;
        

        $this->create($data);
        $this->add();
    }

    public function newJs1($jsbh,$xm,$xy,$zy,$zc,$qx,$qq,$tel){
        $data['jsbh']=$jsbh;
        $data['mm']=$jsbh;
        $data['xm']=$xm;
        $data['zy']=$zy;
        $data['zc']=$zc;
        $data['qq']=$qq;
        $data['tel']=$tel;
        $data['xy']=$xy;
        $data['qx']=$qx;
        $this->create($data);
        $this->add();
    }

    public function newJsByGly($jsbh,$mm,$xm,$zy,$zc,$qx,$qq,$tel,$sui){
        $data['jsbh']=$jsbh;
        $data['mm']=$mm;
        $data['qx']=$qx;
        $data['sui']=$sui;
        $data['mm']=$jsbh;
        $data['xm']=$xm;
        $data['zy']=$zy;
        $data['zc']=$zc;
        $data['qq']=$qq;
        $data['tel']=$tel;
        $this->create($data);
        $this->add();
    }

    public function updataJs($jsbh,$xm,$zy,$zc,$qq,$tel,$xy,$qx){
        $data['jsbh']=$jsbh;
        $data['mm']=$jsbh;
        $data['xm']=$xm;
        $data['zy']=$zy;
        $data['zc']=$zc;
        $data['qq']=$qq;
        $data['tel']=$tel;
        // $data['xy']=$xy;
        $data['qx']=$qx;
        $this->where("jsbh= '$jsbh'")->save($data);
    }

    public function destroyJs($jsbh){
        return $this->where("jsbh= '$jsbh'  and jsbh!='admin'")->delete();
    }

    public function getInfoByJs($jsbh){
        return $this->field("xm,zy,zc,qx,qq,tel")->where('jsbh ='."'$jsbh'")->select();
    }

    public function updataInfoByJs($jsbh,$qq,$tel,$zc){
        $data['qq']=$qq;
        $data['tel']=$tel;
        $data['jsbh']=$jsbh;
        $data['zc']=$zc;
        $this->where("jsbh= '$jsbh'")->save($data);
    }
}