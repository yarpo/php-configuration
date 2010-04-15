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
	
	public function load()
	{
		$n = count((array)$this->oXML->item);
		$this->aSettings = array();

		for($i = 0; $i < $n; $i++)
		{
			$attr = $o->item[$i]->attributes();
			foreach($attr as $field => $value)
			{
				$this->aSettings[$field] = strval($value);
			}
		}


		return $this->aSettings;
	}
}

class Utils_Configuration_XMLLoaderException extends Exception {}

class Utils_Configuration_XMLLoaderOpenFileException
	extends Utils_Configuration_XMLLoaderException {}
