import { loadPost } from "./function.js";

loadPost();
let loadMore = document.getElementById("loadMore");
loadMore.addEventListener("click",(e) => {
    e.preventDefault;
    loadPost();
}

);



