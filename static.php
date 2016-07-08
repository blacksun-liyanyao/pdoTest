<?php
class MySQL{
 private $host;//主机
 private $name;//用户名
 private $pass;//密码
 private $database;//数据库
 private $conn;//连接
 //用set get函数
 function __set($n,$v){
  $this->$n=$v;
 }
 function __get($n){
  return $this->$n;
 }
 //构造函数赋值
 function __construct($host,$name,$pass,$db){
  $this->host=$host;
  $this->name=$name;
  $this->pass=$pass;
  $this->database=$db;
  $this->conn=$this->getConn();
 }
 //得到链接
  function getConn(){
      try{
          $dsn='mysql:host='.$this->host.';'.'dbname='.$this->database;
          $username=$this->name;
          $passwd=$this->pass;
          $pdo=new PDO($dsn, $username, $passwd);
          $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
          $pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,'SET NAMES UTF8');
      }catch(PDOException $e){
          echo $e->getMessage();
      }
  return $pdo;
  }
 function mySelect($data="*",$table,$where=null){
     $data = join($data,",");
     $sql = "SELECT {$data} FROM {$table} ".self::parseWhere($where);
     $res = $this->conn->query($sql);
     $result=$res->fetchAll(constant("PDO::FETCH_ASSOC"));
     return $result;
 }
    function myInsert(array $data,$table){
        $keys = array_keys($data);
        $fieldsStr=join(',',$keys);
        $values="'".join("','",array_values($data))."'";
        $sql = "INSERT INTO {$table} ({$fieldsStr}) VALUES ({$values})";
        return $this->conn->exec($sql);
    }
    function myUpdate(array $data,$table,$where=null){
        $set = '';
        foreach($data as $key=>$value)
        {
            $value = self::check_input($value);
            $set .= $key."='".$value."',";
        }
        $sets=rtrim($set,',');
        $sql = "UPDATE {$table} SET {$sets} ".self::parseWhere($where);
        $res = $this->conn->exec($sql);
        return $res;
    }
    function myDelete($table,$where=null){
        $sql = "DELETE FROM {$table} ".self::parseWhere($where);
//        $res = $this->conn->exec($sql);
        return $sql;
    }
    public static function check_input($str)
    {
        if (empty($str)) return false;
        $str = htmlspecialchars($str);
        $str = str_replace( '/', "", $str);
        $str = str_replace("\\", "", $str);
        $str = str_replace("&gt", "", $str);
        $str = str_replace("&lt", "", $str);
        $str = str_replace("<SCRIPT>", "", $str);
        $str = str_replace("</SCRIPT>", "", $str);
        $str = str_replace("<script>", "", $str);
        $str = str_replace("</script>", "", $str);
        $str=str_replace("select","select",$str);
        $str=str_replace("join","join",$str);
        $str=str_replace("union","union",$str);
        $str=str_replace("where","where",$str);
        $str=str_replace("insert","insert",$str);
        $str=str_replace("delete","delete",$str);
        $str=str_replace("update","update",$str);
        $str=str_replace("like","like",$str);
        $str=str_replace("drop","drop",$str);
        $str=str_replace("create","create",$str);
        $str=str_replace("modify","modify",$str);
        $str=str_replace("rename","rename",$str);
        $str=str_replace("alter","alter",$str);
        $str=str_replace("cas","cast",$str);
        $str=str_replace("&","&",$str);
        $str=str_replace(">",">",$str);
        $str=str_replace("<","<",$str);
        $str=str_replace(" ",chr(32),$str);
        $str=str_replace(" ",chr(9),$str);
        $str=str_replace("    ",chr(9),$str);
        $str=str_replace("&",chr(34),$str);
        $str=str_replace("'",chr(39),$str);
        $str=str_replace("<br />",chr(13),$str);
        $str=str_replace("''","'",$str);
        $str=str_replace("css","'",$str);
        $str=str_replace("CSS","'",$str);
        return $str;
    }
    public static function parseWhere($where){
        $whereStr='';
        if(is_array($where)&&!empty($where)){
            foreach($where as $key=>$val){
                $val = self::check_input($val);
                $whereStr.=$key."='".$val."' and ";
            }
            $whereStr = rtrim($whereStr,' and ');
        }
        return empty($whereStr)?'':' WHERE '.$whereStr;
    }
    /**
     * 解析group by
     * @param unknown $group
     * @return string
     */
    public static function parseGroup($group){
        $groupStr='';
        if(is_array($group)){
            $groupStr.=' GROUP BY '.implode(',',$group);
        }elseif(is_string($group)&&!empty($group)){
            $groupStr.=' GROUP BY '.$group;
        }
        return empty($groupStr)?'':$groupStr;
    }
    /**
     * 对分组结果通过Having子句进行二次删选
     * @param unknown $having
     * @return string
     */
    public static function parseHaving($having){
        $havingStr='';
        if(is_string($having)&&!empty($having)){
            $havingStr.=' HAVING '.$having;
        }
        return $havingStr;
    }
}
?>