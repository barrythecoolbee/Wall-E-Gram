<?php
    require_once( "../../Lib/lib.php" );
    require_once( "../../Lib/db.php" );

    @session_start();

    dbConnect(ConfigFile);

	$db = $GLOBALS['configDataBase']->db;
    mysqli_select_db($GLOBALS['ligacao'], $db);


    $follow_state = $_GET['follow'];
    $idUser = $_GET['user'];

    if($follow_state == 0){
        $query_follower = "DELETE FROM `followers` where `idFollower` = ".$_SESSION['id']. " and `idIsFollowed` = $idUser";
    } else{
        $query_follower = "INSERT INTO `followers` (`idFollower`, `idIsFollowed`) VALUES (".$_SESSION['id'].", $idUser)";
    }
    mysqli_query($GLOBALS['ligacao'], $query_follower);


    $flags[] = FILTER_NULL_ON_FAILURE;

    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);
    $serverPort = 80;
    $name = webAppName();
    $baseUrl = "http://" . $serverName . ":" . $serverPort;
    $baseNextUrl = $baseUrl . $name;
    $nextUrl = "profilePage.php?user=$idUser";

    header( "Location: " . $baseNextUrl . $nextUrl );
?>