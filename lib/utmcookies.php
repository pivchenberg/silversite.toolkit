<?php

namespace Silversite\Toolkit;

class UtmCookies
{
	const UTM_FIRST_NAME = 'SS_UTM_FIRST';
	const UTM_LAST_NAME = 'SS_UTM_LAST';

	private static $instance = null;

	private $utmFirst;
	private $utmLast;
	private $get;
	private $arUtm = [];
	private $cookieExpire;

	private function __construct()
	{
		$this->utmFirst = isset($_COOKIE[self::UTM_FIRST_NAME]) ? strip_tags($_COOKIE[self::UTM_FIRST_NAME]) : "";
		$this->utmLast = isset($_COOKIE[self::UTM_LAST_NAME]) ? strip_tags($_COOKIE[self::UTM_LAST_NAME]) : "";
		$this->get = isset($_GET) ? $_GET : [];
		$date = new \DateTime();
		$interval = new \DateInterval('P3M');
		$date->add($interval);
		$this->cookieExpire = $date->getTimestamp();
	}

	static function getInstance()
	{
		if (empty(self::$instance))
			self::$instance = new self;

		return self::$instance;
	}

	public function listenGetRequest()
	{
		foreach($this->get as $key => $value)
		{
			if(preg_match('/^utm(.*)/iu', $key))
			{
				$this->arUtm[] = strip_tags($key . "=" . $value);
			}
		}

		if(!empty($this->arUtm))
			$this->setUtmCookie();
	}

	public function setUtmCookie()
	{
		$strUtm = implode('?', $this->arUtm);


		if(empty($this->utmFirst))
		{
			setcookie(self::UTM_FIRST_NAME, $strUtm, $this->cookieExpire, '/', $_SERVER["SERVER_NAME"], false, true);
			$this->utmFirst = $strUtm;
		}

		setcookie(self::UTM_LAST_NAME, $strUtm, $this->cookieExpire, '/', $_SERVER["SERVER_NAME"], false, true);
		$this->utmLast = $strUtm;
	}

	/**
	 * @return string
	 */
	public function getUtmFirst()
	{
		return $this->utmFirst;
	}

	/**
	 * @return string
	 */
	public function getUtmLast()
	{
		return $this->utmLast;
	}
}
