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

  ?>
<head>
    <link rel="stylesheet" type="text/css" href="../../Styles/style_upload.css">
	<link href="https://fonts.googleapis.com/css2?family=Salsa&display=swap" rel="stylesheet">
    <title>Upload Page</title>
</head>
<body>
    <?php

        if ($_SESSION['id'] == 0) {
            echo "<h1>Guests cannot upload!</h1>";
            echo "<span>Create an account </span><a href='formRegister.php'>here</a> to do so!";
        }
        else if($userRole == "user"){
            echo "<h1>Become a SYMPATHIZER to upload contents!</h1>";
        }
        else{

    ?>
    <form 
        enctype="multipart/form-data"
        action="processFormUpload.php"
        method="POST"
        name="FormUpload">
        
        <div class="container2">
            <div class="grid-container">
                <div class="item2">
                    <div class="file-chose">
                        <div class="container">
                            <div class="wrapper">
                                <div class="image">
                                    <img class="profile-upload" src="" alt="">
                                </div>
                                <div class="content">
                                    <div class="icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <div class="text">No file chosen</div>
                                </div>
                                <div id="cancel-btn">
                                    <i class="fas fa-times"></i>
                                </div>
                                <div class="file-name">File name here</div>
                            </div>
                            <input id="default-btn" type="file" name="userFile" accept=".jpg,.jpeg,.png" hidden required>
                            <button type="button" onclick="defaultBtnActive()" id="custom-btn">Choose File</button>
                        </div>
                    </div>
                </div>
                <div class="item4">
                    <div class="description">Description</div>
                    <div class="dscr-input">
                        <textarea id="description-ta" name="description-ta" required></textarea>
                    </div>

                    <label class="switch-text">Private</label>
                    <label class="switch">
                        
                        <input type="checkbox" id="switchValue" name="visibility" checked>
                        <span class="slider round"></span>
                        
                    </label>
                    <label class="switch-text">Public</label>

                </div>
                <div class="item5">
                    <div class="categories">Categories</div>
                    <div class="cat-input">
                        <textarea id="categories-ta" name="categories-ta" placeholder="#put#your#categories#here" required></textarea>
                    </div>
                </div>
                <div class="item6">
                    <button type="submit" id="publish-custom-btn">Share</button>
                </div>
            </div>
        </div>
        
    </form>
    <?php
        }
    ?>
    
    <script>
        const wrapper = document.querySelector(".wrapper");
        const fileName = document.querySelector(".file-name");
        const cancelBtn = document.querySelector("#cancel-btn");
        const defaultBtn = document.querySelector("#default-btn");
        const customBtn = document.querySelector("custom-btn");
        const img = document.querySelector(".profile-upload");
        const chooseFileIcon = document.querySelector(".icon");
        const chooseFileText = document.querySelector(".text");
		const submitButton = document.querySelector("#publish-custom-btn");
        let regExp = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\,\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;

        function defaultBtnActive(){
            defaultBtn.click();
        }

        defaultBtn.addEventListener("change", function(){
            if(validateFileType()){
                const file= this.files[0];
                if(file){
                    const reader = new FileReader();
                    reader.onload = function(){
                        const result = reader.result;
                        img.src= result;
                        img.style.display = "block";
                        chooseFileIcon.style.display = "none";
                        chooseFileText.style.display = "none";
                        wrapper.classList.add("active");
                    }
                    cancelBtn.addEventListener("click", function(){
                        img.src = "";
                        chooseFileIcon.style.display = "block";
                        chooseFileText.style.display = "block";
                        img.style.display = "none";
                        wrapper.classList.remove("active");
                    });
                    reader.readAsDataURL(file);
                }
                if(this.value){
                    let valueStore = this.value.match(regExp);
                    fileName.textContent = valueStore;
                }
            }
            else{
                document.getElementById("default-btn").value = "";
            }
        });

        submitButton.addEventListener("click", function(){
            if(document.getElementById("default-btn").value == ""){
                alert("Please select a valid image!");
                return false;
            }
        });

        function validateFileType(){
            var fileName = document.getElementById("default-btn").value;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
                return true;
            }else{
                alert("Only jpg/jpeg and png files are allowed!");
                return false;
            }              
        }


    </script>
    <script src="../../scripts/script.js"></script>
</body>
</html>