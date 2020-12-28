<?php
class gallery{
	public $id;
	public $url;
	public $title;

	private $db;
	private $lastError;

	public function setConnection($db){
		$this->db = $db;
	}

	public function getLastError(){
		return $this->lastError;
	}

	public function getGallery(){
		$sql = "SELECT * FROM gallery";
		$res = $this->db->fetchAll($sql, $params = array());
		if($this->db->getlastError()!=""){
			$this->lastError = $this->db->lastError;
			return false;
		}
		else{
			return $res;
		}
	}

	public function insertGallery(){
		$sql = "INSERT INTO gallery (id, url, title) VALUES (:id, :url, :title)";
		$parameter = array("id" => $this->id, "url" => $this->url, "title" => $this->title);
		$this->db->executeUpdate($sql,$parameter);

		if($this->db->getLastError()!=""){
			$this->lastError = $this->db->getLastError();
			return false;
		}
		else {
			return true;
		}
	}

	//rimozione prodotto
	public function deleteGallery(){
		$this->db->delete("gallery", array("id" => $this->id));
		if($this->db->getLastError()!=""){
			$this->lastError = $this->db->lastError;
			return false;
		}
		else 
		{
			return true;
		}
	}
}
?>
