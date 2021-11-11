<?php
    require_once( "../../Lib/lib.php" );
    require_once( "../../Lib/db.php" );

    @session_start();
    
    $userRole = getRole($_SESSION['id']);

    dbConnect(ConfigFile);

    if($userRole == "manager"){
        $idUser = $_GET['idUser'];
    }
    else{
        $idUser = $_SESSION['id'];
    }

	$db = $GLOBALS['configDataBase']->db;
    mysqli_select_db($GLOBALS['ligacao'], $db);

    $query_get_role = "SELECT `idRole` FROM `auth-permissions` where `idUser` = ".$idUser;
	$result_get_role = mysqli_query($GLOBALS['ligacao'], $query_get_role);
    $role_info = mysqli_fetch_array($result_get_role);

    $idRole = $role_info['idRole'];
    $idRole = $idRole - 1;

    $query_change_role = "UPDATE `auth-permissions` SET `idRole` = ".$idRole . " where `idUser` = ".$idUser;
    $result_change_role = mysqli_query($GLOBALS['ligacao'], $query_change_role);

    $flags[] = FILTER_NULL_ON_FAILURE;

    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);
    $serverPort = 80;
    $name = webAppName();
    $baseUrl = "http://" . $serverName . ":" . $serverPort;
    $baseNextUrl = $baseUrl . $name;
    if($userRole == "manager"){
        $nextUrl = "homePage.php";
    }
    else{
        $nextUrl = "formLogin.php";
        @session_destroy();
    }

    header( "Location: " . $baseNextUrl . $nextUrl );
?>