<?php

session_start();
include('./functions.php');

if (!isset($_SESSION["user_name"])) {
  $error_message = "You cannot use our site without proper login.";
  header("Location: ./sign_in.php?error=" . urlencode($error_message));
  exit();
}
?>

<?php
//show the visiting page and change the title of page to current page name
showPage("header", ['title' => 'DeshBoard']);
?>

<!-------------navbar starts --------------->
<?php showPage("nav"); ?>
<!-------------navbar ends --------------->

<!-------------Hero starts --------------->

<div class="container">
  <!-- Green box with user info -->
  <div class="card m-auto col-sm-12 col-md-8 col-lg-8 col-xl-8 col-xxl-6 ">
    <div class="card-header bg-success text-white">
      Welcome!! <strong><?php echo $_SESSION['user_name'] ?></strong>
    </div>
    <div class="card-body">
      <h5 class="card-title">Hello, Welcome To The Dashboard Of The Site</h5>
      <p class="card-text">You have logged in using this <a>"<?= $_SESSION['user_email'] ?>"</a>.</p>
      <a href="./user_profile.php?<?php echo $_SESSION['user_name'] ?>" class="btn btn-primary">Visit Your Profile</a>
    </div>
  </div>

  <!-- Instant Post Creation Card -->
  <div class="container-fluid my-3 m-auto">
    <div class="row justify-content-center ">
      <div class="col-12 col-md-8 col-lg-8 col-xl-8 col-xxl-6">
        <div class="d-flex justify-content-center mb-2"> <!-- Center horizontally -->
          <div class="card" style="width: 100%;"> <!-- Added inline style for width -->
            <div class="card-body">
              <h5 class="card-title">What's in your mind?</h5>
              <textarea class="form-control mb-1" rows="0" placeholder="Write your post here"></textarea>
              <button class="btn btn-primary text-white" type="button"><a href="user_profile.php" class="text-white text-decoration-none">Create Post</a></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Post Section -->
  <div class="row justify-content-center mt-2">
    <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 col-xxl-6" id="post">
      <!-- New Post Card -->
      <!-- <div class="card-body">
      <div class="user-info d-flex align-items-center mb-2">
        <img src="images/user.png" alt="" class="user-pic" width="60" height="60">
        <div class="user-details ms-2">
            <div class="user-name fw-bold">User Name</div>
            <div class="post-time text-muted">2024-06-12 18:32:43</div>
        </div>
    </div>
        <h5 class="card-title my-1">its title</h5>
        <div class="card-img border">
          <div><img src="images/66699c735c9098.08744584.jpg" alt="" class="img-fluid card-img-top p-1"></div>
        </div>
        <div class="my-2 mx-2">its content</div>
        <div class="d-flex gap-2 w-100 my-2"><button class="btn btn-primary" type="button"><b>undefined</b> Like</button><button class="btn btn-secondary" type="button"><b>undefined</b> Comments</button><button class="btn btn-info" type="button"><b>undefined</b> Shares</button></div>
      </div> -->


    </div>
  </div>

  <div class="text-center my-5"><button class="btn btn-success" id="loadMore">Load More Post</button></div>
  <script type="module" src="./scripts/dashboard.js"></script>
  <?php
  include("./footer.php");
  ?>