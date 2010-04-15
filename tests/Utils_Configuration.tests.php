<?php

//ini_set( 'display_errors', 'Off' ); 
error_reporting( E_ALL ^ E_DEPRECATED  );

require_once('C:/wamp/www/simpletest/autorun.php');
require_once('../Utils/Configuration/Configuration.class.php');


class Configuration_test extends UnitTestCase {

	function test_First() {

		$this->assertTrue(1==1);
	}

}

function debug($a) {
	echo '<pre>';
	print_r($a);
	echo '</pre>';
}
?>
