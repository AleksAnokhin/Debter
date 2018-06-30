<?php
namespace Helpers\DB;

final class DB {
	
	const HOST = 'localhost';
	const USER = 'root';
	const PASS = '';
	const BASE = 'debter';
	private static $db = NULL;
	
	private function __construct() {
		self::$db = mysqli_connect(self::HOST,self::USER,self::PASS,self::BASE);
		mysqli_set_charset(self::$db,'utf8');
		return self::$db;
	}
	public static function getDB() {
		if(self::$db === NULL) {
			new self();
		}
		return self::$db;
	}
	public static function escape($str) {
		$str = htmlspecialchars($str);
		return mysqli_real_escape_string(self::getDB(),$str);
	}
	private function __clon() {}
    public function __set($a, $b) {}
    private function __sleep() {}
    private function __wakeup() {}
}













?>