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

	$userRole = getRole($_SESSION['id']);

	dbConnect(ConfigFile);

	$db = $GLOBALS['configDataBase']->db;

	mysqli_select_db($GLOBALS['ligacao'], $db);

	$idCat = $_GET['idCat'];

	$query_query_posts = "SELECT `rss-posts`.`pubDate`, `post-images`.`id`, `rss-posts`.`description`, `rss-posts`.`idUser`, `rss-posts`.`idPost`, `rss-posts`.`visibility`
		FROM `post-categories`
		INNER JOIN `rss-posts` ON `post-categories`.`idPost` = `rss-posts`.`idPost`
		INNER JOIN `post-images` ON `rss-posts`.`idImage` = `post-images`.`id` where `post-categories`.`idCat` = ".$idCat;

	$result_query_posts = mysqli_query($GLOBALS['ligacao'], $query_query_posts);

?>
<head>
    <link rel="stylesheet" type="text/css" href="../../Styles/style_category.css">
    <title>Wall-e-gram categoria x</title>
</head>
<body>
    
	<div class="row">
		<div class="column-posts">
		<?php
			while ($cat_info = mysqli_fetch_array($result_query_posts)) {
				if( !($userRole == "guest" && $cat_info['visibility'] == 0) ){
					$idUser = $cat_info['idUser'];

					$query_user = "SELECT * FROM `auth-basic` where `idUser` = ".$idUser;
					$result_user = mysqli_query($GLOBALS['ligacao'], $query_user);
					$usersData = mysqli_fetch_array($result_user);

					$userName = $usersData['name'];	
					
					$idImage = $cat_info['id'];
					$description = $cat_info['description'];
					$idPost = $cat_info['idPost'];
					$pubDate = $cat_info['pubDate'];
		?>
			<div id="instacard" class="instacard">
				<div id="header" class="instacard-header">
					<img src="../../images/profile_icon.png" class="instacard-profile-image">
					<a style="text-decoration: none;" href="profilePage.php?user=<?php echo $idUser ?>"><span class="instacard-profile-name"><?php echo $userName ?></span></a>
				</div>
				<div id="image">
					<?php echo "<img class='instacard-image' src=\"getFileContents.php?id=$idImage\">\n"; ?>
				</div>
				<div id="footer" class="footer">
					<div id="actions" style="font-size: 0.75rem;">
						<i onClick="alert('This is a premium feature, buy it!')" class="far fa-heart fa-2x instacard-like-icon"></i>
						<i onclick="showComments('post-<?php echo $idPost ?>', 'p-post-<?php echo $idPost ?>');" class="far fa-comment fa-2x instacard-comment-icon"></i>
						<span id="likes" class="instacard-likes"><?php echo $pubDate ?></span>
					</div>
					<div id="description" class="instacard-description">
						<span class="instacard-description-profile"><?php echo $userName ?>: </span>
						<span class="instacard-description-body"><?php echo $description ?></span>
						<?php
							$query_get_categories = "SELECT `categories`.`name`, `categories`.`idCat` from `categories`
								inner join `post-categories`
								on `post-categories`.`idCat` = `categories`.`idCat` where `post-categories`.`idPost` = $idPost";

							
							$result_categories = mysqli_query($GLOBALS['ligacao'], $query_get_categories);

							while($categories = mysqli_fetch_array($result_categories)){
						?>
							<a style="text-decoration:none; color: black; font-weight: 500;" href="categoryPage.php?idCat=<?php echo $categories['idCat'] ?>"><span>#<?php echo $categories['name'] ?></span></a>
						<?php	
							}
							
						?>
					</div>
					<div class="comments">
						<div style="margin: 15px;">
							<span style="cursor: pointer;" id="p-post-<?php echo $idPost ?>" onclick="showComments('post-<?php echo $idPost ?>', 'p-post-<?php echo $idPost ?>');">See all comments</span>
						</div>
						<div id="post-<?php echo $idPost ?>" class="instacard-comments">
						<?php
							if($_SESSION['id'] == 0){
								echo "<p style='color: #8c8c8c;'>Create an <a style='text-decoration: none; font-weight: 500; color: black;' href='formRegister.php'>account</a> to be able to comment!</p>";
							}
							else{
						?>
							<form enctype="multipart/form-data"
								action="processFormAddComment.php"
								method="POST"
								name="FormComment">

								<textarea class="input-comment" name="comment-content" placeholder="Insert your comment here"></textarea>
								<input style="display: none" name="idPost" value="<?php echo $idPost ?>"/>
								<input class="input-comment-btn" type="submit" value="Submit">
							</form>
						<?php
							}

							$query_comments = "SELECT `auth-basic`.`idUser`, `auth-basic`.`name`, `post-comments`.`content`, `post-comments`.`pubDate`
							FROM `auth-basic`
							INNER JOIN `post-comments` ON `auth-basic`.`idUser`=`post-comments`.`idUser` where `post-comments`.`idPost` = ".$idPost;

							$resultComments = mysqli_query($GLOBALS['ligacao'], $query_comments);

							while ($comment_info = mysqli_fetch_array($resultComments)) {

						?>
								<div class="instacard-comment">
									<a style="text-decoration: none; color: black; font-weight: 500;" href="profilePage.php?user=<?php echo $comment_info['idUser'] ?>"><span class="instacard-comment-profile"><?php echo $comment_info['name'] ?>:</span></a>
									<span class="instacard-comment-body"><?php echo $comment_info['content'] ?></span>
									<span style="color: #bcbcbc; margin-left: 5px;"><?php echo $comment_info['pubDate'] ?></span>
								</div>
						<?php
							}
						?>
							
						</div>
					</div>
				</div>
			</div>
			<?php
					}
				}
				@mysqli_free_result($result_user);
				@mysqli_free_result($resultComments);
				@mysqli_free_result($result_query_posts);
	
			?>
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
			<h2>Category: #<?php echo $array_cat[$idCat]?></h2>
			<hr style="margin-right: 25px;">
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

    
    <script>
        function showComments(id, idp){
            if(document.getElementById(id).style.display === 'none'){
                document.getElementById(id).style.display = 'block';
                document.getElementById(idp).innerHTML = 'Hide comments';
            }
            else if(document.getElementById(id).style.display === 'block'){
                document.getElementById(id).style.display = 'none';
                document.getElementById(idp).innerHTML = 'See all comments';
            }
            else{
                document.getElementById(id).style.display = 'block';
                document.getElementById(idp).innerHTML = 'Hide comments';
            }
        }
    </script>
	<script src="../../scripts/script.js"></script>
</body>
</html>