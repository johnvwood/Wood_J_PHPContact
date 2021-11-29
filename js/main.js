import {SendMail} from "./modules/mailer.js";
(() => {
    let mailSubmit = document.querySelector('.submit-box');
    function processMailFailure(result) {
        console.table(result); 
    }
    function processMailSuccess(result) {
        console.table(result);
    }
    function processMail(event) {
        event.preventDefault();
        SendMail(this.parentNode)
            .then(data => processMailSuccess(data))
            .catch(err => processMailFailure(err));
    }
    mailSubmit.addEventListener("click", processMail);
})();