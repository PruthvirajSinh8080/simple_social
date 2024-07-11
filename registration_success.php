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

<div class="alert alert-danger" id="red-alert" role="alert"></div>

  <!-- Green box with user info -->
  <div class="card m-auto col-sm-12 col-md-8 col-lg-8 col-xl-8 col-xxl-6 ">
    <div class="card-header bg-success text-white">
      Welcome!! <strong><?php echo $_SESSION['user_name'] ?></strong>
    </div>
    <div class="card-body">
      <h5 class="card-title">Hello, Welcome To The Dashboard Of The Site</h5>
      <p class="card-text">You have logged in using this <a>"<?= $_SESSION['user_email'] ?>"</a>.</p>
      <a href="./user_profile.php?<?php echo $_SESSION['user_name'] ?>" class="btn btn-primary">Visit Your Profile</a>

      <button class="btn btn-primary text-white ms-1" type="button"><a href="create_post.php" class="text-white text-decoration-none">Create Post</a></button>
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
        <div class="d-flex gap-2 w-100 my-2">
          <button class="btn btn-primary" type="button"><b>undefined</b> Like</button>

          <button class="btn btn-secondary" type="button"><b>undefined</b> Comments</button>
          
          <button class="btn btn-info" type="button"><b>undefined</b> Shares</button></div>
      </div> -->


    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="comment_popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Leave A Comments...</h5>
          <button type="button" id="comment_close_btn" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="comment_section">
          <!-- comment box -->
          <div class="comment-box" id="comment-box">
            <!-- comments goes here -->No Comments Yet..
          </div>
          <div class="modal-footer">

            <div class="loader mt-5 m-auto "></div>
            <div class="container card-footer">
              <!-- Comment Form -->
              <div class="mb-1">
                <label for="comment" class="form-label" id="comment_label">Add a comment</label>
                <textarea class="form-control" id="comment"></textarea>
                <button class="comment_btn btn btn-primary mt-2" id="post_comment" >Post Comment</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mediaModalLabel">Media</h5>

      </div>
      <div class="modal-body">
        <img src="" id="modalImage" class="img-fluid d-none" alt="">
        <video controls id="modalVideo" class="d-none" style="width: 100%;">
          <source src="" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>

    </div>
  </div>
</div>


<div class="loader mt-5 m-auto "></div>

<div class="text-center my-5"><button class="btn btn-success" id="loadMore">Load More Post</button>

</div>


<script type="module" src="./scripts/dashboard.js"></script>
<?php
include("./footer.php");
?>