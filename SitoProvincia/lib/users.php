<?php

class users{
    public $id;
    public $username;
    public $password;
    public $session;
    
    private $db;
    private $lastError;

    public function setConnection($db){
        $this->db = $db;
    }

    public function load($id){

        $rk = $this->db->fetch("SELECT * FROM users WHERE id = :id",array('id' => $id ));

        $this->id = $rk['id'];
        $this->username = $rk['username'];
        $this->password = $rk['password'];
        $this->session = $rk['session'];
    }
	
	public function loadByUser($username){

        $rk = $this->db->fetch("SELECT * FROM users WHERE username = :username",array('username' => $username ));
        $this->id = $rk['id'];
        $this->username = $rk['username'];
        $this->password = $rk['password'];
        $this->session = $rk['session'];
    }

    public function getLastError(){
        return $this->lastError;
    }

    public function CheckLogin($username,$password){
        $this->loadByUser($username);
        if($this->id!="" && $this->password == sha1($password)){
            //APRO SESSIONE
            session_start();

            $this->CreateSession();
            $this->Update();

       	    header('Location: manage.php');
        }else{
            $this->lastError = "User o password non corretti";
			return false;
        }
    }
	
    public function CreateSession(){
		$caratteri	= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $len		= strlen($caratteri);
        $idsession	= '';
        mt_srand(10000000*(double)microtime());
        for ($i = 0; $i < 20; $i++)
               $idsession .= $caratteri[mt_rand(0,$len - 1)];

   	   $_SESSION['idsession']=$idsession;
   	   $this->session = $idsession;
    }

    public function CheckAutetication(){
        session_start();
        if(!isset($_SESSION['idsession']) || $_SESSION['idsession']==""){
			$this->lastError = "Non autenticato";
			return false;
		}
        $rk=$this->db->fetch("SELECT * FROM users WHERE session = :session ",array('session' => $_SESSION['idsession']));
        if($rk['id']==""){
			$this->lastError = "Sessione non valida";
			return false;
		}
        $this->load($rk['idutente']);
		return true;
    }
	
	public function Update(){
        $sql ="UPDATE users SET ";
    	    $sql.="username = :username,";
        	$sql.="password = :password,";
        	$sql.="session = :session ";
        $sql.="WHERE id = :id";

        $parameter = array('id' => $this->id,
                           'username' => $this->username,
                           'password' => $this->password,
                           'session' => $this->session);

        $this->db->executeUpdate($sql,$parameter);
		if($this->db->getLastError()!=""){
            return false;
        }else{
            return true;
        }
    }
}
?>
