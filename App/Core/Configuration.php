<?php

class Configuration
{

  private $iniLocation = __DIR__ . "/../Config.ini";


   private $ini;


   private $dataMain;


   private $dataDatabase;



   private $dataPreferences;



   private $dataEmail;


  public function __construct()
  {
    $l = new LogEngine();
    // TODO: Fix memory limit crash
    $this->ini = parse_ini_file($this->iniLocation, true);

    $this->dataMain["ApiKey"] = $this->ini['Main']['SteamApiKey'];

    if(empty($this->dataMain['ApiKey']))
    {
      $l->setInstanceSeverity("WARNING");
      $l->setMessage("Your API key setting is empty! Please fill it with your key, otherwise, name resolution WILL NOT work.");
      $l->writeLog();

      // This exception should not be removed as this will cause a memory limit (or execution limit) to be hit
      throw new RuntimeException("ERROR: API Key not found. Please check your logfile.");

    }


    $this->dataMain["ApplicationName"] = $this->ini['Main']['ApplicationName'];
    $this->dataMain["SteamIDConvKey"] = $this->ini['Main']['SteamID_EUKey'];

    $this->dataDatabase['Hostname'] = $this->ini['Database']['Hostname'];
    $this->dataDatabase['Username'] = $this->ini['Database']['Username'];
    $this->dataDatabase['Password'] = $this->ini['Database']['Password'];
    $this->dataDatabase['DatabaseName'] = $this->ini['Database']['DatabaseName'];

    $this->dataPreferences['WebmasterEmail'] = $this->ini['Preferences']['WebmasterEmail'];
    $this->dataPreferences['PicDir'] = $this->ini['Preferences']['PicDir'];
    $this->dataPreferences['LogDir'] = $this->ini['Preferences']['LogDir'];
    $this->dataPreferences['MusicDir'] = $this->ini['Preferences']['MusicDir'];
    $this->dataPreferences['SendJoinNotifs'] = $this->ini['Preferences']['SendJoinNotifs'];
    $this->dataPreferences['RulesFile'] = $this->ini['Preferences']['RulesFile'];

    $this->dataEmail['Hostname'] = $this->ini['Email']['ServerHostname'];
    $this->dataEmail['SMTPUsername'] = $this->ini['Email']['SMTPUsername'];
    $this->dataEmail['SMTPPassword'] = $this->ini['Email']['SMTPPassword'];

  }

  public function getIniValue($ValueName, $Section)
    {
      // TODO: Throw meaningful exception instead of a silent error message
      $l = new LogEngine();

      switch($Section)
      {
        case "email":

          switch($ValueName)
          {
            case "Hostname":
              $data =  $this->dataEmail['Hostname'];
              break;
            case "SMTPUser":
              $data = $this->dataEmail['SMTPUsername'];
              break;
            case "SMTPPass":
              $data = $this->dataEmail['SMTPPassword'];
              break;
            default:
              $l->setInstanceSeverity("ERROR");
              $l->setMessage("Unexpected data for category \"email\". Received the following: " . $ValueName);

              $l->writeLog();
              throw new UnexpectedValueException("An internal error has ocurred. Please check your logs for info.");

          }

          break;
       case "Prefs":

          switch($ValueName)
          {
            case "joinNotif":
              $data = $this->dataPreferences['SendJoinNotifs'];
              break;
            case "LogDir":
              $data = $this->dataPreferences['LogDir'];
              break;
            case "MusicDir":
              $data = $this->dataPreferences['MusicDir'];
              break;
            case "PicDir":
              $data = $this->dataPreferences['PicDir'];
              break;
            case "WebmasterEmail":
              $data = $this->dataPreferences['WebmasterEmail'];
              break;
            case "RulesFile":
              $data = $this->dataPreferences['RulesFile'];
              break;
            default:

              $l->setInstanceSeverity("ERROR");
              $l->setMessage("Unexpected data for category \"Preferences\". Received the following: " . $ValueName);

              $l->writeLog();
              throw new UnexpectedValueException("An internal error has ocurred. Please check your logs for info.");

          }
          break;
        case "database":

          switch($ValueName)
          {
            case "Hostname":
              $data = $this->dataDatabase['Hostname'];
              break;
            case "Username":
              $data = $this->dataDatabase['Username'];
              break;
            case "Password":
              $data = $this->dataDatabase['Password'];
              break;
            case "DatabaseName":
              $data = $this->dataDatabase['DatabaseName'];
              break;
            default:
              $l->setInstanceSeverity("ERROR");
              $l->setMessage("Unexpected data for category \"Database\". Received the following: " . $ValueName);

              $l->writeLog();
              throw new UnexpectedValueException("An internal error has ocurred. Please check your logs for info.");


          }
          break;
       case "main":

        switch($ValueName)
        {
          case "ApiKey":
            $data = $this->dataMain["ApiKey"];
            break;
          case "ApplicationName":
            $data = $this->dataMain["ApplicationName"];
            break;
          case "APIEU_Key":
            $data = $this->dataMain['SteamIDConvKey'];
            break;
          default:
            $l->setInstanceSeverity("ERROR");
            $l->setMessage("Unexpected data for category \"Main\". Received the following: " . $ValueName);

            $l->writeLog();
            throw new UnexpectedValueException("An internal error has ocurred. Please check your logs for info.");

        }
        break;
      default:

        $l->setInstanceSeverity("ERROR");
        $l->setMessage("Unexpected data for global selector. Received the following: " . $ValueName);

        $l->writeLog();
        throw new UnexpectedValueException("An internal error has ocurred. Please check your logs for info.");



        break;

      }
      return (isset($data)) ? $data : "ERR_UNKNOWN_RETURN";

    }
    // Convenience method.
    public function getApiKey()
    {
      return $this->getIniValue("main", "ApiKey");
    }

}
