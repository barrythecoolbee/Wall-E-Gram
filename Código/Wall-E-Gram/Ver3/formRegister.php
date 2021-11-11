<?php
    require_once( "../../Lib/lib.php" );
    
    $flags[] = FILTER_NULL_ON_FAILURE;
    
    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

    $serverPortSSL = 443;
    $serverPort = 80;

    $name = webAppName();

    $nextUrl = "https://" . $serverName . ":" . $serverPortSSL . $name . "processFormRegister.php";
    #$nextUrl = "http://" . $serverName . ":" . $serverPort . $name . "processFormLogin.php";
?>
<html>
    <head>
        <title>Wall-e-gram Register</title>
        <link rel="stylesheet" type="text/css" href="../../Styles/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Salsa&display=swap" rel="stylesheet">
        <script type="text/javascript" src="../../scripts/forms.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="page">
                <img src="../../images/official_logo.png" class="logo" />
                <form enctype="multipart/form-data" name="FormRegister" action="<?php echo $nextUrl ?>" onsubmit="return FormRegisterValidator(this)" method="POST">
                    <input type="text" name="username" placeholder="Username">
                    <input type="email" name="email" placeholder="E-mail">
					<input type="password" name="password" placeholder="Password">
                    <input type="password" name="rePassword" placeholder="Repeat Password">
					<br>
					
					<img style="float: left" src="captchaImage.php"/><br>

					<span class="digitCode" for="captcha">Digit Code: 
						<input style="width: 184px" type="text" name="captcha" id="captcha" <?php echo true; ?>>
					</span>

					
					
					<?php
					
                    @session_start();
					$captcha = @$_GET['captcha'];

					if(!json_decode($captcha) && $captcha != null){

						?>
					<label style='color: red'> O Captcha inserido está incorreto </label> <br>
						<?php

					}

					?>
					<br>
					<input id="btn_" type="submit" name="Submit" value="Create Account">
                </form>
            </div>
        </div>
		<footer>
			<span class="copyright">&copy; 2021 WALL-E-GRAM</span>
		</footer>
    </body>
</html>