<?php
class database{
    private $host;
    private $user;
    private $pass;
    private $dbname;
    protected $conn;
    function __construct($host, $user, $pass, $db){
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $db;

        $this->conn = new mysqli($this->host,$this->user,$this->pass,$this->dbname);

        if($this->conn->connect_error){
            echo "Connecting to Database Unsuccessful <br>ERROR : ".$this->conn->connect_error;
            die();
        }
    }

    public function insert($table, $data){
        $col = implode(",",array_keys($data));
        $val = implode("','",$data);

        $this->conn->query("INSERT INTO $table($col)VALUES('$val')");
    }

    public function delete($table,$condition=array()){
        if(count($condition)>0){
            $col = implode(",",array_keys($condition));
            $val = implode("','",$condition);
            $this->conn->query("DELETE FROM $table WHERE $col='$val'");
        }else{
            $this->conn->query("DELETE FROM $table");
        }
    }

    public function update($table,$data,$where){
        $query="";
        $i = 0;
        foreach($data as $key=>$val){
            if(count($data)-1==$i){
                $query .= "$key='$val'";
            }else{
                $query .= "$key='$val', ";
            }
            $i++;
        }
        $this->conn->query("UPDATE $table SET $query WHERE $where");
    }

    public function Qshow($table,$col="*", $where="",$order="",$limit="",){
        $query = "SELECT $col FROM $table";
        if($where!=""){
            $query.= " WHERE $where";
        }
        if($order!=""){
            $query.= " ORDER BY $order";
        }
        if($limit!=""){
            $query.= " LIMIT $limit";
        }
        // echo $query;
        $result = $this->conn->query($query);
        if($result->num_rows > 0){
            $array = $result->fetch_all(MYSQLI_ASSOC);
        }
        return $array;
    }

    public function show($table){
        $query = $this->conn->query("SELECT * FROM $table");
        if($query->num_rows > 0){
            $array = $query->fetch_all(MYSQLI_ASSOC);
        }
        return $array;
    }

    public function dbug($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

}

// $obj = new database("localhost","root","","phpoops");

// $obj->insert("users",["name"=>"Aashish","age"=>23,"gender"=>"Male","email"=>"ashunayakme@gmail.com","password"=>"123456789Aashish"]);
// $obj->delete("users",["age"=>21]);
// $obj->update("users",["age"=>20,"name"=>"Akhil"],"id=17");
// $data = $obj->show("users");
// $data = $obj->Qshow("users","name,age,gender", "", "name", 5);

// $obj->dbug($data);
?>