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


class PHPExcelLogic
{

    public function xsDaoru($path){
        M("Xs")->where('1')->delete();
        Vendor('PHPExcel.PHPExcel');
        Vendor('PHPExcel.PHPExcel.IOFactory');
        Vendor('PHPExcel.PHPExcel.Reader.Excel5');
        $objReader=\PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format
        $objPHPExcel=$objReader->load($path);//$file_url即Excel文件的路径
        $sheet=$objPHPExcel->getSheet(0);//获取第一个工作表
        $highestRow=$sheet->getHighestRow();//取得总行数
        $highestColumn=$sheet->getHighestColumn(); //取得总列数
//循环读取excel文件,读取一条,插入一条
        for($j=2;$j<=$highestRow;$j++){//从第一行开始读取数据
            $str='';
            for($k='A';$k<=$highestColumn;$k++){            //从A列读取数据
                //这种方法简单，但有不妥，以'\\'合并为数组，再分割\\为字段值插入到数据库,实测在excel中，如果某单元格的值包含了\\导入的数据会为空
                $str.=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'\\';//读取单元格
            }
            //explode:函数把字符串分割为数组。


            $strs=explode("\\",$str);

            if($strs[0]!=""){
                D("Xs")->newXs($strs[0],$strs[1],$strs[2],$strs[3],"",$strs[4],$strs[5]);
            }
        

        }
        unlink($path); //删除excel文件
    }

    public function jsDaoru($path){
        M("Js")->where("1 and jsbh!='admin'")->delete();
        Vendor('PHPExcel.PHPExcel');
        Vendor('PHPExcel.PHPExcel.IOFactory');
        Vendor('PHPExcel.PHPExcel.Reader.Excel5');
        $objReader=\PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format
        $objPHPExcel=$objReader->load($path);//$file_url即Excel文件的路径
        $sheet=$objPHPExcel->getSheet(0);//获取第一个工作表
        $highestRow=$sheet->getHighestRow();//取得总行数
        $highestColumn=$sheet->getHighestColumn(); //取得总列数
//循环读取excel文件,读取一条,插入一条
        for($j=2;$j<=$highestRow;$j++){//从第一行开始读取数据
            $str='';
            for($k='A';$k<=$highestColumn;$k++){            //从A列读取数据
                //这种方法简单，但有不妥，以'\\'合并为数组，再分割\\为字段值插入到数据库,实测在excel中，如果某单元格的值包含了\\导入的数据会为空
                $str.=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'\\';//读取单元格
            }
            //explode:函数把字符串分割为数组。
            //$str=iconv('GBK','UTF-8',$str);
            $strs=explode("\\",$str);
 if($strs[0]!=""){
 
            D("Js")->newJs($strs[0],$strs[1],$strs[2],$strs[3],$strs[5],$strs[6],"",$strs[4]);
 }

        }
        unlink($path); //删除excel文件
    }

    public function jsDaochu(){
        Vendor('PHPExcel.PHPExcel');
        $data=D("Js")->getAll();
        $objPHPExcel=new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator('http://www.jb51.net')
            ->setLastModifiedBy('http://www.jb51.net')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Result file');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','教师编号')

            ->setCellValue('B1','姓名')
            ->setCellValue('C1','专业')
        ->setCellValue('D1','职称')
            ->setCellValue('E1','权限')
        ->setCellValue('F1','qq')
            ->setCellValue('G1','tel');
$objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $i=2;
        foreach($data as $k=>$v){
            
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i,$v['jsbh'])
                ->setCellValue('B'.$i,$v['xm'])
                ->setCellValue('C'.$i,$v['zy'])
                ->setCellValue('D'.$i,$v['zc'])
                ->setCellValue('E'.$i,$v['qx'])
                ->setCellValue('F'.$i,$v['qq'])
                ->setCellValue('G'.$i,$v['tel'])
                ;
            $i++;
        }

        $objPHPExcel->setActiveSheetIndex(0);
        $filename=iconv("UTF-8","GBK",'教师信息统计表').'_'.date('Y-m-dHis');

        /*
        *生成xlsx文件
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
        */

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');

    }

    public function xsDaochu(){
        Vendor('PHPExcel.PHPExcel');
        $data=D("Xs")->getAll();
        $objPHPExcel=new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator('http://www.jb51.net')
            ->setLastModifiedBy('http://www.jb51.net')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Result file');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','学号')

            ->setCellValue('B1','姓名')
            ->setCellValue('C1','班级')
            ->setCellValue('D1','专业')
            ->setCellValue('E1','教师编号')
            ->setCellValue('F1','教师姓名')
            ->setCellValue('G1','题目编号')
            ->setCellValue('H1','题目名称')
            ->setCellValue('I1','qq')
            ->setCellValue('J1','tel')
            ;
            $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
$objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $i=2;
        foreach($data as $k=>$v){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i,$v['xh'])
                ->setCellValue('B'.$i,$v['xm'])
                ->setCellValue('C'.$i,$v['bj'])
                ->setCellValue('D'.$i,$v['zy'])
                ->setCellValue('E'.$i,$v['jsbh'])
                ->setCellValue('F'.$i,$v['jsxm'])
                ->setCellValue('G'.$i,$v['tmbh'])
                ->setCellValue('H'.$i,$v['tmmc'])
                ->setCellValue('I'.$i,$v['qq'])
                ->setCellValue('J'.$i,$v['tel'])
                ;
            $i++;
        }

        $objPHPExcel->setActiveSheetIndex(0);
        $filename=iconv("UTF-8","GBK",'学生信息统计表').'_'.date('Y-m-dHis');

        /*
        *生成xlsx文件
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
        */

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');

    }

    public function tmDaochu(){
        Vendor('PHPExcel.PHPExcel');
        $data=D("Tm")->getAll();
        $objPHPExcel=new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator('http://www.jb51.net')
            ->setLastModifiedBy('http://www.jb51.net')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Result file');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','题目编号')
            ->setCellValue('B1','题目名称')
            ->setCellValue('C1','教师编号')
            ->setCellValue('D1','教师姓名')
            ->setCellValue('E1','开发技术')
            ->setCellValue('F1','题目描述');

        $i=2;
        foreach($data as $k=>$v){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i,$v['tmbh'])
                ->setCellValue('B'.$i,$v['tmmc'])
                ->setCellValue('C'.$i,$v['jsbh'])
                ->setCellValue('D'.$i,$v['jsxm'])
                ->setCellValue('E'.$i,$v['kfjs'])
                ->setCellValue('F'.$i,$v['tmms']);
            $i++;
        }

        $objPHPExcel->setActiveSheetIndex(0);
        $filename=iconv("UTF-8","GBK",'题目信息统计表').'_'.date('Y-m-dHis');

        /*
        *生成xlsx文件
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
        */

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');

    }

}