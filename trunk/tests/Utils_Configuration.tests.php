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

	function test_First() {

		$this->passed();
	}

}

function debug($a) {
	echo '<pre>';
	print_r($a);
	echo '</pre>';
}
?>
