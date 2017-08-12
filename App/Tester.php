<?php

require 'Bootstrapper.php'; // Init application

$steam = new SteamAPI((isset($_POST['sid']) ? htmlspecialchars($_POST['sid']) : null));

?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="author" content="Miguel Nogueira">
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>

  <body>

    <div class="form">

      <h1 id="title">SteamID lookup</h1>

      <form name="lookup" id="lookup" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">


        <p>SteamID</p>
        <input type="text" name="sid" id="insteam">
        <input type="submit" name="submit" value="Magic">

        <p id="presult">Result: <?php echo $steam->GetUserSteamName(); ?></p>


      </form>

    </div>

  </body>
</html>
