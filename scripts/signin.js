import { verifyUserInfo,showPass,unaothorizedLoggig } from "./function.js";
import { redAlert } from "./alerts.js";
redAlert();
showPass("signin-show-pass","user-pass");
unaothorizedLoggig();

let signInBtn = document.getElementById("signin-btn");
signInBtn.addEventListener("click", (e) => {
    e.preventDefault();
    verifyUserInfo();
    console.log("verifyUserInfo run");
})
