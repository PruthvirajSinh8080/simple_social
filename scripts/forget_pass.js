import { redAlert } from "./alerts.js";
import {loadPopOvers,forgetPass,verifyForgetOtp,changePass,showPass,hideAlert} from "./function.js";
redAlert();

showPass("confirm-new-pass","newPass","conNewPass",)
loadPopOvers();


    let submitEmail = document.getElementById("submitEmail");
    submitEmail.addEventListener("click", (e) => {
        e.preventDefault();
        
        forgetPass();
    });
    let verifyOTP = document.getElementById("verifyOTP");
    verifyOTP.addEventListener("click", (e) => {
        e.preventDefault();
        verifyForgetOtp();
    });
    let changePassBtn = document.getElementById("newPassBtn");
    changePassBtn.addEventListener("click", (e) => {
        e.preventDefault();
        changePass();
    });