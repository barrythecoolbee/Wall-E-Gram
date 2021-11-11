
<?php
    require_once( "../../Lib/lib.php" );
    require_once( "../../Lib/db.php" );
    require_once( "../../Lib/lib-coords.php" );
    require_once( "../../Lib/ImageResize.php" );

    include_once( "config.php" );
    
    require_once( "auxs.php" );

    @session_start();

    // Maximum time allowed for the upload
    set_time_limit( 300 );

    if ( $_FILES['userFile']['error']!=0 ) {
        $msg = showUploadFileError( $_FILES['userFile']['error'] );
        echo "\t\t<p>$msg</p>\n";
        echo "\t\t<p><a href='javascript:history.back()'>Back</a></p>\n";
        echo "\t</body>\n";
        echo "</html>\n";
        die();
    }

    $srcName = $_FILES['userFile']['name'];

    // Read configurations from data base
    $configurations = getConfiguration();
    $dstDir = $configurations['destination'];

    // Destination for the uploaded file
    $src = $_FILES['userFile']['tmp_name'];
    $dst = $dstDir . DIRECTORY_SEPARATOR . $srcName;

    $copyResult = copy($src, $dst);

    if ( $copyResult === false ) {
        $msg = "Could not write '$src' to '$dst'";
        echo "\t\t<p>$msg</p>\n";
        echo "\t\t<p><a href='javascript:history.back()'>Back</a></p>";
        echo "\t</bobdy>\n";
        echo "\t</html>\n";
        die();
    }

    unlink($src);

    $fileInfo = finfo_open(FILEINFO_MIME);

    $fileInfoData = finfo_file($fileInfo, $dst);
    
    $fileTypeComponents = explode( ";", $fileInfoData);

    $mimeTypeFileUploaded = explode("/", $fileTypeComponents[0]);
    $mimeFileName = $mimeTypeFileUploaded[0];
    $typeFileName = $mimeTypeFileUploaded[1];

    if($typeFileName != "jpeg" && $typeFileName != "png" && $typeFileName != "jpg"){
        $msg = "Wrong type of file!";
        echo "\t\t<p>$msg</p>\n";
        echo "\t\t<p><a href='javascript:history.back()'>Back</a></p>";
        echo "\t</bobdy>\n";
        echo "\t</html>\n";
        die();
    }

    $thumbsDir = $dstDir . DIRECTORY_SEPARATOR . "thumbs";
    $pathParts = pathinfo($dst);

    $lat = $lon = "";

    if ( $_POST['description-ta']!=NULL ) {
        $description = addslashes($_POST['description-ta']);
    }
    else {
        $description = "No description available";
    }


    if ( $_POST['categories-ta']!=NULL ) {
        $categories_raw = addslashes($_POST['categories-ta']);
        $splitted = explode("#",$categories_raw);
        $categories = [];
        for($i = 0; $i < count($splitted); $i++){
            if(strlen($splitted[$i]) >= 3){
                array_push($categories, $splitted[$i]);
            }
        }
        
    }
    else {
        $categories_raw = "No categories available";
    }
    
    // 1 É PUBLICO
    // 0 É PRIVADO
    if ( isset($_POST['visibility']) ) {
        $isVisible = 1;
    }
    else {
        $isVisible = 0;
    }

    $width = $configurations['thumbWidth'];
    $height = $configurations['thumbHeight'];

    $imageFileNameAux = $imageMimeFileName = $imageTypeFileName = null;
    $thumbFileNameAux = $thumbMimeFileName = $thumbTypeFileName = null;

    switch ($mimeFileName) {
        case "image":
            $imageFileNameAux = $dst;
            $imageMimeFileName = "image";
            $imageTypeFileName = $typeFileName;

            $thumbFileNameAux = $thumbsDir . DIRECTORY_SEPARATOR . $pathParts['filename'] . "." . $typeFileName;
            $thumbMimeFileName = "image";
            $thumbTypeFileName = $typeFileName;

            $resizeObj = new ImageResize( $dst );
            $resizeObj->resizeImage($width, $height, 'crop');
            $resizeObj->saveImage($thumbFileNameAux, $typeFileName, 100);
            $resizeObj->close();
            break;
    }

    // Write information about file into the data base
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );

    $fileName = addslashes($dst);
    $imageFileName = addslashes($imageFileNameAux);
    $thumbFileName = addslashes($thumbFileNameAux);

    /*
    
    ADICIONAR A IMAGEM À TABELA POST-IMAGES;
    ADICIONAR AS CATEGORIAS NOVAS À TABELA DAS CATEGORIAS;
    ADICIONAR O POST À TABELA RSS-POSTS, COM REFERÊNCIA AO ID DA POST-IMAGES;
    ADICIONAR À TABELA POST-CATEGORIES O ID DO POST E O ID DAS CATEGORIAS;
    
    */

    $query_post_images = 
            "INSERT INTO `$dataBaseName`.`post-images`" .
            "(`fileName`, `mimeFileName`, `typeFileName`, `imageFileName`, `imageMimeFileName`, `imageTypeFileName`) values " .
            "('$fileName', '$mimeFileName', '$typeFileName', '$imageFileName', '$imageMimeFileName', '$imageTypeFileName')";

    mysqli_query( $GLOBALS['ligacao'], $query_post_images );

    $query_rss_posts = 
            "INSERT INTO `$dataBaseName`.`rss-posts`" .
            "(`idUser`, `description`, `pubDate`, `idImage`, `visibility`) values " .
            "(".$_SESSION['id'].", '$description', CURDATE(), ".getLastId("id", "post-images").", $isVisible)";

    mysqli_query( $GLOBALS['ligacao'], $query_rss_posts );

    //VERIFICAR SE JA EXISTE CATEGORIA
    for($j = 0; $j < count($categories); $j++){
        $select_category = "SELECT * FROM `$dataBaseName`.`categories` where `name` = '".$categories[$j] . "'";
        $result = mysqli_query( $GLOBALS['ligacao'], $select_category );
        if ( mysqli_num_rows($result) == 0 ) {
            $query_post_category =
                "INSERT INTO `$dataBaseName`.`categories`" .
                "(`name`) values " .
                "('".$categories[$j]."')";
            
            mysqli_query( $GLOBALS['ligacao'], $query_post_category );
        }

        $select_category_id = "SELECT `idCat` AS idCat FROM `$dataBaseName`.`categories` where `name` = '".$categories[$j] . "'";
        $cat_id = mysqli_query( $GLOBALS['ligacao'], $select_category_id );
        $row = mysqli_fetch_array($cat_id);
        $id_cat = (int)$row['idCat'];

        $query_post_categories = 
                "INSERT INTO `$dataBaseName`.`post-categories`" .
                "(`idCat`, `idPost`) values " .
                "(".(int)$id_cat.", ".getLastId("idPost", "rss-posts").")";
                
        mysqli_query( $GLOBALS['ligacao'], $query_post_categories );
    }

    dbDisconnect();

    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);
    $serverPort = 80;
    $name = webAppName();
    $baseUrl = "http://" . $serverName . ":" . $serverPort;
    $baseNextUrl = $baseUrl . $name;
    
    $nextUrl = "profilePage.php?user=".$_SESSION['id'];

    header( "Location: " . $baseNextUrl . $nextUrl );
?>