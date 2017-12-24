<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/4
 * Time: 20:10
 */

function addFileToZip($path,$zip){

    $handler=opendir($path); //打开当前文件夹由$path指定。

    while(($filename=readdir($handler))!==false){


            if ($filename != "." && $filename != ".." && $filename != null) {//文件夹文件名字为'.'和‘..’，不要对他们进行操作
                if (is_dir($path . "/" . $filename)) {// 如果读取的某个对象是文件夹，则递归

                    addFileToZip($path . "/" . $filename, $zip);
                } else { //将文件加入zip对象

                    $zip->addFile($path . "/" . $filename);
                }
            }

	}
    closedir($path);
}