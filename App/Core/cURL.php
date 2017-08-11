<?php
/*NOTE: I'm reusing code from a private project of mine. I don't really mind, after-all even
*  a child could write something like this. Actually, this is just a tiny fraction of code
*  from a rather large codebase. Lucky me I decided to make that codebase modular so I can just repurpose modules like these for
*  anything really.
* Oh by the way, the only thing I changed here was cURL's user agent which was exposing the project's name.
*/

/**
 *
 * Object oriented middleman for cURL.
 * This middleman is extremely simple and only covers the basic functionality of cURL,
 * something made to avoid code repetition when various simple cURL tasks (i.e. retrieving documents and sending data) are needed troughout one class' methods.
 *
 * @example Retrieving Google's home page:
 *
 * require "yourvendorpath/autoload.php";
 *
 * $ch = new cURL();
 * $ch->isGET();
 * $ch->setURL("https://www.google.com");
 *
 * print($ch->execute());
 *
 * @exaple POSTing data to a login form:
 *  require "yourvendorpath/autoload.php"
 *
 *  $ch = new cURL();
 *  $ch->isPOST(); // This line is critical. The wrapper needs a way to know what you want to do.
 *
 *  $data = ['username' => "mark", 'password' => "12345678", 'email' => "my(at)mail.ru"];
 *
 *  $ch->setPostData($data);
 *
 *  print($ch->execute()); // ex. could output "login successful"
 *
 * @throws curlException
 *
 * Note that the above example code should be involved in try catch blocks for the exception "curlException".
 *
 */

 class cURL
 {
     private $chandle;

     private $method;

     private $filter_mode;

     private $postData;



     public function __construct()
     {
         $this->chandle = curl_init();

         curl_setopt($this->chandle, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($this->chandle, CURLOPT_HEADER, 0);
         curl_setopt($this->chandle, CURLOPT_USERAGENT, "GMod-LoadingScreen/1.0");



     }

     public function isGET()
     {
         $this->method = "GET";
     }

     public function isPOST()
     {
         $this->method = "POST";
     }

     // blocks everything on blacklist, ignores those outside
     public function modeBlacklist()
     {
         $this->filter_mode = "bl";
     }

     // blocks everything but those in whitelist
     public function modeWhitelist()
     {
         $this->filter_mode = "wl";
     }


     public function setPostData($data)
     {
         if (!is_array($data))
         {   // NOTE: This exception is only implemented on that project (read initial comment), they aren't modular so I'll just change this to Exception() for now.
             // throw new curlException("Data for a POST request must be formatted in an array syntax!");
             throw new Exception("Data for a POST request must be formatted in an array syntax!");
         }

         $this->postData = $data;
     }

     public function setURL($url)
     {
        curl_setopt($this->chandle, CURLOPT_URL, $url);

     }

     /**
      *
      *
      * One must pass valid cURL options and values, they are not validated by the middleman
      *
      */
     public function setOpt($opt, $value)
     {
         curl_setopt($this->chandle, $opt, $value);
     }

     public function execute()
     {
         switch($this->method)
         {
             case "POST":

                if(empty($this->postData))
                {   // NOTE: Changing to Exception().
                    // throw new curlException("No data supplied for POST request!");
                    throw new Exception("No data supplied for POST request!");
                }

                $this->setOpt(CURLOPT_POST, 1);
                $this->setOpt(CURLOPT_POSTFIELDS, $this->postData);

                $ret = curl_exec($this->chandle);
                break;
            case "GET":
                $ret = curl_exec($this->chandle);
                break;
         }

         if ($ret == false || $ret == null)
         {    // NOTE: Again, changing to Exception().
             // throw new curlException("A " . $this->method . " request failed: " . curl_errno($this->chandle));
             throw new Exception("A " . $this->method . " request failed: " . curl_errno($this->chandle));
         }

         return $ret;
     }

     public function __destruct()
     {
         curl_close($this->chandle);
     }

 }
