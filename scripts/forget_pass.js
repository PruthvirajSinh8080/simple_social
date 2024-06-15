import { redAlert } from "./alerts.js";
import {loadPopOvers,forgetPass,randomPassCode,verifyForgetOtp,showPass,changePass,redAlertDanger,redAlertGreen } from "./function.js";
redAlert();
showPass("confirm-new-pass","newPass","conNewPass",)
loadPopOvers();


    let submitEmail = document.getElementById("submitEmail");
    submitEmail.addEventListener("click", (e) => {
        e.preventDefault();
        forgetPass("submit");
    });
    let verifyOTP = document.getElementById("verifyOTP");
    submitEmail.addEventListener("click", (e) => {
        e.preventDefault();
        verifyForgetOtp("verify");
    });
    let changePassBtn = document.getElementById("newPassBtn");
    changePassBtn.addEventListener("click", (e) => {
        e.preventDefault();
        changePass();
    });