<?php
namespace Silversite\Toolkit;

use DigitalWand\AdminHelper\Helper\Exception;

class Logogo
{
	const EOL = "\n";

	protected $logFileName;
	protected $logsDir = "/local/logogo/";
	protected $logExtension = "logogo"; //расширение файлов лога
	protected $rLogFile; //ресурс открытого файла
	protected $documentRoot;
	protected $fullPath; //полный путь до файла лога
	protected $sessionTempLogNameKey = "LOGOGO_TEMP_FILENAME";
	protected $resultLogMessage;

	protected $separatorType = 1;
	protected $separator1 = "__̴ı̴̴̡̡̡ ̡͌l̡̡̡ ̡͌l̡*̡̡ ̴̡ı̴̴̡ ̡̡͡|̲̲̲͡͡͡ ̲▫̲͡ ̲̲̲͡͡π̲̲͡͡ ̲̲͡▫̲̲͡͡ ̲|̡̡̡ ̡ ̴̡ı̴̡̡ ̡͌l̡̡̡̡.___";
	protected $separator2 = "|̲̲̲͡͡͡ ̲▫̲͡ ̲̲̲͡͡π̲̲͡͡ ̲̲͡▫̲̲͡͡ ̲|̡̡̡ ̡ ̴̡ı̴̡̡ ̡͌l̡ ̴̡ı̴̴̡ ̡l̡*̡̡ ̴̡ı̴̴̡ ̡̡͡|̲̲̲͡͡͡ ̲▫̲͡ ̲̲̲͡͡π̲̲͡͡ ̲̲͡▫̲̲͡͡ |";
	protected $separator3 = "ѧѦ ѧ  ︵͡︵  ̢ ̱ ̧̱ι̵̱̊ι̶̨̱ ̶̱   ︵ Ѧѧ  ︵͡ ︵   ѧ Ѧ    ̵̗̊o̵̖  ︵  ѦѦ ѧ ";
	protected $separator4 = "*****************************";

	/**
	 * Инициализация лога
	 * Файл открыывается для записи
	 * @throws Exception
	 */
	public function initLog()
	{
		if(empty($this->logFileName))
			$this->logFileName = $this->initTempLogName();

		//Проверка папки хранения логов
		if(!is_dir($this->documentRoot . $this->logsDir)) {
			if (!mkdir($this->documentRoot . $this->logsDir, 0775, true))
				throw new Exception("cannot create logs folder");
		}

		$this->fullPath = $this->documentRoot . $this->logsDir . $this->logFileName;

		//Открываем файл по указанному пути
		$this->rLogFile = fopen($this->fullPath, "a");

		$sizeInMb = filesize($this->fullPath)/pow(1024, 2);
		if($sizeInMb > 10)
		{
			$newName = $this->fullPath."_".date("m.Y");
			if(file_exists($newName))
				$newName .= date("|H.i.s");
			rename($this->fullPath, $newName);
			$this->rLogFile = fopen($this->fullPath, "a");
		}

		$this->startLog();

		return $this;
	}

	public function startLog()
	{
		$separator = $this->getSeparator();
		$this->resultLogMessage .= $separator.date("d.m.Y H:i:s").$separator.self::EOL;
		return $this;
	}

	public function add2Log($message)
	{
		if(is_array($message))
		{
			ob_start();
			print_r($message);
			$message = ob_get_contents();
			ob_end_clean();
		}

		$this->resultLogMessage .= $message.self::EOL;
		return $this;
	}

	public function commitLog()
	{
		$this->endLog();
		fwrite($this->rLogFile, $this->resultLogMessage);
		$this->resultLogMessage = "";
		return $this;
	}

	protected function endLog()
	{
		$separator = $this->getSeparator();
		$this->resultLogMessage .= $separator.date("d.m.Y H:i:s").$separator.self::EOL.self::EOL.self::EOL;
	}

	/*
	 * Имя файла для временного лога
	 * */
	protected function initTempLogName()
	{
		if(empty($_SESSION[$this->sessionTempLogNameKey]))
			$_SESSION[$this->sessionTempLogNameKey] = sha1(time()) . "." . $this->logExtension;

		return $_SESSION[$this->sessionTempLogNameKey];
	}

	public function setSeparatorType($sepId)
	{
		$sepId = abs((int) $sepId);
		if(!empty($this->{'separator'.$sepId}))
		{
			$this->separatorType = $sepId;
			return $this;
		}
		else
		{
			return false;
		}
	}

	public function getSeparator()
	{
		return $this->{'separator'.$this->separatorType};
	}

	/**
	 * @return string
	 */
	protected function getDocumentRoot()
	{
		$documentRoot = "";
		$depthLever = 3;
		$filePath = __FILE__;
		$arPath = array_filter(explode("/", $filePath), function($v){ if(!empty($v)) return true; });

		if(!empty($arPath))
		{
			$documentRoot .= "/";
			$i = 0;
			foreach($arPath as $folder)
			{
				if($i != $depthLever)
				{
					$documentRoot .= $folder . "/";
					$i++;
				}
				else
					break;
			}
		}

		return $documentRoot;
	}

	public function __construct($logFile)
	{
		$this->logFileName = $logFile;

		//DOCUMENT_ROOT для cron'a
		if(empty($_SERVER["DOCUMENT_ROOT"]))
			$this->documentRoot = $this->getDocumentRoot();
		else
			$this->documentRoot = $_SERVER["DOCUMENT_ROOT"];
	}

	public function __destruct()
	{
		fclose($this->rLogFile);
	}

	public function setLogName($logFile)
	{
		$this->logFileName = $logFile;
		return $this;
	}

	public function setLogDir($logDir)
	{
		$this->logsDir = $logDir;
		return $this;
	}

}