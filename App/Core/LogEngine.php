<?php

class LogEngine
{
  private $logMessage;


  private $logSeverity;


  private $logDebug;


  public function __construct($LogDebug = false)
  {
    ($LogDebug == true) ? $this->logDebug = true : $this->logDebug = false;
  }

  public function setInstanceSeverity($Severity = "LOW")
  {
    $ValidSeverityLevels = [
                            'LOW',
                            "MEDIUM",
                            "HIGH",
                            "CRITICAL",
                            "INFO"
                          ];

    if (!in_array($Severity, $ValidSeverityLevels))
    {
      throw new InvalidArgumentException("Invalid severity level!");
    }
    $this->logSeverity = $Severity;
  }

  public function setMessage($Message)
  {
    if (is_int($Message))
    {
      throw new InvalidArgumentException("Please enter a string!");
    }
    $this->logMessage = $Message;
  }

  public function writeLog()
  {
    $Config = new Configuration();
    $Sev = $this->logSeverity;
    $Dat = date('l jS \of F Y h:i:s A');

    $h = fopen($Config->getIniValue("Prefs", "LogDir") . "/messages.log", "a+");
    fwrite($h, "[{$Sev}] ({$Dat}) -> " . $this->logMessage . PHP_EOL);
    fclose($h);
  }
}
