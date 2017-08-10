<?php

class Configuration
{

  private $iniLocation = __DIR__ . "../Config.in";


  private $ini;


  public function __construct()
  {
    $this->ini = parse_ini_file($this->iniLocation, true);
  }

  private $dataMain =
                  [
                    "ApiKey" => $this->ini['Main']['SteamApiKey'],
                    "ApplicationName" => $this->ini['Main']['ApplicationName']
                  ]
  private $dataDatabase =
                  [
                    "Hostname" => $this->ini['Database']['Hostname'],
                    "Username" => $this->ini['Database']['Username'],
                    "Password" => $this->ini['Database']['Password'],
                    "DatabaseName" => $this->ini['Database']['DatabaseName']

                  ]
  private $dataPreferences =
                  [

                    "WebmasterEmail" => $this->ini['Preferences']['WebmasterEmail'],
                    "PicDir" => $this->ini['Preferences']['PicDir'],
                    "MusicDir" => $this->ini['Preferences']['MusicDir'],
                    "LogDir" => $this->ini['Preferences']['LogDir'],
                    "SendJoinNotifs" => $this->ini['Preferences']['SendJoinNotifs']


                  ]

   private $dataEmail =
                  [
                    "Hostname" => $this->ini['Email']['ServerHostname'],
                    "SMTPUsername" => $this->ini['Email']['SMTPUsername'],
                    "SMTPPassword" => $this->ini['Email']['SMTPPassword']
                  ]


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
