var user = {
    data: {
        stages: []
    },
    cookie: {
        isSetLogin:false,
        getCookie: function (cname) {
            var name = cname+"=";
            var c;
            var ca = document.cookie.split(";");
            for (var i = 0; i < ca.length; i++) {
                c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        },
        setCookie: function (cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        },
        checkLoginCookie: function () {
            var cookie_username=this.getCookie("username");
            var cookie_uid = this.getCookie("uid");
            if (cookie_uid.length>0) {
                
                w3.http(
                    "../../Profile/checkCookie",
                    function () {
                        if (this.readyState == 4) {
                            if (this.status == 200) {
                                console.log(this.responseText);
                                var cookie = JSON.parse(this.responseText);
                                if (cookie.isValidCookie) {
                                    if (!user.cookie.isSetLogin) {
                                        user.cookie.isSetLogin = true;
                                        Id("nav-btn-container").innerHTML = "<a href=\"../../Profile/\" class=\"w3-bar-item w3-text w3-button\">Unjani " + user.cookie.getCookie("username").toUpperCase() + "?</a><a href=\"../../GAME_ITEM/\" class=\"w3-bar-item w3-text w3-button\">Avatar shopping items</a><a onclick='user.cookie.clearLoginCookie()' href=\"../../Accounts/logout\" class=\"w3-bar-item w3-text w3-button\">Log out</a>";
                                        try {
                                            w3.addClass("#btn-start-playing","w3-hide");
                                        } catch (e) {
                                            //Nothing
                                        }
                                        try {
                                            var num = w3.getElements(".tablink").length;
                                            w3.addClass(".tablink", "w3-hide");
                                            w3.getElements(".tablink")[num - 1].click();
                                        } catch (e) {
                                            //Nobody
                                        }
                                    }
                                    user.checkSession();
                                } /*else {
                                    user.cookie.setCookie("uid", "");
                                    user.cookie.setCookie("username", "");
                                    modal.showMessage("Your session has timed out. Logout in progress...");
                                    setTimeout(function () { location.assign("../../Accounts/logout"); }, 3000);
                                }*/
                            }
                        }
                    },
                    "username=" + escape(cookie_username) + "&uid=" + escape(cookie_uid),
                    "POST");
            }
            
        },
        clearLoginCookie: function () {
            user.cookie.setCookie("username", "", -1);
            user.cookie.setCookie("uid", "", -1);
        }
    },
    checkSession: function () {
        w3.http("../../Profile/checkSession", function () {
            if (this.readyState == 4) {
                var isCheckAgain = true;
                if (this.status == 200) {
                    console.log("Check session for user is recurring");
                    var json = JSON.parse(this.responseText);
                    if (!json.isActive) {
                        isCheckAgain = false;
                        user.cookie.checkLoginCookie();/*Validates the cookie of your browser*/
                    }
                }
                if (isCheckAgain) {
                    setTimeout(function () { user.checkSession(); }, 1000);
                }
            }
        });
    },
    loadStage: function () {
        var HTML = "<div class='w3-animate-zoom'>";
        var sectionNum = Math.round(question.level / 100);
        if (sectionNum > user.data.stages.length) {
            sectionNum = user.data.stages.length;
        }
        for (var i = 0; i < sectionNum; i++) {
            console.log(user.data.stages[i].SectionName);
            HTML += components.get.section(user.data.stages[i].SectionName,i, "");
        }
        HTML+="</div>"
        w3.getElements("#game-content")[0].innerHTML = HTML;
    },
    loadLevel: function (heading, sectionIndex) {
        question.track.sectionClick++;
        question.track.sectionIndex = sectionIndex;
        question.menuHeading = heading;
        question.menuLevelIndex = sectionIndex;
        var sectionNum = Math.round(question.level / 100);
        var str_level = question.level + "";
        str_level = str_level.substr(str_level.length - 2);
        var lvl_num = parseInt(str_level)+1;
        question.track.sectionName = heading;
        var HTML = "<div style=\"padding: 1%;\" class='w3-animate-zoom'><div style=\"padding: 1%;\" class=\"w3-container w3-round-xlarge w3-white w3-border\">";
        HTML += "<h2 class='w3-center'>" + heading+"</h2>";
        HTML += "<div class=\"w3-col l4 m6 s12\" onclick=\"user.loadStage()\" style=\"padding:7px;min-height: 300px;cursor: pointer;\"><section class=\"w3-col w3-center game-level w3-round-large s12 w3-border-blue w3-border w3-display-container w3-hover-blue\" style=\"min-height: 300px;padding: 7px;\">"
            +"<h3 class='w3-display-center'>Back</h3>"
            + "</section></div>";
        if (user.data.stages[sectionIndex].SectionLevel.length > 0) {
            var deter_index = ((sectionIndex + 1) < sectionNum) ? user.data.stages[sectionIndex].SectionLevel.length : lvl_num;
            for (var j = 0; j < deter_index; j++) {
                HTML += components.get.level("Level " + user.data.stages[sectionIndex].SectionLevel[j].Level, user.data.stages[sectionIndex].SectionLevel[j].Level, "");
            }
        }
        
        /*for (var j = 0; j < user.data.stages[sectionIndex].SectionLevel.length; j++) {
            HTML += components.get.level("Level " + user.data.stages[sectionIndex].SectionLevel[j].Level, user.data.stages[sectionIndex].SectionLevel[j].Level, "");
        }*/
        HTML += "</div></div>";
        w3.getElements("#game-content")[0].innerHTML = HTML;
    },
    clickLevel: function (level) {
        question.track.levelNum = level;
        question.toggleQuestionBlock();
        question.fetchQuestionData();
    }
};