<?php

class SteamAPI
{

  private $AccessKey;

  private $SteamUsername;

  private $SteamID;


  public function __construct($SteamID)
  {
    $c = new Configuration();

    // garry's steam ID if none is supplied (ex. first page load), so the name showing up will be garry's until you enter an ID.
    (is_null($SteamID)) ? $nID = "76561197960279927" : $SteamID;

    $this->AccessKey = $c->getIniValue("ApiKey", "main");
    $this->SteamID = (isset($nID)) ? $nID : $SteamID;

  }

  private function getCURL()
  {
    return new cURL();
  }

  private function GetBaseURL()
  {

    $key = $this->AccessKey;

    $url = "https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$key";

    return $url;

  }

  private function getUserData($What)
  {
    $ch = new cURL();
    $l = new LogEngine();

    $id = $this->SteamID;

    $ApiCall = $this->GetBaseURL() . "&steamids=$id";

    $ch->isGET();
    $ch->setOpt(CURLOPT_SSL_VERIFYPEER, false); // Avoid invalid certificate error

    switch($What)
    {



      case "Username":

        $ch->setURL($ApiCall);

        $data = json_decode($ch->execute(), true);
        $ret = $data['response']['players'][0]['personaname'];
        break;

      case "Picture":

        $ch->setURL($ApiCall);
        $data = json_decode($ch->execute(), true);

        $ret = $data['response']['players'][0]['avatar']; // URL
        // TODO: Implement the rest of the ISteamUser interface
        break;
      default:
        $l->setInstanceSeverity("CRITICAL");
        $l->setMessage("Action selector error on method " . __METHOD__ . ". An invalid action was specified.");

        $l->writeLog();
        throw new InvalidArgumentException("An internal error has ocurred. Please check your log file.");

    }

    return $ret;

  }

  public function GetUserPicture()
  {

    $l = new LogEngine();
    $l->setInstanceSeverity("INFO");

    $l->setMessage("Retrieving Steam Profile picture for SteamID " . $this->SteamID);
    $l->writeLog();

    return $this->getUserData("Picture");

  }

  public function GetUserSteamName()
  {
    $l = new LogEngine();
    $l->setInstanceSeverity("INFO");

    $l->setMessage("Retrieving Steam Name for SteamID " . $this->SteamID);
    $l->writeLog();

    return $this->getUserData("Username");
  }

}
