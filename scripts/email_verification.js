import { checkSessionItemIsSet, sendOtp, verifyPasscode } from "./function.js";
import { redAlert } from "./alerts.js";
redAlert();
checkSessionItemIsSet("userEmailEncrypt");

// this is used check if the otp is already submited or  not
let otp = null;
// event listner for click..
// sendOtp(otp);
// verifyPasscode(otp);

let email = document.getElementById("user-email");
let sendBtn = document.getElementById("sendOtp");
sendBtn.addEventListener("click", async () => { 
    otp = await sendOtp(otp) })



let verifyBtn = document.getElementById("verifyBtn");
verifyBtn.addEventListener("click", async () => { otp = await verifyPasscode(otp) })