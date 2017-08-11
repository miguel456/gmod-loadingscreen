<?php

class SteamAPI
{

  private $AccessKey;

  private $SteamUsername;

  private $SteamID;


  public function __construct($SteamID)
  {
    $c = new Configuration();

    $this->AccessKey = $c->getIniValue("ApiKey", "Main");
    $this->SteamID = $SteamID;
    $this->SteamUserName = $this->getUserData("Username");

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

    $id = $this->SteamID;

    $ApiCall = $this->GetBaseURL() . "&steamids=$id";
    $ch->isGET();

    switch($What)
    {



      case "Username":

        $ch->setURL($ApiCall);

        $data = json_decode($ch->execute(), true);

        $ret = $data['response']['players'][0]['personname'];
        break;

      case "Picture":

        $ch->setURL($ApiCall);
        $data = json_decode($ch->execute(), true);

        $ret = $data['response']['players'][0]['avatar']; // URL
        // TODO: Implement the rest of the ISteamUser interface
        break;
      default:
        throw new InvalidArgumentException("Don't know what to do. Supply a valid action and try again.");

    }

    return $ret;

  }

  public function GetUserPicture()
  {
    return $this->getUserData("Picture");
  }

  public function GetUserSteamName()
  {
    return $this->SteamUsername;
  }

}
