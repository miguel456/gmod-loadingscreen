<?php
require "Bootstrapper.php";
 ?>
<html>
  <head>
    <title>PHP Testing</title>
    <meta charset="utf-8">
  </head>

  <body style="text-align: center">

    <h1>PHP Testing -- Temp</h1>
    <!-- This is a temporary file. Not going to be commited nor pushed. -->

    <?php

      $c = new Configuration();

      echo "<p>Logging directory: " . $c->getIniValue("Prefs", "LogDir") . "</p>";

      $l = new LogEngine();
      $l->setInstanceSeverity("MEDIUM");

      $l->setMessage("Testing logging class");
      $l->writeLog();

     ?>

  </body>
</html>
