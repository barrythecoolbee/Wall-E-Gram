<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Register Using PHP</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" typr="text/css" href="../../Styles/style_confirmations.css">
        <script type="text/javascript" src="../scripts/forms.js">
    </script>
    </head>
    
    <body >
<?php
    require_once( "../../Lib/lib.php" );
    require_once( "../../Lib/db.php" );

    $hash = $_GET['challenge'];
    //ir à tabela ver o id

    $id = @getParamFromField("idUser", "challenge", $hash);

    if($id != null){  
        
        updateField("active", 1, "idUser", (int)$id);
        
        //adicionar no roles
        addUserToDatabase(3, $id, null, "permissions");
        
        removeLine("challenge", $hash, "challenge");


        ?>  <h1>Registered with success!</h1> 
            <a style="position: absolute; margin: 0; width: 100%; text-align: center" href="formLogin.php">
                <button class="enter-btn">Enter</button>
            </a>
        <?php
        
        //verificar data       ///////Timer
        
        //$registerDate = getParamFromField("registerDate", "challenge", $hash, "challenge");
        /*$dateExpired = $registerDate < date("Y/m/d");
        
        if(!$dateExpired){
            //update Active  
            
            
            
            
        }else{
            echo "O link já expirou";
            removeLine("idUser", $id, "basic");
        }
        
        removeLine("challenge", $hash, "challenge");
         * 
         */
  
    }else{
        ?>
            <h1>Link has expired! Please try again</h1> 
        <?php
    }
?>
    </body>
</html>



