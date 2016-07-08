<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/18
 * Time: 14:59
 */
include('static.php');
$mysql = new MySQL("localhost","root","root","school");
if(strlen($_POST["username"])<6){
    echo "用户名长度必须大于6个字符";
}
else{
    $data = $_POST;
    $table = "user";
    $result = $mysql->myInsert($data,$table);
    if($result){
        echo "success";
    }
    else{
        echo "false";
    }
}