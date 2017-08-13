<?php

require 'Bootstrapper.php';



?>

<html>
  <head>
    <title>Rule manager tester</title>
    <meta charset="utf-8">
  </head>

  <body>

    <pre>
       <?php
          $rules = new RuleManager();
          $rules->testYamlData();
        ?>
    </pre>

  </body>
</html>
