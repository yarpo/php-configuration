<?php

/**
 * Klasa pozwalajaca na trzymanie i zarzadzanie konfiguracja aplikacji PHP
 *
 * @autor: Paryk yarpo Jar <jar dot patryk at gmail dot com>
 * @data: 15-04-2010
 * @last-mod: 15-04-2010
 * */

require_once 'ConfigurationExceptions.classSet.php';
require_once 'Saver.aclass.php';
require_once 'XMLLoader.class.php';


class Utils_Configuration
{
	/**
	 * Przechowuje 'pole' : wartosc
	 * */
	protected $aFields = array();


	/**
	 * Sprawdza, czy nalezy za kazdym razem zapisywac
	 * */
	protected $bAutoSave = false;


	/**
	 * Czysci pamiec
	 * */
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
	 *
	 * @param string $field
	 *
	 * @throw Utils_Configuration_NoFieldException
	 * */
	public function del( $field )
	{
		if ( !$this->exists($field))
		{
			Utils_Configuration_NoFieldException::raise($field);
		}

		unset($this->aFields[$field]);
	}


	/**
	 * Wymus zapisanie aktualnych ustawien
	 * */
	public function save(Utils_Configuration_Saver $obj)
	{
		$this->obj->save($this->aFields);
	}


	/**
	 * Wymus zapisanie odczytanie ustawien
	 *
	 * @param Utils_Configuration_Loader $obj - objekt z ktorego odczytuje sie
	 * 		nowe ustawienia
	 * @param bool $override - czy ustawienia maja zostac nadpisane, czy dodac
	 * 		do juz istniejacych
	 * 		* UWAGA: Dublowane klucze zostaną nadpisane przez nowe ustawienia
	 * */
	public function load( Utils_Configuration_Loader $obj, $override = false )
	{
		$config = $this->obj->load();
		if ($override)
		{
			$this->aFields = $config;
		}
		else
		{
			$this->aFields = array_merge($this->aFields, $config);
		}
	}
}
