/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var admin={
    company_id: -1,
    services:{
        addCategory(element){
            var data=new FormData(Id("category-form"));
            var xhttp=new XMLHttpRequest();
            xhttp.onload=function(){
                if (xhttp.status===200) {
                    modal.showMessage(xhttp.responseText);
                }else{
                    modal.showMessage("Network Error...")
                }
                element.disabled=false;
            };
            if (data.get("category_name")!=="") {
                element.disabled=true;
                xhttp.open("POST","/method/Admin/authority/addNewCategory.php",true);
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send(new URLSearchParams(data).toString());
            }
        },
        addService(element){
            var data=new FormData(Id("service-form"));
            var xhttp=new XMLHttpRequest();
            xhttp.onload=function(){
                if (xhttp.status===200) {
                    modal.showMessage(xhttp.responseText);
                }else{
                    modal.showMessage("Network Error...")
                }
                element.disabled=false;
            };
            if (data.get("category_name")!=="") {
                element.disabled=true;
                xhttp.open("POST","/method/Admin/authority/addNewService.php",true);
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send(new URLSearchParams(data).toString());
            }
        }
    },
    employee:{
        isActivated: false,
        employeeID: -1,
        closeModal(){
            w3.removeClass("#show-modal","w3-show");
            admin.employee.isActivated=false;
            admin.employee.employeeID=-1;
        },
        loadResponsibility(element,employee_id){
            admin.employee.employeeID=employee_id;
            var data=new FormData();
            data.append("employee_id",employee_id);
            var xhttp=new XMLHttpRequest();
            xhttp.onload=function(){
                if(xhttp.status===200){
                    console.log(xhttp.responseText);
                    var gson=JSON.parse(xhttp.responseText);
                    var ts_list=document.getElementsByClassName("task-service");
                    for (var i = 0; i < ts_list.length; i++) {
                        ts_list[i].checked=false;
                    }
                    for (var i = 0; i < ts_list.length; i++) {
                        for (var j = 0; j < gson.length; j++) {
                            if(gson[j]==ts_list[i].value){
                                ts_list[i].checked=true;
                            }
                        }
                    }
                    w3.addClass("#show-modal","w3-show");
                    admin.employee.isActivated=true;
                }else{
                    modal.showMessage("Error Message: "+ xhttp.responseText);
                }
                element.disabled=false;
            };
            element.disabled=true;
            xhttp.open("POST","/method/Admin/authority/getEmployeeServices.php",true);
            xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhttp.send(new URLSearchParams(data).toString());
        },
        insertResponsibility(element,employee_id){
            if (admin.employee.isActivated) {
                var data=new FormData();
                data.append("employee_id",admin.employee.employeeID);
                data.append("service_id",element.value);
                var xhttp=new XMLHttpRequest();
                xhttp.onload=function(){
                    if(xhttp.status===200){
                        console.log(xhttp.responseText);
                        var gson=JSON.parse(xhttp.responseText);
                        if (gson.isValid) {
                            console.log("success bitches");
                        }else{
                            admin.employee.isActivated=false;
                            element.click();
                            admin.employee.isActivated=true;
                        }
                    }else{
                        modal.showMessage("Error Message: "+ xhttp.responseText);
                    }
                    w3.removeClass(element.parentElement,"w3-disabled");
                };
                w3.addClass(element.parentElement,"w3-disabled");
                xhttp.open("POST","/method/Admin/authority/toggleEmployeeService.php",true);
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                console.log(new URLSearchParams(data).toString());
                xhttp.send(new URLSearchParams(data).toString());
            }
        },
        signup(element){
            var isValid=true;
            var message="";
            var data=new FormData(Id("employee-form"));

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
            if (!admin.validateEmail(data.get("email"))) {
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
                    console.log(xhttp.responseText);
                    var gson=JSON.parse(xhttp.responseText);
                    if (gson.isValid) {
                        modal.showMessage("Employee insert is successful.");
                    }else{
                        modal.showMessage("Employee insert has failed.");
                    }
                }else{
                    modal.showMessage("Network Error: "+xhttp.status);
                }
                element.disabled=false;
            };
            if (isValid) {
                element.disabled=true;
                xhttp.open("POST","/method/Admin/authority/addNewEmployee.php",true);
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");;
                xhttp.send(new URLSearchParams(data).toString());
            }else{
                modal.showMessage(message);
            }
        }
    },
    room:{
        addRoomType(element){
            var data=new FormData(Id("room-form"));
            var xhttp=new XMLHttpRequest();
            xhttp.onload=function(){
                if (xhttp.status===200) {
                    modal.showMessage(xhttp.responseText);
                }else{
                    modal.showMessage("Network Error...")
                }
                element.disabled=false;
            };
            if (data.get("roomname")!=="" && data.get("roomprice")!=="") {
                element.disabled=true;
                xhttp.open("POST","/method/Admin/authority/addRoomType.php",true);
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send(new URLSearchParams(data).toString());
            }
        },
        addRoomNum(element){
            console.log("Something is happening");
            var data=new FormData(Id("room-num-form"));
            console.log(data.get("roomtype"));
            var xhttp=new XMLHttpRequest();
            xhttp.onload=function(){
                if (xhttp.status===200) {
                    modal.showMessage(xhttp.responseText);
                }else{
                    modal.showMessage("Network Error...")
                }
                element.disabled=false;
            };
            if (data.get("roomnum")!=="" && data.get("roomtype")!=="") {
                element.disabled=true;
                xhttp.open("POST","/method/Admin/authority/addRoom.php",true);
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send(new URLSearchParams(data).toString());
            }
        }
    },
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
            xhttp.open("POST","/method/Admin/signup.php",true);
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
                    user.cookie.setCookie("admin_user",gson.username,30);
                    user.cookie.setCookie("admin_uid",gson.uid,30);
                    modal.showMessage("Logging in...");
                    location.reload();
                }else{
                    modal.showMessage("Incorrect username/password")
                }
            }else{
                modal.showMessage("Network Error: "+xhttp.status);
            } 
            element.disabled=false;
        };
        xhttp.open("POST","/method/Admin/login.php",true);
        xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhttp.send(new URLSearchParams(data).toString());
    },
    validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    },
    addNewCompany(element){
        var isValid=true;
        var message="";
        var data=new FormData(Id("company-form"));
        
        var suInputs=w3.getElements(".sign-up-input");
        for (var i = 0; i < suInputs.length; i++) {
            if (suInputs[i].value.trim()=="") {
                isValid=false;
                message+="Ensure that none of the fields are empty.\n";
                break;
            }
        }
        if(!/^[a-zA-Z0-9\s]{2,100}$/.test(data.get("companyname"))){
            isValid=false;
            message+="Company name: Invalid field\n";
        }
        if(!/^[a-zA-Z0-9\s]{2,100}$/.test(data.get("city"))){
            isValid=false;
            message+="City: Invalid field\n";
        }
        if(!/^[0-9]{2,10}$/.test(data.get("postalcode"))){
            isValid=false;
            message+="Postal code: Invalid field\n";
        }
        if(!/^[a-zA-Z0-9\s]{2,200}$/.test(data.get("address"))){
            isValid=false;
            message+="Address: Invalid field\n";
        }
        if(!/^[a-zA-Z0-9]{2,25}$/.test(data.get("username"))){
            isValid=false;
            message+="Username: Invalid field\n";
        }
        if (!admin.validateEmail(data.get("email"))) {
            isValid=false;
            message+="Email: Invalid field\n";
        }
        if (data.get("password").length<6) {
            isValid=false;
            message+="Password: Ensure that there are atleast 6 characters\n";
        }
        if (data.get("password")!==data.get("confirmPassword")) {
            isValid=false;
            message+="Confirm Password: Passwords don't match\n";
        }
        var xhttp=new XMLHttpRequest();
        xhttp.onload=function(){
            if (xhttp.status==200) {
                var gson=JSON.parse(xhttp.responseText);
                if (gson.isValid) {
                    modal.showMessage("Company added successfully.");
                }else{
                    modal.showMessage("Company insert has failed.");
                }
            }else{
                modal.showMessage("Network Error: "+xhttp.status);
            }
            element.disabled=false;
        };
        if (isValid) {
            element.disabled=true;
            xhttp.open("POST","/method/Admin/authority/addnewcompany.php",true);
            xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhttp.send(new URLSearchParams(data).toString());
        }else{
            modal.showMessage(message);
        }
    },
    openUpdate(element,company_id){
        var data=new FormData();
        data.append("company_id",company_id);
        var xhttp=new XMLHttpRequest();
        xhttp.onload=function(){
            if (xhttp.status==200) {
                console.log(xhttp.responseText);
                var gson=JSON.parse(xhttp.responseText);
                if (gson.isValid) {
                    var fdata=new FormData(Id("company-form"));
                    document.getElementsByName("companyname")[0].value=gson.companyname;
                    document.getElementsByName("address")[0].value=gson.address;
                    document.getElementsByName("city")[0].value=gson.city;
                    document.getElementsByName("postalcode")[0].value=gson.postalcode;
                    document.getElementsByName("email")[0].value=gson.email;
                    w3.addClass("#edit-modal","w3-show");
                    /*modal.showMessage(
                            "Company Name: "+gson.companyname+"\n"+
                            "Address: "+gson.address+"\n"+
                            "City: "+gson.city+"\n"+
                            "Postal code: "+gson.postalcode+"\n"+
                            "Email: "+gson.email+"\n"
                            );*/
                }else{
                    modal.showMessage("Company display has failed.");
                }
            }else{
                modal.showMessage("Network Error: "+xhttp.status);
            }
            element.disabled=false;
        };
        element.disabled=true;
        xhttp.open("POST","/method/Admin/authority/getCompanyDetails.php",true);
        xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhttp.send(new URLSearchParams(data).toString());
    },
    updateCompany(){
        
    },
    showCompanyDetails(element,company_id){
        var data=new FormData();
        data.append("company_id",company_id);
        var xhttp=new XMLHttpRequest();
        xhttp.onload=function(){
            if (xhttp.status==200) {
                console.log(xhttp.responseText);
                var gson=JSON.parse(xhttp.responseText);
                if (gson.isValid) {
                    modal.showMessage(
                            "Company Name: "+gson.companyname+"\n"+
                            "Address: "+gson.address+"\n"+
                            "City: "+gson.city+"\n"+
                            "Postal code: "+gson.postalcode+"\n"+
                            "Email: "+gson.email+"\n"
                            );
                }else{
                    modal.showMessage("Company display has failed.");
                }
            }else{
                modal.showMessage("Network Error: "+xhttp.status);
            }
            element.disabled=false;
        };
        element.disabled=true;
        xhttp.open("POST","/method/Admin/authority/getCompanyDetails.php",true);
        xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhttp.send(new URLSearchParams(data).toString());
        
    },
    logout(){
        user.cookie.setCookie("admin_user","",-1);
        user.cookie.setCookie("admin_uid","",-1);
        location.reload();
    }
};