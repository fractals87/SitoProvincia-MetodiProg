<?php
class news{
	public $id;
	public $title;
	public $text;

	private $db;
	private $lastError;

	public function setConnection($db){
		$this->db = $db;
	}

	public function getLastError(){
		return $this->lastError;
	}

    public function load($id){

        $rk = $this->db->fetch("SELECT * FROM news WHERE id = :id",array('id' => $id ));

        $this->id = $rk['id'];
        $this->title = $rk['title'];
        $this->text = $rk['text'];
		
    }

	public function getNews(){
		$sql = "SELECT * FROM news";
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
	
	public function getIndexNews(){
		$sql = "SELECT id, title, SUBSTRING(text,1,50) as text FROM news ORDER BY id desc LIMIT 6";
		$res = $this->db->fetchAll($sql, $params = array());
		if($this->db->getlastError()!=""){
			$this->lastError = $this->db->lastError;
			return false;
		}
		else{
			return $res;
		}
	}

	public function insertNews(){
		$sql = "INSERT INTO news (id, title, text) VALUES (:id, :title, :text)";
		$parameter = array("id" => $this->id, "title" => $this->title, "text" => $this->text);
		$this->db->executeUpdate($sql,$parameter);

		if($this->db->getLastError()!=""){
			$this->lastError = $this->db->getLastError();
			return false;
		}
		else {
			return true;
		}
	}
	
		public function updateNews(){
        $sql ="UPDATE news SET ";
    	    $sql.="title = :title,";
        	$sql.="text = :text ";
        $sql.="WHERE id = :id";

        $parameter = array('id' => $this->id,
                           'title' => $this->title,
                           'text' => $this->text);

        $this->db->executeUpdate($sql,$parameter);
		if($this->db->getLastError()!=""){
            return false;
        }else{
            return true;
        }
    }

	//rimozione prodotto
	public function deleteNews(){
		$this->db->delete("news", array("id" => $this->id));
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
