import { redAlert } from "./alerts.js";
import { loadPopOvers,UserInfo, handleData, checkPassIsMatch, passCheck , showPass , isPassStrong} from "./function.js";

redAlert();
loadPopOvers();

//calls the isPassStrong function to show pass strength meter
const userPassInput = document.getElementById("user-pass");
userPassInput.addEventListener("input", (e) => {
    isPassStrong(userPassInput.value,"signup-btn");
});

//show and hide pass using button
showPass("signup-show-pass","user-pass","user_confirm-pass");

// add event listners to trigger userdata function

let signupBtn = document.getElementById("signup-btn");
signupBtn.addEventListener("click", (e) => {
    e.preventDefault();
    if (checkPassIsMatch()) {
        console.log("UserInfo run.")
        UserInfo();
    } else {
        console.log("UserInfo did not run.")
    }
})