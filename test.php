<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/18
 * Time: 14:49
 */
include("static.php");
$mysql = new MySQL("localhost","root","root","school");
$username = 'lyy';
$data = array("username","password");
$table = "user";
$where = array("username"=>$username);
$result = $mysql->mySelect($data,$table,$where);
echo $result;