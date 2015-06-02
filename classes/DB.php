<?php 

# Conexão com o banco
abstract class DB{
	private $user;
	private $pass;
	private $host;
	private $db;
	public static $pdo;

	public function __construct(){
		require "database_config.php";
		
		$this->user = $user;
		$this->pass = $pass;
		$this->host = $host;
		$this->db = $db;

		try{
			static::$pdo = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}
}