<?php


class CvsQueryBuilder
{
protected $dataBase;
protected $queryResult;
protected $dbSelector;
public function __construct()
{
$this->dataBase=[];
$this->queryResult=[];
$this->dbSelector;
}

    /**
     * Add a database
     * @param $dbName
     * @return $this
     */
    public function addDatabase($dbName){
        $this->dataBase[$dbName]=[];
    return $this;
}

    /**
     * Add a new table to database
     * @param $tableName
     * @param $tableData
     * @return $this
     */
    public function addNewTable($tableName, $tableData){
        $this->dataBase[$this->dbSelector][$tableName]=$tableData;
    return $this;
}

    /**
     * Specify which database to select
     * @param $dbName
     * @return $this
     */
    public function db($dbName){
        $this->dbSelector=$dbName;
    return $this;
}

    /**
     * Select all data from a table
     * @param $tableName
     * @param array $selectedTableData
     * @return $this
     */
    public function selectAll($tableName, $selectedTableData=[]){
        $temp =&$this->dataBase[$this->dbSelector][$tableName];
        $ret = [];
        $m=count($selectedTableData);
        if ($m) {
            for ($i = 0; $i < count($temp); $i++) {
                for ($x = 0; $x < $m; $x++)
                $ret[$i][$selectedTableData[$x]] = $temp[$i][$selectedTableData[$x]];
            }
         }
        else
        $ret = $this->dataBase[$this->dbSelector][$tableName];
        $this->queryResult=$ret;
        return $this;
}

    /**
     * Select Data from a table by a specific key
     * @param $tableName
     * @param $selectBy
     * @param array $selectValue
     * @return $this
     */
    public function selectBy($tableName, $selectBy, array $selectValue){
        $this->queryResult=[];
        $temp=$this->groupBy($tableName,$selectBy);
            for($i=0;$i<count($selectValue);$i++) {
                if(isset($selectValue[$i]) && $selectValue[$i]!=='' && isset($temp[$selectValue[$i]]))
                     $this->queryResult[$i] = $temp[$selectValue[$i]];
                else
                    $this->queryResult[$i] = [];
    }

        return $this;
}

    /**
     * This is used to group table records according the a specific key, to allow faster searching of records
     * @param $tableName
     * @param $key
     * @return array
     */
    protected function groupBy($tableName, $key){
        $ret=[];
        for($i=0;$i<count($this->dataBase[$this->dbSelector][$tableName]);$i++){
            $inDx=$this->dataBase[$this->dbSelector][$tableName][$i][$key];
            if(!isset($ret[$inDx]))
                $ret[$inDx]=[];
            array_push($ret[$inDx],$this->dataBase[$this->dbSelector][$tableName][$i]);
    }
        return $ret;
}

    /**
     * Returns the query result in an array format
     * @return array
     */
    public function getQueryResult(){
        return $this->queryResult;
    }




}
?>