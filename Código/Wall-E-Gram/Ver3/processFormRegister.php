<?php
    require_once( "../../Lib/lib.php" );
    require_once( "../../Lib/db.php" );
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
    $flags[] = FILTER_NULL_ON_FAILURE;
    
    $filterUsername = "/^(?=.*[a-zA-Z])[a-zA-Z0-9_]{5,12}$/";
    $filterPass = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/";
    $filterEmail = "/^([a-z0-9_\.\-]{4,30})+\@(([a-z0-9\-]{2,7})+\.)+([a-z0-9]{2,4})$/";
    
    $username = filter_input( $_INPUT_METHOD, 'username', FILTER_SANITIZE_STRING, $flags);
    $password = filter_input( $_INPUT_METHOD, 'password', FILTER_SANITIZE_STRING, $flags);
    $rePassword = filter_input( $_INPUT_METHOD, 'rePassword', FILTER_SANITIZE_STRING, $flags);
    $email = filter_input( $_INPUT_METHOD, 'email', FILTER_SANITIZE_STRING, $flags);
    
    $validUser = false;
    $validPassword = false;
    $validRePassword = false;
    $validEmail = false;
    
    if ( isset($username) ) {
        if(preg_match($filterUsername, $username) == 1){
            $validUser = true;
        }
    }
    
    if ( isset($password) ) {
        if(preg_match($filterPass, $password) == 1){
            $validPassword = true;
        }
    }
    
    if ( isset($rePassword) ) {
        if($password == $rePassword){
            $validRePassword = true;
        }
    }
  
    if ( isset($email) ) {
        if(preg_match($filterEmail, $email) == 1){
            $validEmail = true;
        }
    }

    
    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

    $serverPort = 80;

    $name = webAppName();

    $baseUrl = "http://" . $serverName . ":" . $serverPort;

    $baseNextUrl = $baseUrl . $name;
    
    $nextUrl = "formRegister.php";
    
    
    header( 'Content-Type: text/html; charset=utf-8' );
    
    $validCaptcha = false;
    
    if ($_SESSION['captcha'] == $_POST['captcha']) {
        //echo "<h1>Ok - Code is correct</h1>";
        $validCaptcha = true;
    }
    else{
        $nextUrl = "formRegister.php?captcha=false";
    }

    
    if($validUser && $validPassword && $validRePassword && $validEmail && $validCaptcha){

        $user = existUserField("name",$username);
        $mail = existUserField("email",$email);
        
        
        if ( !$user && !$mail) {

            addUserToDatabase($username, $password, $email);
            
            //adicionar à tabela challenge            
            addUserToDatabase(md5($username), date("Y-m-d H:i:s"), null, "challenge");

            //enviar email de confirmação
            $nextUrl = "processFormSendEmailUsingLib.php";
            
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;            

        } else {
            $nextUrl = "formRegister.php";
        }
    
    }

    header( "Location: " . $baseNextUrl . $nextUrl );
?>

<!--<p> Acabou o Registo </p>-->


