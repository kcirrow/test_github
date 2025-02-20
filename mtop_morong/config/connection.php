<?php

class Dbh
{

	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	private $dbname = "bplomorongrizal_mtop";
	private $charset = "utf8mb4";

	public function connect()
	{
		global $pdo;
		try {
			$dsn = "mysql:host=" . $this->servername . ";dbname=" . $this->dbname . ";charset=" . $this->charset;
			$pdo = new PDO($dsn, $this->username, $this->password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		} catch (PDOException $e) {
			echo "Error Connection : " . $e->getMessage();
		}
	}

	public function conn()
	{
		global $pdo;
		try {
			$dsn = "mysql:host=" . $this->servername . ";dbname=bplomorongrizal_mtop;charset=" . $this->charset;
			$pdo = new PDO($dsn, "root", "");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		} catch (PDOException $e) {
			echo "Error Connection : " . $e->getMessage();
		}
	}
}
