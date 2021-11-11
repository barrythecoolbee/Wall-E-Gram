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

    $search_word = $_GET['search-input'];

	$db = $GLOBALS['configDataBase']->db;

	mysqli_select_db($GLOBALS['ligacao'], $db);

    $query_count_users = "SELECT count(`name`) as countName
        FROM `auth-basic`
        WHERE `name` LIKE '%$search_word%';";

	$result_count_user = mysqli_query($GLOBALS['ligacao'], $query_count_users);

    $query_count_cat = "SELECT count(`name`) as countCat
        FROM `categories`
        WHERE `name` LIKE '%$search_word%';";

	$result_count_cat = mysqli_query($GLOBALS['ligacao'], $query_count_cat);

    $query_search_user = "SELECT `name`, `idUser`
        FROM `auth-basic`
        WHERE `name` LIKE '%$search_word%';";

	$result_search_user = mysqli_query($GLOBALS['ligacao'], $query_search_user);


    $query_search_categories = "SELECT `name`, `idCat`
        FROM `categories`
        WHERE `name` LIKE '%$search_word%';";
    $result_search_categories = mysqli_query($GLOBALS['ligacao'], $query_search_categories);

?>
<head>
    <link rel="stylesheet" type="text/css" href="../../Styles/style_search.css">
    <title>Wall-e-gram página search</title>
</head>
<body>
    
    <div class="show-results">
        <h1>Showing Results for "<?php echo $search_word ?>":</h1>
    </div>

    <div id="instacard" class="instacard">

        <?php

            $counter_user = mysqli_fetch_array($result_count_user);
            $counter_cat = mysqli_fetch_array($result_count_cat);
            if($counter_user['countName'] == 0 && $counter_cat['countCat'] == 0){
        ?> 
            <h3 style="text-align: center;">No results found :( try another word!</h1>
        <?php
            }else{

            while($user_result = mysqli_fetch_array($result_search_user)){
        ?>
            <div style="margin: 20px;">
                <span><strong><?php echo $user_result['name'] ?></strong> - User</span>
                <button onclick="location.href = 'profilePage.php?user=<?php echo $user_result['idUser'] ?>';" class="visit-btn">Visit</button>
            </div>
            <hr>
        <?php
            }
            while($categories_result = mysqli_fetch_array($result_search_categories)){
        ?>
            <div style="margin: 20px;">
                <span><strong>#<?php echo $categories_result['name'] ?></strong> - Category</span>
                <button onclick="location.href = 'categoryPage.php?idCat=<?php echo $categories_result['idCat'] ?>';" class="visit-btn">Visit</button>
            </div>
            <hr>
        <?php
            }
        }

        @mysqli_free_result($result_count_user);
        @mysqli_free_result($result_count_cat);
        @mysqli_free_result($result_search_user);
        @mysqli_free_result($result_search_categories);
        dbDisconnect();
        ?>
	</div>
	<script src="../../scripts/script.js"></script>
</body>
</html>