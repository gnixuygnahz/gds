<?php
namespace Home\Model;
use Think\Model;
class XsModel extends Model {

    public function getsui($xh){
        return $this->where("xh = '$xh'")->getField('sui');
    }

    public function getxs($xh){
        return $this->where("xh = '$xh'")->find();
    }

    public function getXsByMm($xh,$mm){
        return $this->where("xh = '$xh' and mm = '$mm'")->find();
    }

    public function getAll(){
        return $this->field("gds_xs.*,gds_js.xm as jsxm,gds_tm.tmmc as tmmc")->where("1")->join('gds_js ON gds_xs.jsbh = gds_js.jsbh')->join('gds_tm ON gds_tm.tmbh = gds_xs.tmbh')->select();
    }

    public function setsui($xh,$sui){
        return $this->where("xh = '$xh'")->setField('sui',$sui);
    }

    public function getXsByJs($page,$rows,$jsbh){
        $data['total']=$this->where("jsbh='$jsbh'")->count();
        $data['rows']=$this->field("xh,xm,bj,zy,xy,tmbh,cj,qq,tel,ktbg,bylw,cx")->where("jsbh='$jsbh'")->limit((($page-1)*$rows).','.$rows)->select();

        $data['rows']=$this->query("select gds_xs.sj_bylw,gds_xs.sj_ktbg,gds_xs.sj_cx,gds_xs.xh,gds_xs.xm,gds_xs.bj,gds_xs.zy,gds_xs.xy,gds_xs.tmbh,gds_xs.cj,gds_xs.qq,gds_xs.tel,gds_xs.ktbg,gds_xs.bylw,gds_xs.cx,gds_tm.tmmc from gds_xs LEFT JOIN gds_tm on gds_tm.tmbh=gds_xs.tmbh WHERE gds_xs.jsbh = '$jsbh' limit ".(($page-1)*$rows).','.$rows);


        return $data;
    }

        public function getXsByGlySort($page,$rows,$sort,$asc){
        $data['total']=$this->count();
        $data['rows']=$this->where('1')->limit((($page-1)*$rows).','.$rows)->order($sort." ".$asc)->select();
        return $data;
    }

    public function xgmm($bh,$old,$new){

        return $this->where("xh = '".$bh."' and mm ='".$old."'")->setField('mm',$new);

    }

       public function resetXs($xh){
        $data['xh']=$xh;
        $data['mm']=$xh;
        $this->where("xh= '$xh'")->save($data);
    }
	
	  public function resetTm($xh){
        $data['jsbh']='';
        $data['tmbh']='';
        $this->where("xh= '$xh'")->save($data);
    }

    public function getXsByGly($page,$rows){
        $data['total']=$this->count();
        $data['rows']=$this->query("select gds_xs.xh,gds_xs.xm,gds_xs.bj,gds_xs.zy,gds_xs.xy,gds_xs.tmbh,gds_xs.cj,gds_xs.qq,gds_xs.tel,gds_xs.ktbg,gds_xs.bylw,gds_xs.cx,gds_tm.tmmc,gds_xs.jsbh,gds_js.xm jsxm from gds_xs LEFT JOIN gds_tm on gds_tm.tmbh=gds_xs.tmbh LEFT JOIN gds_js on gds_xs.jsbh=gds_js.jsbh WHERE 1 limit ".(($page-1)*$rows).','.$rows);

        return $data;
    }

    public function getXsByGly2($page,$rows,$sort,$asc,$s_xh,$s_xm,$s_bj){
        $s_xh=trim($s_xh);
        $s_xm=trim($s_xm);
        $s_bj=trim($s_bj);
        $data['total']=$this->query("select count(*) from gds_xs LEFT JOIN gds_tm on gds_tm.tmbh=gds_xs.tmbh LEFT JOIN gds_js on gds_xs.jsbh=gds_js.jsbh WHERE 1 ".($s_xh==""?"":"and gds_xs.xh like '%".$s_xh."%' ").($s_xm==""?"":"and gds_xs.xm like '%".$s_xm."%' ").($s_bj==""?"":"and gds_xs.bj like '%".$s_bj."%' "));
        $data['total']=$data['total'][0]['count(*)'];
        
        $data['rows']=$this->query("select gds_xs.xh,gds_xs.xm,gds_xs.bj,gds_xs.zy,gds_xs.xy,gds_xs.tmbh,gds_xs.cj,gds_xs.qq,gds_xs.tel,gds_xs.ktbg,gds_xs.bylw,gds_xs.cx,gds_tm.tmmc,gds_xs.jsbh,gds_js.xm jsxm from gds_xs LEFT JOIN gds_tm on gds_tm.tmbh=gds_xs.tmbh LEFT JOIN gds_js on gds_xs.jsbh=gds_js.jsbh WHERE 1 ".($s_xh==""?"":"and gds_xs.xh like '%".$s_xh."%' ").($s_xm==""?"":"and gds_xs.xm like '%".$s_xm."%' ").($s_bj==""?"":"and gds_xs.bj like '%".$s_bj."%' ").(!$sort?" order by gds_xs.xh desc ":" order by ".$sort." ".$asc)." limit ".(($page-1)*$rows).','.$rows);
        return $data;
    }

    public function newXs($xh,$xm,$bj,$zy,$xy,$qq,$tel){
        $data['xh']=$xh;
        $data['mm']=$xh;
        $data['xm']=$xm;
        $data['zy']=$zy;
        $data['bj']=$bj;
        // $data['xy']=$xy;
        $data['qq']=$qq;
        $data['tel']=$tel;
        $this->create($data);
        $this->add();
    }

    public function newXsByGly($xh,$mm,$xm,$bj,$zy,$xy,$jsbh,$tmbh,$cj,$qq,$tel,$ktbg,$bylw,$cx,$sui){
        $data['xh']=$xh;
        $data['mm']=$mm;
        $data['mm']=$xh;
        $data['xm']=$xm;
        $data['zy']=$zy;
        $data['bj']=$bj;
        $data['xy']=$xy;
        $data['jsbh']=$jsbh;
        $data['tmbh']=$tmbh;
        $data['cj']=$cj;
        $data['qq']=$qq;
        $data['tel']=$tel;
        $data['ktbg']=$ktbg;
        $data['bylw']=$bylw;
        $data['cx']=$cx;
        $data['sui']=$sui;
        $this->create($data);
        $this->add();
    }

    public function updataXs($xh,$xm,$bj,$zy,$xy,$cj,$qq,$tel){
        $data['xh']=$xh;
        $data['mm']=$xh;
        $data['xm']=$xm;
        $data['zy']=$zy;
        $data['bj']=$bj;
        $data['xy']=$xy;
        $data['qq']=$qq;
        $data['tel']=$tel;
        $data['$cj']=$cj;
		
        $this->where("xh= '$xh'")->save($data);
    }

    public function destroyXs($xh){
        return $this->where("xh= '$xh'")->delete();
    }

    public function xgjs($xh,$jsbh){
        return $this->where("xh = '$xh'")->setField('jsbh',$jsbh);
    }
}