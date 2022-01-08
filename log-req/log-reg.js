
function showMe_register_form() {
   var foo = document.getElementsByClassName("register-form")[0];
   var foo2 = document.getElementsByClassName("login-form")[0];
   var foo3 = document.getElementsByClassName("password-request-form")[0];
   var display = getComputedStyle(foo).display;
                  
               if (display == "none") {
                foo2.style.display = "none";
                foo3.style.display = "none";
                foo.style.display = "block";
            } 
}

function showMe_login_form() {
   var foo = document.getElementsByClassName("login-form")[0];
   var foo2 = document.getElementsByClassName("register-form")[0];
   var foo3 = document.getElementsByClassName("password-request-form")[0];
   var display = getComputedStyle(foo).display;
                  
               if (display == "none") {
                foo2.style.display = "none";
                foo3.style.display = "none";
                foo.style.display = "block";
            } 
}
function showMe_password_request() {
   var foo = document.getElementsByClassName("password-request-form")[0];
   var foo2 = document.getElementsByClassName("login-form")[0];

                foo.style.display = "block";
                foo2.style.display = "none";

}
      