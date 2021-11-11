<!DOCTYPE html>
<html lang="en">
<?php
  
  if ( !isset($_SESSION) ) {
      session_start();
    }
    
    require_once( "../../Lib/lib.php" );
    require_once( "../../Lib/db.php" );
    require_once( "../../Lib/lib-coords.php" );

    include_once( "config.php" );
    
    include_once( "ensureAuth.php" );
    include_once( "header.php" );

    $name = webAppName();

    $dateNow = date('F d Y');

	dbConnect(ConfigFile);

	$db = $GLOBALS['configDataBase']->db;

	mysqli_select_db($GLOBALS['ligacao'], $db);

    $query_following = "SELECT * FROM `followers`
        INNER JOIN `auth-basic` ON `auth-basic`.`idUser` = `followers`.`idIsFollowed`
        where `followers`.`idFollower` = ". $_GET['user'] . "";
    $result_following = mysqli_query($GLOBALS['ligacao'], $query_following);

    $query_username = "SELECT `auth-basic`.`name` FROM `auth-basic` where `idUser` = ". $_GET['user'];
    $result_username = mysqli_query($GLOBALS['ligacao'], $query_username);
    $username = mysqli_fetch_array($result_username);

?>
<head>
    <link rel="stylesheet" type="text/css" href="../../Styles/style_search.css">
    <title>Wall-e-gram following</title>
</head>
<body>
    
    <div class="show-results">
        <h1><?php echo $username['name'] ?> is Following:</h1>
    </div>

    <div id="instacard" class="instacard">

        <?php
            if ( $result_following==false || mysqli_num_rows($result_following)==0 ) {
        ?> 
                <h3 style="text-align: center;">This user is not following anyone!</h1>
        <?php
            }else{

            while($following = mysqli_fetch_array($result_following)){
        ?>
            <div style="margin: 20px;">
                <span><strong><?php echo $following['name'] ?></strong></span>
                <button onclick="location.href = 'profilePage.php?user=<?php echo $following['idUser'] ?>';" class="visit-btn">Visit</button>
            </div>
            <hr>
        <?php
                }
            }

            @mysqli_free_result($result_following);
            dbDisconnect();
        ?>
	</div>
	<script src="../../scripts/script.js"></script>
</body>
</html>