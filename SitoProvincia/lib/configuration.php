<?php 
/*
 * Class per leggere il file e caricare il file di configurazione 
 */
class configuration{ 
    const PATH_DELIMITER = '.'; 

    private $configuration = array(); 
    private $resource;
     
    public function __construct($resource){
        $this->resource = $resource; 
        $this->_parse(); 
    } 
     
    private function _parse(){ 
        if(is_readable($this->resource)===false) 
            die("Impossibile aprire il file di configurazione ".$this->resource); 
        $this->configuration = parse_ini_file($this->resource,true); 
    } 
     
    public function get($path, $default = null){ 
        $r = $this->search($path); 
        if($r['_found']===true)
            return $r['_value'];
        
        return $default; 
    } 
     
    public function set($path,$value){ 
        $r = $this->search($path,true); 
        $r['_value'] = $value; 

        return $this; 
    } 
     

    private function search($path,$create = false){ 
        $rit = array('_found' => false, '_value' => null); 
        $keys = explode(self::PATH_DELIMITER,$path); 

        if(!is_array($this->configuration)){ 
            if($this->configuration!==null) 
                $this->configuration = array($this->configuration); 
            else 
                $this->configuration = array(); 
        } 
         
        $tmp =& $this->configuration; 
        $lastKeyI = count($keys)-1; 
         
        foreach($keys as $i => $key){ 
            if(!is_array($tmp) || !array_key_exists($key, $tmp)){ 
                if(!$create) 
                    break; 
                 
                $tmp[$key] = array(); 
                $tmp =& $tmp[$key]; 
                 
            }else if(array_key_exists($key, $tmp)){ 
                if($i == $lastKeyI)
                    $rit['_found'] = true; 
                 
                $tmp =& $tmp[$key]; 
            } 
             
            $rit['_value'] =& $tmp; 
        } 
         
        if($rit['_found']===false && $create === false) 
            $rit['_value'] = null; 
         
        return $rit; 
    } 
} 
