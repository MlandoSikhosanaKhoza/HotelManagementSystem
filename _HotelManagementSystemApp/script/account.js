/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var account={
    signup(element){
        var isValid=true;
        var message="";
        var data=new FormData(Id("signup-form"));
        
        var suInputs=w3.getElements(".sign-up-input");
        for (var i = 0; i < suInputs.length; i++) {
            if (suInputs[i].value.trim()=="") {
                isValid=false;
                message+="Ensure that none of the fields are empty.\n";
                break;
            }
        }
        if(!/^[a-zA-Z]{2,25}$/.test(data.get("firstname"))){
            isValid=false;
            message+="Name: Invalid field\n";
        }
        if(!/^[a-zA-Z\s]{2,25}$/.test(data.get("lastname"))){
            isValid=false;
            message+="Lastname: Invalid field\n";
        }
        if(!/^[a-zA-Z0-9]{2,25}$/.test(data.get("username"))){
            isValid=false;
            message+="Username: Invalid field\n";
        }
        if (!account.validateEmail(data.get("email"))) {
            isValid=false;
            message+="Email: Invalid field\n";
        }
        if (data.get("password").length<6) {
            isValid=false;
            message+="Password: Ensure that there are atleast 6 characters\n";
        }
        if (data.get("password")!==data.get("Cpassword")) {
            isValid=false;
            message+="Confirm Password: Passwords don't match\n";
        }
        var xhttp=new XMLHttpRequest();
        xhttp.onload=function(){
            if (xhttp.status==200) {
                var gson=JSON.parse(xhttp.responseText);
                if (gson.isValid) {
                    modal.showMessage("Sign up is successful.");
                }else{
                    modal.showMessage("Sign up has failed.");
                }
            }else{
                modal.showMessage("Network Error: "+xhttp.status);
            }
            element.disabled=false;
        };
        if (isValid) {
            element.disabled=true;
            xhttp.open("POST","/method/Account/signup.php",true);
            xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhttp.send(new URLSearchParams(data).toString());
        }else{
            modal.showMessage(message);
        }
        
    },
    login(element){
        element.disabled=true;
        var data=new FormData(Id("login-form"));
        var xhttp=new XMLHttpRequest();
        xhttp.onload=function(){
            if (xhttp.status==200) {
                console.log(xhttp.responseText);
                var gson=JSON.parse(xhttp.responseText);
                if (gson.isValid) {
                    user.cookie.setCookie("username",gson.username,30);
                    user.cookie.setCookie("uid",gson.uid,30);
                    location.reload();
                }else{
                    modal.showMessage("Incorrect username/password")
                }
            }else{
                modal.showMessage("Network Error: "+xhttp.status);
            } 
            element.disabled=false;
        };
        xhttp.open("POST","/method/Account/login.php",true);
        xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhttp.send(new URLSearchParams(data).toString());
    },
    validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    },
    logout(){
        user.cookie.setCookie("username","",-1);
        user.cookie.setCookie("uid","",-1);
        location.reload();
    }
};