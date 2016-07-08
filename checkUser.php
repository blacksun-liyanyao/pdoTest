<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/18
 * Time: 14:26
 */
include('static.php');
$mysql = new MySQL("localhost","root","root","school");
$username = $_GET["username"];
if(strlen($username)<6){
    echo '{"success":"false","msg":"用户名长度不能小于6"}';
}
else{
    $data = array("id","username","password");
    $table = "user";
    $where = array("username"=>$username);
    $result = $mysql->mySelect($data,$table,$where);
    if(!empty($result[0]["id"])){
        echo '{"success":"false","msg":"用户名不可以使用"}';
    }
    else{
        echo '{"success":"true","msg":"用户名可以使用"}';
    }
}