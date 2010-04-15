<?php

/**
 * testy klasy Utils_Configuration_XMLLoader
 *
 * @autor: Paryk yarpo Jar <jar dot patryk at gmail dot com>
 * @data: 15-04-2010
 * @last-mod: 15-04-2010
 * */

ini_set( 'display_errors', 'On' ); 
error_reporting( E_ALL ^ E_DEPRECATED  );

require_once('C:/wamp/www/simpletest/autorun.php');
require_once('../Utils/Configuration/XMLLoader.class.php');


class XMLLoad_test extends UnitTestCase {

	function passed()
	{
		$this->assertTrue(1==1);
	}

	private $oLoad;

	function setUp()
	{
		$this->oLoad = new Utils_Configuration_XMLLoader('C:/wamp/www/config/tests/files/conf.xml');
	}

	function tearDown()
	{
		unset($this->oLoad);
	}



	// -------------------------------------------------------------------------

	function test_Load_OK()
	{
		$arr = $this->oLoad->load();
		//debug($arr);
		if (count($arr) == 3)
		{
			$this->passed();
			return;
		}
		$this->fail();
	}
}

function debug($a) {
	echo '<pre>';
	print_r($a);
	echo '</pre>';
}
