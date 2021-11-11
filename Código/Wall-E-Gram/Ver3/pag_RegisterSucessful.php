<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Register Using PHP</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" typr="text/css" href="../../Styles/GlobalStyle.css">
        <script type="text/javascript" src="../scripts/forms.js">
    </script>
    </head>
    
    <body >
        <p>An email was sent to: </p>
        <?php
            @session_start();
            echo $_SESSION['email'];
        ?>
        <p>Please confirm your registration :)</p>
        
    </body>
</html>