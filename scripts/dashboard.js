import { loadPost } from "./function.js";

let currentOffset = 0;
const limit = 10;

async function loadingPost() {
  let countPost = await loadPost(currentOffset);
  currentOffset += countPost;
  console.log(currentOffset);
}

loadingPost();
console.log(currentOffset);

let loadMore = document.getElementById("loadMore");
loadMore.addEventListener("click", async (e) => {
  e.preventDefault;
  // currentOffset += limit;

  loadingPost();
  console.log(currentOffset);
});


