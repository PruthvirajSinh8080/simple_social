import { loadPost } from "./function.js";
import { redAlert } from "./alerts.js";

redAlert();

let currentOffset = 0;
const limit = 10;
//loader
const loadingIndicator = document.getElementsByClassName("loader")[1];


async function loadingPost() {
  loadingIndicator.style.display = "block";
  let countPost = await loadPost(currentOffset);
  currentOffset += countPost;
  console.log(currentOffset);
  loadingIndicator.style.display = "none";
}

loadingPost();
console.log(currentOffset);


let loadMore = document.getElementById("loadMore");
loadMore.addEventListener("click", async (e) => {
  e.preventDefault;
  // currentOffset += limit;
  loadingIndicator.style.display = "block";
  loadingPost();
  loadingIndicator.style.display = "none";
  console.log(currentOffset);
});

/// view post in a new pop up window
document.addEventListener("DOMContentLoaded", (event) => {
  const postContainer = document.getElementById("post");
  let backgroundVideo = null;
  let closeBtn = document.querySelector("close");

  
//popup modal that lets user see media in seprate window
  postContainer.addEventListener("click", function (event) {
    if (event.target.tagName === "IMG" || event.target.tagName === "VIDEO") {
      const modalImage = document.getElementById("modalImage");
      const modalVideo = document.getElementById("modalVideo");

      if (event.target.tagName === "IMG") {
        modalImage.src = event.target.src;
        modalImage.title = event.target;
        modalImage.classList.remove("d-none");
        modalVideo.classList.add("d-none");
      } else if (event.target.tagName === "VIDEO") {
        backgroundVideo = event.target;
        backgroundVideo.pause();
        modalVideo.src = event.target.src;
        modalVideo.title = event.target.classList;
        modalVideo.classList.remove("d-none");
        modalImage.classList.add("d-none");
      }

      $("#mediaModal").modal("show");

      $("#mediaModal").on("hidden.bs.modal", function () {
        if (backgroundVideo) {
          backgroundVideo.play();
        }
      });
    }
  });
});


