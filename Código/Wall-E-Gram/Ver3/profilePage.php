<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../../Styles/style_profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Salsa&display=swap" rel="stylesheet">
    <title>Wall-e-gram Perfil</title>
</head>
<body>
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
    // Read from the data base the list of the files
    $id_user = $_GET['user'];
    $userPageRole = getRole($id_user);

    dbConnect(ConfigFile);
    mysqli_select_db( $GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);


    $query_images = "SELECT `id`, `fileName`, `idPost`, `visibility` FROM `post-images` INNER JOIN `rss-posts` ON `post-images`.`id`=`rss-posts`.`idImage` where `rss-posts`.`idUser` = ".$id_user;
    $result_images = mysqli_query($GLOBALS['ligacao'], $query_images);

    $query_user = "SELECT * FROM `auth-basic` where `idUser` = ".$id_user;
    $result_user = mysqli_query($GLOBALS['ligacao'], $query_user);
    if(mysqli_num_rows($result_user) == 0){
        echo "<h1>User does not exist!</h1>";
    }
    else if ($_GET['user'] == 0) {
        echo "<h1>Guests don't have an account!</h1>";
        echo "<span>Create an account </span><a href='formRegister.php'>here</a>";
    }
    else{
        $user = mysqli_fetch_array($result_user);

        $name = $user['name'];
        $email = $user['email'];
        $description = $user['description'];

        $query_posts = "SELECT COUNT(`idPost`) as num_posts FROM `rss-posts` WHERE `idUser` = ".$id_user;
        $result_posts = mysqli_query($GLOBALS['ligacao'], $query_posts);
        $posts = mysqli_fetch_array($result_posts);
        $num_posts = $posts['num_posts'];

        $query_followers = "SELECT * FROM `followers` where `idFollower` = ". $_SESSION['id'] . " and `idIsFollowed` = ". $_GET['user'];
        $result_followers = mysqli_query($GLOBALS['ligacao'], $query_followers);

        $already_follows = true;
        if ( $result_followers==false || mysqli_num_rows($result_followers)==0 ) {
            $already_follows = false;
        }

        $query_count_followers = "SELECT COUNT(`idIsFollowed`) as numFollowers FROM `followers` WHERE `idIsFollowed` = ".$id_user;
        $result_count_followers = mysqli_query($GLOBALS['ligacao'], $query_count_followers);
        $count_followers = mysqli_fetch_array($result_count_followers);
        $num_followers = $count_followers['numFollowers'];

        $query_count_following = "SELECT COUNT(`idFollower`) as numFollowing FROM `followers` WHERE `idFollower` = ".$id_user;
        $result_count_following = mysqli_query($GLOBALS['ligacao'], $query_count_following);
        $count_following = mysqli_fetch_array($result_count_following);
        $num_following = $count_following['numFollowing'];
?>
    
    <div class="container">
        <section class="bio">
            <div class="profile-photo">
                <img src="../../images/profile_icon.png" alt="profile-photo">
            </div>
            <div class="profile-info">
                <p class="name"><?php echo $name ?> </p>
                <?php
                    if($_SESSION['id'] == $id_user){
                ?>
                        <label class="edit"> <i onClick="alert('This is a premium feature, buy it!')" class="fas fa-pencil-alt"></i> </label>
                <?php
                    }
                    else if($_SESSION['id'] != 0){
                        if($already_follows){
                ?>
                            <button onclick="location.href = 'processFormFollowers.php?user=<?php echo $_GET['user'] ?>&follow=0';" class="follow-btn" style="width: 5em;">Unfollow</button>
                <?php
                        } else{
                ?>
                            <button onclick="location.href = 'processFormFollowers.php?user=<?php echo $_GET['user'] ?>&follow=1';" class="follow-btn">Follow</button>
                <?php
                        }
                    }
                ?>
                
                <label style="float: right;"> 
                    <label > <strong><?php echo $num_posts ?> </strong> posts</label> 
                    <label class="edit"><a style="text-decoration: none; color: black;" href="followersResult.php?user=<?php echo $_GET['user'] ?>"><strong><?php echo $num_followers ?></strong> followers</a></label>
                    <label class="edit"><a style="text-decoration: none; color: black;" href="followingResult.php?user=<?php echo $_GET['user'] ?>"> following <strong><?php echo $num_following ?></strong></a></label>
                </label>
                <br>
               <p><?php echo $email ?></p>
               <br>
               <p><?php echo $description ?></p>
            </div>
        </section>

        <?php
            if($_SESSION['id'] == $id_user && ($userRole == "sympathizer" || $userRole == "manager")){
        ?>
                <a href="uploadPage.php"><img class="add-photo" src="../../images/add_icon.png" alt="add"></a>
        <?php
            } else if($userRole == "user"){
        ?>
                <a href="processFormChangeRole.php" style="text-decoration: none;"><button class="sympathizer-btn">Buy Sympathizer role!</button></a>
        <?php
            } else if($_SESSION['id'] != $id_user && $userRole == "manager" && $userPageRole == "sympathizer"){
        ?>
                <a href="processFormChangeRole.php?idUser=<?php echo $id_user ?>" style="text-decoration: none;"><button class="sympathizer-btn">Turn user into Manager!</button></a>
        <?php
            }
        ?>
    </div>
	<main>
        <section class="photosGrid">
            <?php

                while ($imageData = mysqli_fetch_array($result_images)) {
                    if( !($userRole == "guest" && $imageData['visibility'] == 0) ){
                        $id = $imageData['id'];
                        $idPost = $imageData['idPost'];

                        $target = "<img src=\"getFileContents.php?id=$id\">";
                        echo "<a title='Photo 1' class='photosGrid__Photo' href='postPage.php?idPost=$idPost'>$target</a>\n";
                    }

                }

                @mysqli_free_result($result_images);
                @mysqli_free_result($result_user);
                @mysqli_free_result($result_posts);
                dbDisconnect();
            ?>
		</section>
    </main>
<?php
    }
    
?>
	<script src="../../scripts/script.js"></script>
</body>
</html>