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

namespace Home\Api;
use Think\Controller;

class FileApi
{

    function addFileToZip($path, $zip)
    {

        $handler = opendir($path); //打开当前文件夹由$path指定。

        while (($filename = readdir($handler)) !== false) {


            if ($filename != "." && $filename != ".." && $filename != null) {//文件夹文件名字为'.'和‘..’，不要对他们进行操作
                if (is_dir($path . "/" . $filename)) {// 如果读取的某个对象是文件夹，则递归

                    $this->addFileToZip($path . "/" . $filename, $zip);
                } else { //将文件加入zip对象


                    $zip->addFile($path . $filename);

                }
            }

        }
        closedir($path);
    }

    function addFileToZipByXh($path, $zip, $xh)
    {

        $handler = opendir($path); //打开当前文件夹由$path指定。

        while (($filename = readdir($handler)) !== false) {


            if ($filename != "." && $filename != ".." && $filename != null) {//文件夹文件名字为'.'和‘..’，不要对他们进行操作
                if (is_dir($path . "/" . $filename)) {// 如果读取的某个对象是文件夹，则递归

                    if (in_array($filename, $xh)) {
                        dump($path . "/" . $filename);
                        $this->addFileToZipByXh($path . "/" . $filename, $zip, $xh);
                    }
                } else { //将文件加入zip对象


                    dump($path . "/" . $filename);
                    $zip->addFile($path . "/" . $filename);

                }
            }

        }
        closedir($path);
    }

    public function getFileByStuId($id)
    {

        $file_name = $id . ".zip";

        $file_dir = "./Public/cache/";


        if (file_exists($file_dir . $file_name)) {
            unlink($file_dir . $file_name);
        }

        $zip = new \ZipArchive();
        if ($zip->open($file_dir . $file_name, \ZIPARCHIVE::CREATE) === TRUE) {

            $this->addFileToZip("./Public/file/" . $id . "/", $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法

            $zip->close(); //关闭处理的zip文件
        }


        if (!file_exists($file_dir . $file_name)) { //检查文件是否存在

            echo "文件找不到";

            exit;

        } else {

            $file = fopen($file_dir . $file_name, "r"); // 打开文件

            // 输入文件标签

            Header("Content-type: application/octet-stream");

            Header("Accept-Ranges: bytes");

            Header("Accept-Length: " . filesize($file_dir . $file_name));

            Header("Content-Disposition: attachment; filename=" . $file_name);

            // 输出文件内容

            echo fread($file, filesize($file_dir . $file_name));

            fclose($file);

            exit;
        }
    }

    function addFileToZipByJs($path,$zip,$stuid){

        $handler = opendir($path); //打开当前文件夹由$path指定。

        while (($filename = readdir($handler)) !== false) {

            if ($filename != "." && $filename != ".." && $filename != null) {//文件夹文件名字为'.'和‘..’，不要对他们进行操作



                    $zip->addFile($path  . $filename,$stuid."/".$filename);


            }

        }
        closedir($path);
    }

    public function getAllFileByJs($id)
    {

        $stu = M("Xs")->field("xh,xy,zy,bj,xm")->where("jsbh = '$id'")->select();
        $file_name = $id . ".zip";
        $file_dir = "./Public/cache/";

        if (file_exists($file_dir . $file_name)) {
            unlink($file_dir . $file_name);
        }

        $zip = new \ZipArchive();

        if ($zip->open($file_dir . $file_name, \ZIPARCHIVE::CREATE) === TRUE) {
            foreach($stu as $item) {
                //dump(iconv("UTF-8","GBK","./Public/file/" . $item['xy'] . "/" . $item['zy'] . "/" . $item['bj'] . "/" . $item['xh'] ));
                if (is_dir(iconv("UTF-8","GBK","./Public/file/" . $item['xy'] . "/" . $item['zy'] . "/" . $item['bj'] . "/" . $item['xh'] ))){

                $this->addFileToZipByJs(iconv("UTF-8","GBK","./Public/file/" . $item['xy'] . "/" . $item['zy'] . "/" . $item['bj'] . "/" . $item['xh']."/" ),$zip,$item['xh'].$item['xm']);
            }
            }

            $zip->close(); //关闭处理的zip文件
        }


        if (!file_exists($file_dir . $file_name)) { //检查文件是否存在

            echo "文件找不到,学生未上传作业";

            exit;

        } else {

            $file = fopen($file_dir . $file_name, "r"); // 打开文件

            // 输入文件标签

            Header("Content-type: application/octet-stream");

            Header("Accept-Ranges: bytes");

            Header("Accept-Length: " . filesize($file_dir . $file_name));

            Header("Content-Disposition: attachment; filename=" . $file_name);

            // 输出文件内容

            echo fread($file, filesize($file_dir . $file_name));

            fclose($file);

            exit;
        }

    }

    public function getDb($file_name){
        $file_name= iconv("UTF-8","GBK",$file_name);
        $file_dir ="./Public/file/common/";
        $file = fopen($file_dir . $file_name, "r"); // 打开文件

        // 输入文件标签

        Header("Content-type: application/octet-stream");

        Header("Accept-Ranges: bytes");

        Header("Accept-Length: " . filesize($file_dir . $file_name));

        Header("Content-Disposition: attachment; filename=" . $file_name);

        // 输出文件内容

        echo fread($file, filesize($file_dir . $file_name));

        fclose($file);

        exit;
    }
}