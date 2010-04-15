<?php

//ini_set( 'display_errors', 'Off' ); 
error_reporting( E_ALL ^ E_DEPRECATED  );

require_once('C:/wamp/www/simpletest/autorun.php');
require_once('../Data_Reader.class.php');


class _test extends UnitTestCase {

	const DSN = 'mysql:host=localhost;dbname=hestia';
	const USER = 'root';
	const PASS = '';

	function test_construct_Connection() {

		try {
			$o = new Data_Reader(self::DSN, self::USER, self::PASS);
		} catch(Exception $e) {
			echo $e->getMessage();
		}
		$this->assertTrue(1==1);
	}

	function test_construct_NotConnected_ExceptionExpected() {

		try {
			$o = new Data_Reader('sialala', self::USER, self::PASS);
		} catch(Exception $e) {
			$this->assertTrue(1==1);
			return;
		}
		$this->fail();
	}

	function test_getUniqueFunds_returnArrayCount26() {

		try {
			$o = new Data_Reader(self::DSN, self::USER, self::PASS);
		} catch(Exception $e) {
			$this->fail();
			return;
		}

		$res = $o->getUniqueFunds();
		$this->assertTrue(count($res) == 26);
	}


	function test_getUniqueFunds_returnArray() {

		try {
			$o = new Data_Reader(self::DSN, self::USER, self::PASS);
		} catch(Exception $e) {
			$this->fail();
			return;
		}

		$res = $o->getUniqueFunds();

		$this->assertTrue(is_array($res));
	}


	function test_read_returnArray() {

		try {
			$o = new Data_Reader(self::DSN, self::USER, self::PASS);
		} catch(Exception $e) {
			$this->fail();
			return;
		}

		$res = $o->getUniqueFunds();

		$n = count($res);
		
		for($i = 0; $i < $n; $i++)
		{
			
			$arr = $o->read($res[$i]['idchartindex']);
			$this->assertTrue(is_array($arr));
		}
	}
}

function debug($a) {
	echo '<pre>';
	print_r($a);
	echo '</pre>';
}
?>
