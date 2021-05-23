class Database{
    private $severName= "localhost";
    private $userName ="root";
    private $password = "";
    private $dbName ="blog";

    private $mysqli = "";
    private $result =array();
    private $conn = false;

    public function __construct(){
        if(!($this->conn)){
            $this->mysqli = new mysqli($this->severName, $this->userName, $this->password, $this->dbName);
            $this->conn = true;
            if($this->mysqli->connect_error){
                array_push($this->result, $this->connect_error);
                return false;
            }
        }else {
            return true;
        }
    }
    //count total rows
    public function getRowsNumber($table, $join=null, $where=null, $order=null){
        if($this->tableExists($table)){
            $sql = "SELECT * FROM $table ";

            if($join != null){
                $sql .= " JOIN $join ";
            }
            if($where != null){
                $sql .= " WHERE $where ";
            }
            if($order != null){
                $sql .= " ORDER BY $order ";
            }
            $result = $this->mysqli->query($sql);
            $numRows = $result->num_rows;
            if($numRows > 0){
                while($row = $result->fetch_assoc()) 
                { 
                $data[] = $row; //incrementing by one each time 
                } 
                $i=0;
                foreach($data as $value){
                    $i++;
                }
                $this->result = $i;
            }else {
                array_push($result, $this->mysqli->error);
                return false;
            }
        }else{
            return false;
        }
    }
  // database table check function
    public function tableExists($table){
        $sql = " SHOW TABLES FROM  $this->dbName LIKE '$table' "; // sql quarry
        $tableInDb = $this->mysqli->query($sql);
        if($tableInDb){
            if($tableInDb->num_rows == 1){ // if have one row in database  table 
               return true;
            }else{
                array_push($this->result, $table. "dose not exists in this database");
            }
        } 
    }
    
    // getResult method
    public function getResult(){
        $val = $this->result; // result is a array value
        $this->result = array();  //  result array is clean now
        return $val ;  // result  value send as a $val variable
    }
}
