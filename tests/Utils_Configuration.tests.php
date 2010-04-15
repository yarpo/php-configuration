<?php

ini_set( 'display_errors', 'On' ); 
error_reporting( E_ALL ^ E_DEPRECATED  );

require_once('C:/wamp/www/simpletest/autorun.php');
require_once('../Utils/Configuration/Configuration.class.php');


class Configuration_test extends UnitTestCase {

	function passed()
	{
		$this->assertTrue(1==1);
	}

	function autoSave($param, $expected)
	{
		$result = !$expected;

		try
		{
			if (null === $param)
			{
				$result = $this->oConfig->autoSave();
			}
			else
			{
				$result = $this->oConfig->autoSave($param);
			}
		}
		catch(Exception $e)
		{
			$this->fail();
		}

		$this->assertEqual($result, $expected);
	}

	private $oConfig;

	function setUp()
	{
		$this->oConfig = new Utils_Configuration();
	}

	function tearDown()
	{
		unset($this->oConfig);
	}



	// -------------------------------------------------------------------------

	function test_autoSave_NoBoolParam_throwsUtils_Configuration_ExpectedBoolException()
	{
		try
		{
			$this->oConfig->autoSave('siala');
		}
		catch(Utils_Configuration_ExpectedBoolException $e)
		{
			$this->passed();
			return;
		}

		$this->fail();
	}



	function test_autoSave_NoParams_returnTrue()
	{
		$this->autoSave(null, true);
	}



	function test_autoSave_TrueParam_returnTrue()
	{
		$this->autoSave(true, true);
	}



	function test_autoSave_FalseParam_returnFalse()
	{
		$this->autoSave(false, false);
	}


	
}

function debug($a) {
	echo '<pre>';
	print_r($a);
	echo '</pre>';
}
?>
