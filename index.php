<?php
require('config.php');

//Error URL's
$error_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$error_url_test = $error_url . "?steamid=76561198043788577&mapname=test_map";
$error_url_server = $error_url . "?steamid=%s&mapname=%m";

error_reporting(0);
@set_time_limit(3);

$r       = mt_rand(1,3);
$plname  = 'Player';
$map     = '';
$avatar  = 'img/nouser.png';

$authors = array(
    1 => '$song1',
    2 => '$song2',
    3 => '$song3'
);

$pictures = array(1,2,3);
shuffle($pictures);

if (isset($_GET['mapname'])){
    $map = '<br>You will play the map: '.$_GET['mapname'];
}
else {
    die("<img src='img/ohno.jpg' style='margin-top: 20px height='256' width='256';' /><br />Oh-No! you don't seem to be using the correct parameters for this loading screen to function correctly.<br />
    Please make sure you have the value of <code>sv_loadingurl</code> correctly set with all required url parameters e.g. <code>www.yourdomain.com/loading/index.php?steamid=%s&mapname=%m</code><br /><br />
    You can test with the link below to make sure everything is working correctly<br />
    <a href='$error_url_test'>$error_url_test</a><br /><br />
    
    When setting your loading url please make sure you set the paremeters correctly as seen in the link below<br />
    <a href='$error_url_server'>$error_url_server</a>
    
    ");
}

if (isset($_GET['steamid'])) {
    $data = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$apikey.'&steamids='.$_GET['steamid'];
    $f = file_get_contents($data);
    $arr = json_decode($f, true);
    if (isset($arr['response']['players'][0]['personaname']))
        $plname = $arr['response']['players'][0]['personaname'];
    if (isset($arr['response']['players'][0]['avatar']))
        $avatar = $arr['response']['players'][0]['avatar'];
    
}
else {
    die("<img src='img/ohno.jpg' style='margin-top: 20px height='256' width='256';' /><br />Oh-No! you don't seem to be using the correct parameters for this loading screen to function correctly.<br />
    Please make sure you have the value of <code>sv_loadingurl</code> correctly set with all required url parameters e.g. <code>www.yourdomain.com/loading/index.php?steamid=%s&mapname=%m</code><br /><br />
    You can test with the link below to make sure everything is working correctly<br />
    <a href='$error_url_test'>$error_url_test</a><br /><br />
    
    When setting your loading url please make sure you set the paremeters correctly as seen in the link below<br />
    <a href='$error_url_server'>$error_url_server</a>
    
    ");
}

?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro">

    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body> 
    <audio autoplay loop>
        <source src="music/<?php echo $r?>.ogg" type="audio/ogg">
    </audio>
    <div class="container">
        <div class="jumbotron" style="margin-top: 50px;">
            <div class="pull-right cycle-slideshow" data-cycle-fx="none">
                <?php foreach ($pictures as $pic) {
                    echo '<img src="img/'.$pic.'.jpg" alt="Picture '.$pic.'" class="imgtop img-rounded">';
                }?>
            </div>
            <h1 id="title" class="bigEntrance" style="font-size: 50px;"><?php echo $title ?></h1>
            <p class="lead">
                <?php echo $slogan ?><br>
                <small>
                    <ul style="line-height: 1.6;">
                        <li><?php echo $rule1 ?></li>
                        <li><?php echo $rule2 ?></li>
                        <li><?php echo $rule3 ?></li>
                        <li><?php echo $rule4 ?></li>
                        <li><?php echo $rule5 ?></li>
                    </ul>
                    <?php echo $cslogan ?>
                    <br>
                    <code><?php echo $curl ?></code>
                </small>
            </p>

        </div>
    </div>
    <div style="position: absolute;bottom: 0px;left: 20px;font-size: 12px;min-width: 260px;" class="well well-sm">
        <img src="<?php echo $avatar?>" alt="" class="pull-right img-circle">
        Hello, <b><?php echo $plname ?></b><?php echo $map ?><br>
        Music: "<?php echo $authors[$r];?>"
    </div>
    <script src="js/vendor/jquery-1.10.1.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.cycle2.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
