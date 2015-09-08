<?php
class models_base {
	
	private static $db ;
	private static $hostname ;
	private static $username  ;
	private static $passwd ;
	private static $dsn;
	private static $pdo;

	public $table;

	public function __construct(){
//		$this->dsn = " mysql:host=$this->hostname;dbname=$this->db";
//		$this->pdo = new PDO($this->dsn, $this->username, $this->passwd);
		
		$configPath = DS.DIRECTORY_SEPARATOR.'boot'.DIRECTORY_SEPARATOR.'config.php';
		$config = include $configPath; //
		
		self::$hostname = $config['host'];
		self::$db = $config['database'];
		self::$username = $config['user'];
		self::$passwd = $config['password'];
		
	}
	
	/**
	 * pdo single method
	 */
	public static function getPDO(){
		if(empty(self::$pdo)){
			self::$dsn = "mysql:host=".self::$hostname.";dbname=".self::$db;
			
			self::$pdo = new PDO(self::$dsn, self::$username, self::$passwd);
		}
		self::$pdo->query('set names utf8');
		self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		return self::$pdo;
	}
	
	/**
	 *  set  table name
	 * @param string $tablename
	 * @return class model_base
	 */
	public function table($tablename){
	//	$table = new models_base();
		$this->table = $tablename;
		return $this;
	}
	
	/**
	 *@param string $sql 
	 *@return unkown_type
	 */
	 public function query($sql) {
		return self::getPDO()->query($sql);
	 }
	/**
	 *  fetch  all  data 
	 * @params array $params , array('cols'=>array('id','name'),'mode'=>'','where'=>array('id'=>'','name'=>''),'order'=>array('id asc','pid desc'));
	 * cols is the search columns，mode is the fetch method
	 * mode = PDO::FETCH_ASSOC  PDO::FETCH_BOTH  ....see in pdo fetch_style 
	 * In fact, PDO::FETCH_ASSOC is number
	 * @return array
	 */
	public function fetchAll(array $params = NULL){
		$sql = "select * from $this->table";
		$where = " where 1 ";
		
		// one 
		if(!empty($params)){
			$keys_array = array_keys($params);
			$array_value = array('cols','mode','where','order');
		//	print_r($keys_array);
			foreach($keys_array as $key_y){
				if(!in_array($key_y, $array_value)){
					exit("fetchAll params are not right！");
				}
			}
		}
		
		//select id,name....
		if(!empty($params['cols'])){
			$cols = implode(',', $params['cols']);
			$sql = "select $cols from $this->table ";
		}
		//select   where id=1 and name='wq'
	//	print_r($params);
		if(!empty($params['where'])){
			foreach($params['where'] as $key => $value){
				$where .= " and $key = '{$value}' "; 
				
			}
		}
		
		$sql .= $where;
		
		if(!empty($params['order'])){
			$order = " order by ";
			foreach($params['order'] as $val){
				$order .= " $val ";
			}
			$sql .= $order;
		}
		if(!empty($params['mode'])){
			$mode = $params['mode'];
		}else{
			$mode = PDO::FETCH_BOTH;
		}
		
		$stm = self::getPDO()->prepare($sql);
		$stm->execute();
		return $stm->fetchAll($mode);
	}
	
	/**
	 *  fetch  one  data 
	 */
	public function fetch(array $params = NULL){
		$sql = "select * from $this->table";
		$where = " where 1 ";
		
	// one 
		if(!empty($params)){
			$keys_array = array_keys($params);
			$array_value = array('cols','mode','where','order');
			foreach($keys_array as $key_y){
				if(!in_array($key_y, $array_value)){
					exit("fetch params are not right！");
				}
			}
		}
		
		if(!empty($params['cols'])){
			$cols = implode(',', $params['cols']);
			$sql = "select $cols from $this->table ";
		}
		
		if(!empty($params['where'])){
			foreach($params['where'] as $key => $value){
				$where .= " and $key = '{$value}' "; 
			}
		}
		$sql .= $where;
		
		if(!empty($params['order'])){
			$order = " order by ";
			foreach($params['order'] as $val){
				$order .= " $val ";
			}
			$sql .= $order;
		}
		if(!empty($params['mode'])){
			$mode = $params['mode'];
		}else{
			$mode = PDO::FETCH_BOTH;
		}
		$stm = self::getPDO()->prepare($sql);
		$stm->execute();
		return $stm->fetch($mode);
	}
	
	/**
	 * add  one  data   insert into users(name,pass) values ('a','a')
	 * @params array $params in array, for examplearray('id'=>1,'name'=>'wq');
	 * @return int  return 1 if it is ok1
	 */
	public function insert(array $params){
		$keys = $vals = '';
		foreach($params as $key => $val){
			$keys .= $key.',';
			$vals .= self::getPDO()->quote($val).',';
		}
		$keys = trim($keys,',');
		$vals = trim($vals,',');
		
		$sql = "INSERT INTO {$this->table} ({$keys}) values ({$vals})";

	//	exit ($sql);
		$count = self::getPDO()->exec($sql); //Back影响的行数
		return $this->getOne("SELECT LAST_INSERT_ID()");
	}
	
	/**
	 * batch add  data  
	 * @params array $params data set set
	 * $params array(array('name'=>'wq'),array('name'=>'wq')
	 */
	public function insertAll(array $params){
		try{
			//self::getPDO()->beginTransaction();
			foreach($params as $param){
				$ret = $this->insert($param);
				if($ret == false) {
					throw Exception('insert Failed');
				}
			}
			//self::getPDO()->commit();
		}catch(Exception $e){
		//	self::getPDO()->rollBack();
			throw $e;
		}
		return true;
	}
	
	/**
	 * delete
	 * @params array $paramsdelete condition where array('id'=>1,'name'=>'wq')
	 * @return boolean
	 */
	public function delete(array $params){
		$where = ' where 1 ';
		foreach($params as $key => $val){
			$where .= " and {$key}='{$val}' ";
		}
		$sql = "DELETE FROM {$this->table} {$where}";
		$stm = self::getPDO()->prepare($sql);
		$b = $stm->execute();
		return $b;
		
	}
	
	/**
	 * update  data 
	 * @params array $where array('id'=>1,'name'=>'wq')
	 * @params array $params array('name'=>'wqq')
	 * @return boolean
	 */
	public function update(array $where ,array $params){
		$sql = "update {$this->table} ";
		$set = " set ";
		foreach($params as $key => $val){
			$set .= "  $key = '{$val}' ,";
		}
		$set = trim($set,',');
		$sql .= $set;
		
		$w = 'where 1=1';
		foreach($where as $key => $val){
			$w .= " and $key = '{$val}' ";
		}
		$sql .= $w;
//		echo $sql;exit;
		$stm = self::getPDO()->prepare($sql);
		$b = $stm->execute();
		return $stm->rowCount();
	}
	
	// table search
	
	/**
	 *  fetch  one  data 
	 * @param string $sql  sql strings
	 * @param int $mode
	 * @return array result
	 */
	public function getRow($sql,$mode=PDO::FETCH_ASSOC){
		$result = array();
		try{
			self::getPDO()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stm = self::getPDO()->prepare($sql);
			$stm->execute();
			$result = $stm->fetch($mode);
			
		//	print_r($result);exit;
			return $result;
		}catch (PDOException $err){
			
			$message = date('Y-m-d H:i:s',time());
			$message .= "\tCode: ".strval($err->getCode());
			$message .= "\t Message:{$err->getMessage()} \n";
			$ds = DIRECTORY_SEPARATOR;
			$logpath = DS."{$ds}log{$ds}error_log.txt";
			if(file_exists($logpath)) {
				error_log($message,3,$logpath);
				if(DEBUG){
					throw new Exception($err->getMessage());
				}
			}
		}
	}

	public function getOne($sql,$colunm=0) {
		$stm = self::getPDO()->prepare($sql);
		$stm->execute();
		return $stm->fetchColumn($colunm);
	}
	
	/**
	 *  fetch All data 
	 * @param string $sql  sql strings
	 * @param int $mode
	 * @return array resultset
	 */
	public function getAll($sql,$mode=PDO::FETCH_ASSOC){
		try{
			$stm = self::getPDO()->prepare($sql);
			$stm->execute();
			$result = $stm->fetchAll($mode);
			return $result;
		}catch (PDOException $err){
			
			$message = date('Y-m-d H:i:s',time());
			$message .= "\t Code: ".strval($err->getCode());
			$message .= "\t Message:{$err->getMessage()} \n";
			$ds = DIRECTORY_SEPARATOR;
			$logpath = DS."{$ds}log{$ds}error_log.txt";
			if(file_exists($logpath)) {
				error_log($message,3,$logpath);
				if(DEBUG){
					throw new Exception($err->getMessage());
				}
			}
		}
	}

	/**
	 * 
	 */
	public function startTransaction() {
		return self::getPDO()->beginTransaction();
	}

	/**
	 * thigns submit
	 */
	public function commit() {
		return self::getPDO()->commit();
	}

	/**
	 * thigns  rollback
	 */
	 public function rollback() {
		return self::getPDO()->rollBack();
	 }

	 /**
	  *Back last add ID
	  *
	  */
	  public function get_last_id() {
		 $sql = "select last_insert_id()";
		 return $this->getOne($sql);
	  }
}