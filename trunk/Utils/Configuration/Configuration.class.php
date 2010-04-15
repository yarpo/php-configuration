<?php


class Utils_Configuration
{
	protected $aFields = array();
	protected $bAutoSave = false;

	public function __destruct()
	{
		unset($this->aFields);
		unset($this->bAutoSave);
	}

	/**
	 * Zapisuj za kazdym razem kiedy zostanie zmienione jakies pole
	 *
	 * @param bool $auto - wartosc na jaka zmienic
	 *
	 * @throw Utils_Configuration_ExpectedBoolException
	 *
	 * @return bool;
	 * */
	public function autoSave( $auto = true )
	{
		Utils_Configuration_ExpectedBoolException::is($auto);

		$this->bAutoSave = $auto;
		return $this->bAutoSave;
	}


	/**
	 * Sprawdza czy mozna nadpisac pole
	 *
	 * @param bool override - flaga rpzekazana prze zuzytkownika
	 * @param string field - nazwa pola
	 *
	 * @return bool
	 * */
	private function overrideLocked($override, $field)
	{
		return (false == $override && isset($this->aFields[$field]));
	}

	/**
	 * Dodaj nowe pole
	 *
	 * @param string $field - nazwa pola
	 * @param mixed $value - wartosc pola
	 * @param bool override = false - czy nadpisac, jesli juz istanieje
	 * */
	public function add( $field, $value, $override = false )
	{
		Utils_Configuration_ExpectedStringException::is($field);

		if ($this->overrideLocked($override, $field))
		{
			Utils_Configuration_IllegalOverrideException::raise($field);
		}

		$this->aFields[$field] = $value;
	}


	/**
	 * Sprawdza czy istnieje takie pole
	 *
	 * @param string $field
	 *
	 * @throw Utils_Configuration_ExpectedStringException - gdy przekazano
	 * 		co innego niz string
	 * */
	public function exists( $field )
	{
		Utils_Configuration_ExpectedStringException::is($field);

		return (isset($this->aFields[$field]));
	}

	/**
	 * pobierz wartosc pola
	 *
	 * @param string $field - nazwa pola
	 *
	 * @return mixed
	 * */
	public function get( $field )
	{
		if ( !$this->exists($field))
		{
			Utils_Configuration_NoFieldException::raise($field);
		}

		return $this->aFields[$field];
	}


	/**
	 * Wyczysc cala konfiguracje
	 * */
	public function clear()
	{
		unset($this->aFields);
		$this->aFields = array();
	}


	/**
	 * Usun konkretne pole
	 * */
	public function del( $field )
	{
		if ( !$this->exists($field))
		{
			Utils_Configuration_NoFieldException($field);
		}

		unset($this->aFields[$field]);
		return true;
	}


	/**
	 * Wymus zapisanie aktualnych ustawien
	 * // TODO
	 * */
	public function save(Utils_Configuration_Save $obj)
	{
		$this->obj->save($this->aFields);
	}
}

abstract class Utils_Configuration_Save
{
	abstract public function save($array);
}

class Utils_ConfigurationException extends Exception {}
class Utils_ConfigurationExpectedException extends Utils_ConfigurationException
{
	const EXPECTED_EXCEPTION_MESSAGE =
		'Spodziewano sie %s jako argumentu. Otrzymano %s.';
	
	static protected function expectedExceptionMsg($expected, $got)
	{
		return sprintf(self::EXPECTED_EXCEPTION_MESSAGE, $expected, $got);
	}
}

class Utils_Configuration_NoFieldException extends Utils_ConfigurationException
{
	const EXCEPTION_MSG = 'Pole %s nie istenieje.';

	static private function createMessage($field)
	{
		return sprintf(self::EXCEPTION_MSG, $field);
	}
}

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

class Utils_Configuration_UnknownConfigurationSourceException
	extends	Utils_ConfigurationException{}

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
