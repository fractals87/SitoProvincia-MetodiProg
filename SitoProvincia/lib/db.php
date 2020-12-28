<?php 
class db{
    private $pdo; 

    private $database; 
    private $driver; 
    private $username; 
    private $password; 
    private $host; 
    private $port; 
    
    private $connected; 

    public $lastError;
    public $res;
       
    public function __construct($conf) { 
    
        //$this->conf = $conf;
    
        $this->database = $conf->get('database.database');
        $this->driver = $conf->get('database.driver'); 
        $this->username = $conf->get('database.username'); 
        $this->password = $conf->get('database.password'); 
        $this->host = $conf->get('database.host'); 
        $this->port = $conf->get('database.port'); 
        $this->connected = false;
    } 

    public function getDatabase(){ 
        return $this->database; 
    } 

    public function setDatabase($database){ 
        $this->database = $database; 
        return $this; 
    } 

    public function getDriver(){ 
        return $this->driver; 
    } 

    public function setDriver($driver){ 
        $this->driver = $driver; 
        return $this; 
    } 

    public function connect(){ 

        if($this->isConnected()) 
        	return $this->connected && $this->pdo !== null; 

        try{       
            $dsn = $this->getDSN(); 
            $this->pdo = new PDO($dsn, $this->username, $this->password); 
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);       
            $this->pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");               
            $this->connected = true; 

        }catch(PDOException $ex){ 
            $this->pdo = null; 
            $this->connected = false;
            $this->handleExceptions($ex);            
        } 

        return $this->isConnected(); 
    } 

    public function isConnected(){ 
        return $this->connected && $this->pdo !== null; 
    } 

    private function getDSN(){ 
        return $this->driver .  
                    ':host=' . $this->host .  
                    ( $this->port ? ';port=' . $this->port : '') .  
                    ';dbname=' . $this->database;  
    } 

    public function fetchAll($sql, array $params = array()){ 
        return $this->executeQuery($sql, $params)->fetchAll(PDO::FETCH_ASSOC); 
    } 

    public function fetch($sql, array $params = array()){ 
        return $this->executeQuery($sql, $params)->fetch(PDO::FETCH_ASSOC); 
    }

    public function executeQuery($sql,array $params = array()){ 
        try{
            $smt = $this->pdo->prepare($sql); 
            if($params){ 
                foreach($params as $key => $value){ 
                    if(is_numeric($key)){
                        $smt->bindValue($key+1, $value); 
                    }else{
                        $smt->bindValue (":$key", $value); 
                    }
                } 
            } 

            $smt->execute();
            return $smt; 
        }catch(PDOException $ex){
            $this->handleExceptions($ex);
        }
    }

    public function executeUpdate($sql, array $params = array()){ 
        $result = 0; 
        try{
            $smt = $this->pdo->prepare($sql); 
            if($params){ 				
                foreach($params as $key => $value){ 
                    if(is_numeric($key)) 
                        $smt->bindValue($key+1, $value); 
                    else 
                        $smt->bindValue (":$key", $value); 
				}
            } 
            $smt->execute(); 
            $result = $smt->rowCount(); 
            return $result;
        }catch(PDOException $ex){
            $this->handleExceptions($ex);			
        }    
    }

    public function delete($tableName,array $params = array()){ 
        try{
			$criteria = array(); 
			foreach(array_keys($params) as $columnName) 
				$criteria[] = $columnName.' = ?'; 
			$sql = 'DELETE FROM '.$tableName.' WHERE '.implode(' AND ',$criteria); 
			return $this->executeUpdate($sql, array_values($params)); 
		}catch(PDOException $ex){
            $this->handleExceptions($ex);			
        }  
    }
	
    public function getLastError(){ 
        return $this->lastError; 
    } 

    protected function handleExceptions(PDOException $ex){ 
        $this->lastError = $ex->getMessage();  
    } 
}

?>
