<?php

/**
 * klasa dziedziczaca po Exception pozwalajaca na przechwytywanie wyjatkow
 * tylko z tego "pakietu"
 * */
class Utils_ConfigurationException
	extends Exception {}



/**
 * klasa wyjatkow polegajacych na niewlasciwym typie danych
 * */
class Utils_ConfigurationExpectedException
	extends Utils_ConfigurationException
{
	const EXCEPTION_MSG =
		'Spodziewano sie %s jako argumentu. Otrzymano %s.';
	
	static protected function expectedExceptionMsg($expected, $got)
	{
		return sprintf(self::EXCEPTION_MSG, $expected, $got);
	}
}



/**
 * Klasa wyjatkow rzucanych, gdy oczekiwano bool
 * */
class Utils_Configuration_ExpectedBoolException
	extends Utils_ConfigurationExpectedException
{
	static public function is($data)
	{
		if ( !is_bool($data))
		{
			throw new self(
				self::expectedExceptionMsg('boolean', gettype($data))
			);
		}
	}
}



/**
 * Klasa wyjatkow rzucanych, gdy oczekiwano stringa
 * */
class Utils_Configuration_ExpectedStringException
	extends Utils_ConfigurationExpectedException
{
	static public function is($data)
	{
		if ( !is_string($data))
		{
			throw new self(
				self::expectedExceptionMsg('string', gettype($data))
			);
		}
	}
}


/**
 * Klasa wyjatkow dla braku zadanego klucza
 * */
class Utils_Configuration_NoFieldException
	extends Utils_ConfigurationException
{
	const EXCEPTION_MSG = 'Pole %s nie istenieje.';

	static private function createMessage($field)
	{
		return sprintf(self::EXCEPTION_MSG, $field);
	}
}


/**
 * Klasa wyjatkow dla nielegalnej proby nadpisania danych konfiguracyjnych
 * */
class Utils_Configuration_IllegalOverrideException
	extends	Utils_ConfigurationException
{
	const EXCEPTION_MSG = 'Pole %s juz istenieje. Nie mozna go nadpisac';

	static private function createMessage($field)
	{
		return sprintf(self::EXCEPTION_MSG, $field);
	}

	static public function raise($field)
	{
		throw new self(self::createMessage($field));
	}
}
