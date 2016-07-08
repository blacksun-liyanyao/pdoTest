<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/18
 * Time: 17:14
 */
$file = "/我是一个文件.txt";

$filename = basename($file);

header("Content-type: application/octet-stream");

//处理中文文件名
$ua = $_SERVER["HTTP_USER_AGENT"];
$encoded_filename = rawurlencode($filename);
if (preg_match("/MSIE/", $ua)) {
    header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
} else if (preg_match("/Firefox/", $ua)) {
    header("Content-Disposition: attachment; filename*=\"utf8''" . $filename . '"');
} else {
    header('Content-Disposition: attachment; filename="' . $filename . '"');
}

//让Xsendfile发送文件
header("X-Sendfile: $file");