<?php

class curlException extends Exception
{


	public function __construct($message, $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->saveError($message, $code);

	}

	public function saveError($message, $code)
	{
	
		$log = new LogEngine();
		
		$errcodes = [
				0 => "medium",
				1 => "low",
				2 => "high",
				3 => "critical"
				
			    ];

		$log->setInstanceSeverity($errcodes[$code]);
		$log->setMessage('A cURL exception has been triggered: ', $message);
	
		$log->writeLog();
	
	}




}
