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
	$query_posts = "SELECT * FROM `$db`.`rss-posts`";
	$result_posts = mysqli_query($GLOBALS['ligacao'], $query_posts);

?>
<head>
    <link rel="stylesheet" type="text/css" href="../../Styles/style_home.css">
    <title>Wall-e-gram página inicial</title>
</head>
<body>

<?php
	while ($posts_info = mysqli_fetch_array($result_posts)) {
		if( !($userRole == "guest" && $posts_info['visibility'] == 0) ){
		
			$query_user = "SELECT * FROM `auth-basic` where `idUser` = ".$posts_info['idUser'];
			$result_user = mysqli_query($GLOBALS['ligacao'], $query_user);
			$query_image = "SELECT `id`, `fileName` FROM `post-images` where `id` = ".$posts_info['idImage'];
			$result_image = mysqli_query($GLOBALS['ligacao'], $query_image);

			$usersData = mysqli_fetch_array($result_user);
			$userName = $usersData['name'];

			$imageData = mysqli_fetch_array($result_image);
			$idImage = $imageData['id'];

			$description = $posts_info['description'];
			$idPost = $posts_info['idPost'];

			$idUser = $usersData['idUser'];
			$pubDate = $posts_info['pubDate'];
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
	@mysqli_free_result($result_image);
	@mysqli_free_result($resultComments);
	@mysqli_free_result($result_posts);
	dbDisconnect();
?>
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