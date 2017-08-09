<?php

class LogEngine
{
  private $logMessage;


  private $logSeverity;


  private $logDebug;


  public function __construct($LogDebug = false)
  {
    ($logDebug == true) : $this->logDebug = true : $this->logDebug = false;
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

    if (!in_array($ValidSeverityLevels, $Severity))
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
    $Config = new Configuration()
    $Sev->logSeverity;
    $Dat = date('l jS \of F Y h:i:s A');

    $h = fopen($Config->getLoggingDirectory() . "/messages.log", "w+");
    fwrite($h, "[{$Sev}] ({$Dat}) -> " . $this->logMessage . PHP_EOL);
    fclose($h);
  }
}
