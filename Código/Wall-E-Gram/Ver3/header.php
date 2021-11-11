<?php
    if ( !isset($_SESSION) ) {
      session_start();
    }

    require_once( "../../Lib/lib.php" );
    require_once( "../../Lib/db.php" );

    $user = $_SESSION['username'];
    $id = $_SESSION['id'];
    $userRole = getRole($id);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../../Styles/style_header.css">
        <script src="https://kit.fontawesome.com/d974e5062b.js" crossorigin="anonymous"></script>
    </head>
    
    <body>
        <div class="header">
            <div class="navbar">
                <a href="homePage.php"><img class="brand" src="../../images/official_logo_navbar.png" title="Wall-e-gram"></a>
                <form action="searchResults.php">
                    <div class="wrap-input">
                        <input type="text" placeholder="Search" name="search-input">
                        <i class="fas fa-search icon-search"></i>
                    </div>
                </form>
                <div class="nav-item">
                <?php
                    if($userRole == "sympathizer" || $userRole == "manager"){
                ?>
                    <a href="uploadPage.php"><img src="../../images/icons/add_icon.png" title="Upload"></a>
                <?php
                    }
                ?>
                    <a href="homePage.php"><img src="../../images/icons/rocket_icon.png" title="Home"></a>
                    <a href="categoriesPage.php"><img src="../../images/icons/boot_icon.png" title="Categories"></a>
                    <?php
                        if($userRole == "sympathizer" || $userRole == "manager"){
                    ?>
                    <div class="wrap-item-like">
                        <div class="wrap-like">
                            <img src="../../images/icons/plant_icon.png" title="Notifications" onclick="menuLike()">
                            <div id="triangle-up-like"></div>
                            <div class="menu-like">
                                <div class="item-menu">
                                    <div style="display: flex; align-items: center;">
                                        <div class="profile">
                                            <img src="../../images/profile_pic.jpg" alt="">
                                        </div>
                                        <span class="notification">
                                            <span style="font-weight: bold;">Eva</span>
                                            liked your photo.
                                            <span style="color: #bcbcbc">3 week</span>
                                        </span>
                                    </div>
                                    <div class="profile2">
                                        <img src="../../images/profile_pic.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    
                    <div class="profile">
                        <img src="../../images/profile_icon.png" title="<?php echo $user ?>" onclick="menuProfile()">
                        <div class="menu-profile">
                            <a href="profilePage.php?user=<?php echo $_SESSION['id']?>" style="text-decoration: none; color: black;">
                                <div class="item-menu">
                                    <img src="../../images/menu-profile/1.png" alt="">
                                    <span>Profile</span>
                                </div>
                            </a>
                            <div class="item-menu">
                                <span><?php echo $userRole ?></span>
                            </div>
                            <hr>
                            <div class="item-menu">
                                <a style="text-decoration: none; color: black;" href="logout.php"><span>End Session</span></a>
                            </div>
                            <div id="triangle-up"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
	    <div id="google_translate_element"></div>
        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
            }
        </script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>