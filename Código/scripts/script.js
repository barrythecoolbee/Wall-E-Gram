var menuLikeClick = false;
var menuProfileClick = false;

function menuLike(){
    var element = document.querySelector(".menu-like");
    var element2 = document.querySelector(".menu-profile");
    var element3 = document.getElementById("triangle-up-like");

    if(!menuLikeClick){
        element.classList.add("showMenuLike");
        element2.classList.remove("showMenuProfile");
        element3.style.display = "block";
        menuLikeClick = true;
        menuProfileClick = false;
    }
    else{
        element.classList.remove("showMenuLike");
        element3.style.display = "none";
        menuLikeClick = false;
    }
    
}

function menuProfile(){
    var element = document.querySelector(".menu-profile");
    var element2 = document.querySelector(".menu-like");
    var element3 = document.getElementById("triangle-up-like");

    if(!menuProfileClick){
        element.classList.add("showMenuProfile");
        element2.classList.remove("showMenuLike");
        element3.style.display = "none";
        menuProfileClick = true;
        menuLikeClick = false;
    }
    else{
        element.classList.remove("showMenuProfile");
        element3.style.display = "none";
        menuProfileClick = false;
    }
}