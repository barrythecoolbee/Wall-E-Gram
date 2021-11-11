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

    $query_categories = "SELECT * FROM `categories`";
	$result_categories = mysqli_query($GLOBALS['ligacao'], $query_categories);

?>
<head>
    <link rel="stylesheet" type="text/css" href="../../Styles/style_categories.css">
    <title>Categories Page</title>
</head>
<body>
	
    <div class="row">
        <div class="column-main">
            <main>
                <section class="photosGrid">
                <?php
                
                    while ($categories_info = mysqli_fetch_array($result_categories)) {
                        $idCat = $categories_info['idCat'];
                        $catName = $categories_info['name'];

                        $query_catImage = "SELECT `post-images`.`id`
                            FROM `post-categories`
                            INNER JOIN `rss-posts` ON `post-categories`.`idPost` = `rss-posts`.`idPost`
                            INNER JOIN `post-images` ON `rss-posts`.`idImage` = `post-images`.`id` where `post-categories`.`idCat` = ".$idCat;

                        
                        $result_catImage = mysqli_query($GLOBALS['ligacao'], $query_catImage);
                        $catImage = mysqli_fetch_array($result_catImage);

                        $imageId = $catImage['id'];
                
                ?>
                    <div class="container">
                        <a href="categoryPage.php?idCat=<?php echo $idCat ?>" class="photosGrid__Photo">
                            <?php echo "<img src=\"getFileContents.php?id=$imageId\">\n"; ?>
                            <div class="middle">
                                <div class="text"><?php echo $catName ?></div>
                            </div>
                        </a>
                    </div>

                <?php
                    }
                    mysqli_free_result($result_categories);
                    mysqli_free_result($result_catImage);
                ?>
                </section>
            </main>
        </div>
        <div class="column-categories">
			<?php
				$query_category_list = "SELECT * FROM `categories`";
				$result_query_catlist = mysqli_query($GLOBALS['ligacao'], $query_category_list);
				$array_cat = [];

				while ($cat_list = mysqli_fetch_array($result_query_catlist)) {
					$array_cat[$cat_list['idCat']] = $cat_list['name'];
					
				}
				
				$rand_keys = array_rand($array_cat, 3);
				
			?>
            <h3>Suggested Categories</h3>
			<?php
				
				for($i = 0; $i < 3; $i++){
					$idCatSuggested = $array_cat[$rand_keys[$i]];
			?>
            <div class="category">
                <a href="categoryPage.php?idCat=<?php echo $rand_keys[$i]?>"><strong>#<?php echo $idCatSuggested ?></strong></a>
            </div>

			<?php
				}
			
				mysqli_free_result($result_query_catlist);
				dbDisconnect();
			?>

        </div>
    </div>
	<script src="../../scripts/script.js"></script>
</body>
</html>