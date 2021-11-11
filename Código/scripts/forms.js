// Check to see if e-mail isn't blank and is well formed
// Read more at http://www.marketingtechblog.com/javascript-regex-emailaddress/#ixzz1p1ZDMNZe

var filterUsername = /^(?=.*[a-zA-Z])[a-zA-Z0-9_]{5,12}$/;
var filterPass = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
var filterEmail = /^([a-z0-9_\.\-]{4,30})+\@(([a-z0-9\-]{2,7})+\.)+([a-z0-9]{2,4})$/;


function FormRegisterValidator(theForm) {  
  if (!filterUsername.test( document.getElementsByName('username')[0].value ) ) {

    document.getElementsByName('password')[0].style.borderColor = "rgba(0,0,0,0.4)";
    document.getElementsByName('rePassword')[0].style.borderColor = "rgba(0,0,0,0.4)";
    document.getElementsByName('email')[0].style.borderColor = "rgba(0,0,0,0.4)";
    
    document.getElementsByName('username')[0].focus();
    document.getElementsByName('username')[0].style.borderColor = "red";
    
    return false;
  }

  if (!filterEmail.test( document.getElementsByName('email')[0].value ) ) {
    document.getElementsByName('password')[0].style.borderColor = "rgba(0,0,0,0.4)";
    document.getElementsByName('rePassword')[0].style.borderColor = "rgba(0,0,0,0.4)";
    document.getElementsByName('username')[0].style.borderColor = "rgba(0,0,0,0.4)";
    
    document.getElementsByName('email')[0].focus();
    document.getElementsByName('email')[0].style.borderColor = "red";
    return false;
  }
  
  if (!filterPass.test( document.getElementsByName('password')[0].value ) ) {
    document.getElementsByName('username')[0].style.borderColor = "rgba(0,0,0,0.4)";
    document.getElementsByName('rePassword')[0].style.borderColor = "rgba(0,0,0,0.4)";
    document.getElementsByName('email')[0].style.borderColor = "rgba(0,0,0,0.4)";
    
    document.getElementsByName('password')[0].focus();
    document.getElementsByName('password')[0].style.borderColor = "red";
    
    return false;
  }
  
  if ( document.getElementsByName('rePassword')[0].value !=  document.getElementsByName('password')[0].value) {
      
    document.getElementsByName('password')[0].style.borderColor = "rgba(0,0,0,0.4)";
    document.getElementsByName('username')[0].style.borderColor = "rgba(0,0,0,0.4)";
    document.getElementsByName('email')[0].style.borderColor = "rgba(0,0,0,0.4)";
    
    document.getElementsByName('rePassword')[0].focus();
    document.getElementsByName('rePassword')[0].style.borderColor = "red";
    return false;
  }
  
   return true;
  //return false;
}

var xmlHttp;

function GetXmlHttpObject() {
  try {
    return new ActiveXObject("Msxml2.XMLHTTP");
  } catch(e) {} // Internet Explorer
  try {
    return new ActiveXObject("Microsoft.XMLHTTP");
  } catch(e) {} // Internet Explorer
  try {
    return new XMLHttpRequest();
  } catch(e) {} // Firefox, Opera 8.0+, Safari
  alert("XMLHttpRequest not supported");
  return null;
}
