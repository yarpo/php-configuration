<?php

/**
 * Abstrakcyjna klasa dostarczajaca interfejsu potrzebnego do odczytu
 * konfiguracji
 *
 * @autor: Paryk yarpo Jar <jar dot patryk at gmail dot com>
 * @data: 15-04-2010
 * @last-mod: 15-04-2010
 * */

abstract class Utils_Configuration_Loader
{
	abstract public function load($array);
}
