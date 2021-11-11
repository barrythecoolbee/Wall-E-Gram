<?php
if ( !isset($_SESSION) ) {
      session_start();
    }
    
require_once( "../../Lib/lib.php" );
require_once( "../../Lib/db.php" );

include_once( "ensureAuth.php" );
//include_once( "auth/header.php" );


// TODO validate input data
$id = $_GET['id'];

// Read from the data base details about the file
$fileDetails = getFileDetails($id);

$fileName = $fileDetails['fileName'];
$mimeFileName = $fileDetails['mimeFileName'];
$typeFileName = $fileDetails['typeFileName'];

$pathParts = pathinfo( $fileName );
$fileNameForDownload = $pathParts[ "basename" ];

// Pass image contents to the browser
$fileHandler = fopen($fileName, 'rb');

header("Content-Type: $mimeFileName/$typeFileName");
header("Content-Length: " . filesize($fileName));

header( "Content-Transfer-Encoding: Binary" );
header( "Content-Disposition: attachment; filename=\"" . $fileNameForDownload . "\""); 

fpassthru($fileHandler);
fclose($fileHandler);
?>