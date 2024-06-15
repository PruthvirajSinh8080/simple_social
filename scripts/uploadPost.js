import { uploadPostData } from "./function.js";
import { redAlert } from "./alerts.js";

redAlert();
let submitPostBtn = document.getElementById("submitPostData");
submitPostBtn.addEventListener("click",(e)=>{
    e.preventDefault();
    uploadPostData();
})