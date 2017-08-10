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
    $this->ini = parse_ini_file($this->iniLocation, true);

    $this->dataMain["ApiKey"] = $this->ini['Main']['SteamApiKey'];
    $this->dataMain["ApplicationName"] = $this->ini['Main']['ApplicationName'];

    $this->dataDatabase['Hostname'] = $this->ini['Database']['Hostname'];
    $this->dataDatabase['Username'] = $this->ini['Database']['Username'];
    $this->dataDatabase['Password'] = $this->ini['Database']['Password'];
    $this->dataDatabase['DatabaseName'] = $this->ini['Database']['DatabaseName'];

    $this->dataPreferences['WebmasterEmail'] = $this->ini['Preferences']['WebmasterEmail'];
    $this->dataPreferences['PicDir'] = $this->ini['Preferences']['PicDir'];
    $this->dataPreferences['LogDir'] = $this->ini['Preferences']['LogDir'];
    $this->dataPreferences['MusicDir'] = $this->ini['Preferences']['MusicDir'];
    $this->dataPreferences['SendJoinNotifs'] = $this->ini['Preferences']['SendJoinNotifs'];

    $this->dataEmail['Hostname'] = $this->ini['Email']['ServerHostname'];
    $this->dataEmail['SMTPUsername'] = $this->ini['Email']['SMTPUsername'];
    $this->dataEmail['SMTPPassword'] = $this->ini['Email']['SMTPPassword'];

  }

  public function getIniValue($ValueName, $Section)
    {

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
        }
        break;

      }

    }
    // Convenience method.
    public function getApiKey()
    {
      return $this->getIniValue("main", "ApiKey");
    }

}
