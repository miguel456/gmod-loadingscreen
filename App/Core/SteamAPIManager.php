<?php

class SteamAPI
{

  private $AccessKey;

  private $AccessKeyConverter;

  private $SteamUsername;

  private $SteamID;

  private $SteamID64;


  public function __construct($SteamID)
  {
    $c = new Configuration();

    // garry's steam ID if none is supplied (ex. first page load), so the name showing up will be garry's until you enter an ID.
    (is_null($SteamID)) ? $nID = "STEAM_0:1:7099" : $SteamID;

    $this->AccessKey = $c->getIniValue("ApiKey", "main");
    $this->AccessKeyConverter = $c->getIniValue("APIEU_Key", "main");

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

  private function GetConverterBaseURL()
  {
    $key = $this->AccessKeyConverter;

    $url = "https://steamid.eu/api/convert.php?api=$key";

    return $url;

  }

  private function getUserData($What)
  {
    $ch = new cURL();
    $l = new LogEngine();

    // Instead of using this directly, we're using the return value from the converter method.
    // $id = $this->SteamID;

    $id = $this->_32To64CommunityValid();

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

  // Converts a 32 bit SteamID given by the server to a usable, 64 bit community ID
  private function _32To64CommunityValid()
  {
    // Notes to self: The ID32 is what the server originally provides, so it should be SteamID (class field)
    // This method should return a valid ID64.
    $ID32 = $this->SteamID;

    $ch = new cURL();

    $ch->isGET();
    $ch->setOpt(CURLOPT_SSL_VERIFYPEER, false);

    $ApiCall = $this->GetConverterBaseURL() . "&input=$ID32";

    // XML to JSON conversion

    $ch->setURL($ApiCall);

    $result = simplexml_load_string($ch->execute());
    $json = json_encode($result);
    $jsonfinal = json_decode($json, true);

    return $jsonfinal['converted']['steamid64'];

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
