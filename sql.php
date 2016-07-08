<?php
session_start();
error_reporting(1);
include('static.php');
$mysql = new MySQL("localhost","root","root","school");
$username = $_POST["username"];
$password = $_POST["password"];
$data = array("id","username","password");
$table = "user";
$where = array("username"=>$username);
$result = $mysql->mySelect($data,$table,$where);
if(isset($result)){
    $_SESSION["userid"] = $result[0]["id"];
    $_SESSION["username"] = $result[0]["username"];
}
else{
    echo "<script>alert('false')</script>";
}
if($_SESSION["userid"]>0){
    echo $_SESSION["username"];
}
else{
    echo "<form action='sql.php' method='post'>";
    echo "用户名：<input type='text' name='username'>";
    echo "<br>";
    echo "密码：<input type='text' name='password'>";
    echo "<br>";
    echo "<input type='submit' value='submit'>";
    echo "</form>";
}
?>