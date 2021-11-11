<?php
    require_once( "../../Lib/db.php" );
    require_once( "../../Lib/lib.php" );
    
    @session_start();

    $flags[] = FILTER_NULL_ON_FAILURE;
    
    $method = filter_input( INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING, $flags);
     
    if ( $method=='POST') {
        $_INPUT_METHOD = INPUT_POST;
    } elseif ( $method=='GET' ) {
        $_INPUT_METHOD = INPUT_GET;
    }
    else {
        echo "Invalid HTTP method (" . $method . ")";
        exit();
    }
    
    $_idPost = filter_input( $_INPUT_METHOD, 'idPost', FILTER_SANITIZE_STRING, $flags);
    $_comment = filter_input( $_INPUT_METHOD, 'comment-content', FILTER_SANITIZE_STRING, $flags);
    
    $ServerName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);
    $ServerPort = filter_input( INPUT_SERVER, 'SERVER_PORT', FILTER_SANITIZE_STRING, $flags);
    
    if ( $_comment == null ) {
        echo "Missing arguments.";
        exit();
    }
    
    if( $_idPost == null){
        echo "ID null";
        exit();
    }

    $idPost = addslashes($_idPost);
    $comment = addslashes($_comment);

    $name = webAppName();

    dbConnect( ConfigFile );

    $db = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $db);

    $query_insert_comment = "INSERT INTO `$db`.`post-comments`" .
        "(`pubDate`, `content`, `idPost`, `idUser`) values " .
        "( CURDATE(), '$comment', $idPost, ". $_SESSION['id'] ." )";
    
    mysqli_query($GLOBALS['ligacao'], $query_insert_comment);
    
    $link = "http://" . $ServerName . ":" . $ServerPort . $name . "homePage.php";
    dbDisconnect();    
    
    header( "Location: " . $_SERVER['HTTP_REFERER'] );
?>

