var modal = {
    showMessage: function (message) {
        Id("main-modal-heading").innerText = "Message";
        Id("main-modal-content").innerText = message;
        w3.addClass("#main-modal", "w3-show");
    },
    showMessageHTML: function (message) {
        Id("main-modal-heading").innerText = "Message";
        Id("main-modal-content").innerHTML = message;
        w3.toggleClass("#main-modal", "w3-show");
    },
    showHeadMessageHTML: function (heading, message) {
        Id("main-modal-heading").innerText = heading;
        Id("main-modal-content").innerHTML = message;
        w3.toggleClass("#main-modal", "w3-show");
    },
    closeModal:function(){
        w3.removeClass("#main-modal", "w3-show");
    }
};