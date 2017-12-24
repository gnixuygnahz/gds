<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/4
 * Time: 22:46
 */


$zip = new ZipArchive;
var_dump($zip);
if ($zip -> open('test.zip',ZIPARCHIVE::OVERWRITE) === TRUE) {
    $zip->addFile('test.txt');
    var_dump($zip);
    $zip -> close();
    echo 'ok';
} else {
    echo 'failed';
}