<?php


class Utils_Configuration
{
	protected $aFields = array();
	protected $bAutoSave = false;

	const EXPECTED_EXCEPTION_MESSAGE =
		'Spodziewano sie %s jako argumentu. Otrzymano %s.';


	/**
	 * Pozwala zaladowac ustawienia z dowolnego zrodla
	 *
	 * @param string $src - odpowiednio spreparowany string pozwalajacy na utworzenie
	 * 		instancji odpowiedniej klasy
	 *
	 * @throw Utils_Configuration_UnknownConfigurationSourceException - jesli
	 * 		podane zrodlo nie da sie odpowiednio zinterpretowac
	 *
	 * @return Utils_Configuration $config
	 * 
	public load( $src )
	{
		$src_type = self::getSrcType($src);

		switch($src_type)
		{
			case self::XML :
				return new Utils_Configuration_XML($src);
			break;

			default:
				throw
					new Utils_Configuration_UnknownConfigurationSourceException(
						'Nieznane zodlo konfiguracji ' . $src);
			break;
		}

		return null;
	}
	*/

	private expectedExceptionMsg($expected, $got)
	{
		return sprinf(self::EXPECTED_EXCEPTION_MESSAGE, $expected, $got);
	}


	/**
	 * Zapisuj za kazdym razem kiedy zostanie zmienione jakies pole
	 * */
	public autoSave( $auto = true )
	{
		if ( !is_bool($auto))
		{
			throw new Utils_Configuration_ExpectedBoolException(
				self::expectedExceptionMsg('boolean', gettype($auto))
			);
		}
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
	private overrideLocked($override, $field)
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
	public add( $field, $value, $override = false )
	{
		if ( !is_string($field))
		{
			throw new Utils_Configuration_ExpectedStringException(
				self::expectedExceptionMsg('string', gettype( $field ))
			);
		}

		if ($this->overrideLocked($override, $field))
		{
			throw new Utils_Configuration_IllegalOverrideException(
				'Pole ' . $field . ' juz istenieje. Nie mozna go nadpisac'
			);
			return;
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
	public exists( $field )
	{
		if ( !is_string($field))
		{
			throw new Utils_Configuration_ExpectedStringException(
				self::expectedExceptionMsg('string', gettype( $field ))
			);
			return false;
		}

		return (!isset($this->aFields[$field]));
	}

	/**
	 * pobierz wartosc pola
	 *
	 * @param string $field - nazwa pola
	 *
	 * @return mixed
	 * */
	public get( $field )
	{
		if ( !$this->exists([$field]))
		{
			throw new Utils_Configuration_NoFieldException(
				'Nie ma pola ' . $field
			);
		}

		return $this->aFields[$field]);
	}


	/**
	 * Wyczysc cala konfiguracje
	 * */
	public clear()
	{
		unset($this->aFields);
		$this->aFields = array();
	}


	/**
	 * Usun konkretne pole
	 * */
	public del( $field )
	{
		if ( !$this->exists([$field]))
		{
			throw new Utils_Configuration_NoFieldException(
				'Nie ma pola ' . $field
			);
			return false;
		}

		unset($this->aFields[$field]));
		return true;
	}


	/**
	 * Wymus zapisanie aktualnych ustawien
	 * */
	public save()
	{
		//$this->obj->save($this->aFields);
	}
}

class Utils_Configuration extends Exception {}
class Utils_Configuration_UnknownConfigurationSourceException
	extends	Utils_Configuration {}
class Utils_Configuration_ExpectedBoolException extends Utils_Configuration {}
