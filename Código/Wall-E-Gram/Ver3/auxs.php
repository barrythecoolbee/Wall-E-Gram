<?php

function myOpenImage($imageFile) {

        $pathInfo = pathinfo($imageFile);
        $extension = strtolower($pathInfo['extension']);
        
        echo "<br>openImage($imageFile)\n<br>";

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $img = imagecreatefromjpeg($imageFile);
                echo "<br>openImage($imageFile) is JPEG\n<br>";
                break;
            case 'gif':
                $img = imagecreatefromgif($imageFile);
                echo "<br>openImage($imageFile) is GIF\n<br>";
                break;
            case 'png':
                $img = imagecreatefrompng($imageFile);
                echo "<br>openImage($imageFile) is PNG\n<br>";
                break;
            default:
                $img = false;
                echo "<br>openImage($imageFile) is ???\n<br>";
                break;
        }

        return $img;
    }
