<?php

/**
 * testy klasy pozwalajaca na trzymanie i zarzadzanie konfiguracja aplikacji PHP
 *
 * @autor: Paryk yarpo Jar <jar dot patryk at gmail dot com>
 * @data: 15-04-2010
 * @last-mod: 15-04-2010
 * */

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



	function test_add_NoStringParam_throwUtils_Configuration_ExpectedStringException()
	{
		try
		{
			$this->oConfig->add(true, "a");
		}
		catch(Utils_Configuration_ExpectedStringException $e)
		{
			$this->passed();
			return;
		}

		$this->fail();
	}



	function test_add_DoubleField_ThrowUtils_Configuration_IllegalOverrideException()
	{
		try
		{
			$this->oConfig->add("jeden", "a");
		}
		catch(Exception $e)
		{
			$this->fail("Ustawianie pierwszej wartosci");
			return;
		}

		try
		{
			$this->oConfig->add("jeden", 12);
		}
		catch(Utils_Configuration_IllegalOverrideException $e)
		{
			$this->passed();
		}


		try
		{
			$this->oConfig->add("jeden", 12, false);
		}
		catch(Utils_Configuration_IllegalOverrideException $e)
		{
			$this->passed();
			return;
		}
		
		$this->fail("test_add_DoubleField_ThrowUtils_Configuration_IllegalOverrideException");
	}



	function test_add_DoubleField_NoException()
	{
		try
		{
			$this->oConfig->add("jeden", "a");
			$this->oConfig->add("jeden", "b", true);
		}
		catch(Exception $e)
		{
			$this->fail("test_add_DoubleField_NoException");
			return;
		}

		$this->passed();
	}



	function test_exists_returnTrue()
	{
		$this->oConfig->add("jeden", "a");
		$result = $this->oConfig->exists("jeden");
		$this->assertTrue($result);
	}


	function test_exists_returnFalse()
	{
		$result = $this->oConfig->exists("jeden");
		$this->assertFalse($result);
	}
}

function debug($a) {
	echo '<pre>';
	print_r($a);
	echo '</pre>';
}
?>
