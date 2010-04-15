<?php

/**
 * Abstrakcyjna klasa dostarczajaca interfejsu potrzebnego do odczytu
 * konfiguracji
 *
 * @autor: Paryk yarpo Jar <jar dot patryk at gmail dot com>
 * @data: 15-04-2010
 * @last-mod: 15-04-2010
 * */

require_once 'Loader.interface.php';

class Utils_Configuration_XMLLoader implements Utils_Configuration_Loader
{
	/**
	 * Obiekt przechowujacy XML (SimpleXMLElement)
	 * */
	private $oXML;


	/**
	 * XML przechowywany jako ciag znakow
	 * */
	private $sXML;


	/**
	 * Tablica assoc z ustawieniami
	 * */
	private $aSettings;


	/**
	 * konstruktor
	 *
	 * @param string $path
	 * 
	 * */
	public function __construct($path)
	{
		$this->fileContent($path);
		$this->oXML = new SimpleXMLElement($this->sXML);
	}


	/**
	 * Pobierz tresc z pliku
	 *
	 * @param string $path
	 *
	 * @throw Utils_Configuration_XMLLoaderOpenFileException
	 * */
	private function fileContent($path)
	{
		if ( !file_exists($path))
		{
			Utils_Configuration_XMLLoaderOpenFileException(
				'Nie ma pliku ' . $path);
		}

		$this->sXML = file_get_contents($path);

		if (false === $this->sXML)
		{
			Utils_Configuration_XMLLoaderOpenFileException(
				'Nie udalo sie odczytac zawartosci pliku ' . $path);
		}
	}


	/**
	 * Sprawdza i odpowiednio formatuje i-ty rekord z obiektu XML
	 * */
	private function properXMLItem($i)
	{
		if (!isset($this->oXML->item[$i]) ||
			!isset($this->oXML->item[$i]->name) ||
			!isset($this->oXML->item[$i]->value))
		{
			Utils_Configuration_XMLLoaderWrongXMLException::raise(
				'Nieprawidlowy format XML na indeksie ' . $i);
		}

		return (array)$this->oXML->item[$i];
	}


	/**
	 * odczytuje zawartosc pliku
	 * */
	public function load()
	{
		if (!isset($this->oXML->item))
		{
			Utils_Configuration_XMLLoaderWrongXMLException::raise(
				'Nieprawidlowy format XML');
		}

		$n = count((array)$this->oXML->item);
		$this->aSettings = array();

		for($i = 0; $i <= $n; $i++)
		{
			
			$this->aSettings[] = $this->properXMLItem($i);
		}

		return $this->aSettings;
	}
}

class Utils_Configuration_XMLLoaderException extends Exception {}

class Utils_Configuration_XMLLoaderOpenFileException
	extends Utils_Configuration_XMLLoaderException {}

class Utils_Configuration_XMLLoaderWrongXMLException
	extends Utils_Configuration_XMLLoaderException
{
	static public function raise($msg)
	{
		throw new self($msg);
	}
}
