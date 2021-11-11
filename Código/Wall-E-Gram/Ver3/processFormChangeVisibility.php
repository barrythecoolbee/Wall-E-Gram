<?php
    require_once( "../../Lib/lib.php" );
    require_once( "../../Lib/db.php" );

    @session_start();

    dbConnect(ConfigFile);

	$db = $GLOBALS['configDataBase']->db;
    mysqli_select_db($GLOBALS['ligacao'], $db);


    $isVisible = $_GET['visibility'];

    $idPost = $_GET['idPost'];

    $query_update_visibility = "UPDATE `rss-posts` SET `visibility` = $isVisible where `idPost` = $idPost";
    mysqli_query($GLOBALS['ligacao'], $query_update_visibility);

    $flags[] = FILTER_NULL_ON_FAILURE;

    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);
    $serverPort = 80;
    $name = webAppName();
    $baseUrl = "http://" . $serverName . ":" . $serverPort;
    $baseNextUrl = $baseUrl . $name;
    $nextUrl = "postPage.php?idPost=$idPost";

    header( "Location: " . $baseNextUrl . $nextUrl );
?>