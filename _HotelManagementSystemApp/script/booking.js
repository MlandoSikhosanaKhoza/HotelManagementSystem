/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var booking={
    list:[],
    room_type_list:[],
    room_num_list:[],
    hotelChanged(element){
        booking.changeRoomType();
        if (Id("company").value==="") {
            w3.addClass("#ava-con","w3-disabled");
            w3.addClass(".depe-com","w3-disabled");
        }else{
            w3.addClass("#ava-con","w3-disabled");
            var data=new FormData();
            element.disabled=true;
            data.append("company_id",Id("company").value);
            w3.addClass(".depe-com","w3-disabled");
            console.log(data.get("company_id"));
            var xhttp=new XMLHttpRequest();
            xhttp.onload=function(){
                if (xhttp.status===200) {
                    booking.room_type_list=JSON.parse(xhttp.responseText);
                    var html="";
                    for (var i = 0; i < booking.room_type_list.length; i++) {
                        html+='<option value="'+booking.room_type_list[i].RoomTypeID+'">'+booking.room_type_list[i].RoomName+'</option>';
                    }
                    Id("roomtype").innerHTML=html;
                    w3.removeClass("#ava-con","w3-disabled");
                    w3.removeClass(".depe-com","w3-disabled");
                }else{
                    modal.showMessage("Network Error");
                }
                element.disabled=false;
            };
            xhttp.open("POST","/method/Account/Booking/loadRoomTypes.php",true);
            xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhttp.send(new URLSearchParams(data).toString());
        }
    },
    changeRoomType(){
        w3.addClass("#num-con","w3-hide");
    },
    checkDates(){
        booking.changeRoomType();
        if (Id("arr-val").value!==""&&Id("dep-val").value!=="") {
            var today=new Date();
            today.setHours(9);
            var dateArr=new Date(Id("arr-val").value+" 12:00:00");
            var dateDep=new Date(Id("dep-val").value+" 12:00:00");
            if (dateArr.getTime()<dateDep.getTime() && today.getTime()<dateArr.getTime()) {
                w3.removeClass("#ava-con","w3-disabled");
            }else{
                w3.addClass("#ava-con","w3-disabled");
            }
        }else{
            w3.addClass("#ava-con","w3-disabled");
        }
    },
    searchAvailability(){
        booking.checkDates();
        if (Id("arr-val").value==""||Id("dep-val").value=="") {
            
        }else{
            w3.addClass("#booking-form","w3-disabled");
        var data=new FormData();
            data.append("company_id",Id("company").value);
            data.append("arrival",Id("arr-val").value);
            data.append("departure",Id("dep-val").value);
            data.append("room_type_id",Id("roomtype").value);
            console.log(data.get("company_id"));
            var xhttp=new XMLHttpRequest();
            xhttp.onload=function(){
                if (xhttp.status===200) {
                    var html="";
                    booking.room_num_list=JSON.parse(xhttp.responseText);
                    for (var i = 0; i < booking.room_num_list.length; i++) {
                        html+='<option value="'+booking.room_num_list[i].RoomNumID+'">'+booking.room_num_list[i].RoomNum+'</option>';
                    }
                    Id("room_num").innerHTML=html;
                    w3.removeClass("#num-con","w3-hide");
                }else{
                    modal.showMessage("Network Error");
                }
                w3.removeClass("#booking-form","w3-disabled");
            };
            xhttp.open("POST","/method/Account/Booking/showAvailability.php",true);
            xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhttp.send(new URLSearchParams(data).toString());
        }
        
    },
    bookARoom(){
        w3.addClass("#booking-form","w3-disabled");
        var data=new FormData(Id("booking-form"));
            var xhttp=new XMLHttpRequest();
            xhttp.onload=function(){
                if (xhttp.status===200) {
                    var gson=JSON.parse(xhttp.responseText);
                    if (gson.isValid) {
                    location.assign("../profile/");
                }else{
                    w3.removeClass("#booking-form","w3-disabled");
                }
                
                }else{
                    modal.showMessage("Network Error");
                    w3.removeClass("#booking-form","w3-disabled");
                }
                
            };
            xhttp.open("POST","/method/Account/Booking/ReserveRoom.php",true);
            xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhttp.send(new URLSearchParams(data).toString());
    }
};