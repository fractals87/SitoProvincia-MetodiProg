<?php
class dati{
	public $id;
	public $aggregatore;
	public $dato;
	public $valore;

	private $db;
	private $lastError;

	public function setConnection($db){
		$this->db = $db;
	}

	public function getLastError(){
		return $this->lastError;
	}

    public function load($id){

        $rk = $this->db->fetch("SELECT * FROM dati WHERE id = :id",array('id' => $id ));

        $this->id = $rk['id'];
        $this->aggregatore = $rk['aggregatore'];
        $this->dato = $rk['dato'];
		$this->valore = $rk['valore'];
		
    }

	public function getDati(){
		$sql = "SELECT * FROM dati";
		$res = $this->db->fetchAll($sql, $params = array());
		if($this->db->getlastError()!=""){
			$this->lastError = $this->db->lastError;
			return false;
		}
		else
		{
			return $res;
		}
	}

	public function insertDati(){
		$sql = "INSERT INTO dati (id, aggregatore, dato, valore) VALUES (:id, :aggregatore, :dato, :valore)";
		$parameter = array("id" => $this->id, "aggregatore" => $this->aggregatore, "dato" => $this->dato, "valore" => $this->valore);
		$this->db->executeUpdate($sql,$parameter);

		if($this->db->getLastError()!=""){
			$this->lastError = $this->db->getLastError();
			return false;
		}
		else {
			return true;
		}
	}
	
		public function updateDati(){
        $sql ="UPDATE dati SET ";
    	    $sql.="aggregatore = :aggregatore,";
        	$sql.="dato = :dato, ";
			$sql.="valore = :valore ";
        $sql.="WHERE id = :id";

        $parameter = array('id' => $this->id,
                           'aggregatore' => $this->aggregatore,
                           'dato' => $this->dato,
						   'valore' => $this->valore);

        $this->db->executeUpdate($sql,$parameter);
		if($this->db->getLastError()!=""){
            return false;
        }else{
            return true;
        }
    }

	public function deleteDati(){
		$this->db->delete("dati", array("id" => $this->id));
		if($this->db->getLastError()!=""){
			$this->lastError = $this->db->lastError;
			return false;
		}
		else {
			return true;
		}
	}
}
?>