<!DOCTYPE html>
<?php
    require_once( "../../Lib/lib.php" );

    @session_start();
    
    $flags[] = FILTER_NULL_ON_FAILURE;
    
    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

    $serverPortSSL = 443;
    $serverPort = 80;

    $name = webAppName();

    $nextUrl = "https://" . $serverName . ":" . $serverPortSSL . $name . "processFormLogin.php";
    #$nextUrl = "http://" . $serverName . ":" . $serverPort . $name . "processFormLogin.php";
?>
<html>
    <head>
        <title>Wall-e-gram Login</title>
        <link rel="stylesheet" type="text/css" href="../../Styles/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Salsa&display=swap" rel="stylesheet">
    </head>
	
    <body>
        <div class="container">
            <div class="page">
                <img src="../../images/official_logo.png" class="logo" />
                <form action="<?php echo $nextUrl ?>" method="POST">
                    <input type="text" name="username" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
					<input id="btn_" type="submit" value="Log in">
                    <div class="option">or</div>
                </form>

                <!-- Sign up -->
				  <div class="sign-up">
					<span>Don't have an account?</span><a href="formRegister.php">Sign up</a>
				  </div>
				  <!-- Log in as Guest -->
				  <div class="guest">
					<span>Log in as</span><a onclick="LogGuest();" href="homePage.php">guest</a>
				  </div>
            </div>
        </div>
		<footer>
			<span class="copyright">&copy; 2021 WALL-E-GRAM</span>
		</footer>
    </body>

    <script>
        function LogGuest(){
            <?php
                $_SESSION['id'] = 0;
                $_SESSION['username'] = "guest";
            ?>
        }
    </script>
</html>