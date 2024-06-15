<?php
include_once('./functions.php');
showPage("header", ['title' => 'Sign-In']);

?>

<!-- body -->
<div class="container vh-100 d-flex flex-column justify-content-center align-items-center ">
  <div class="alert alert-danger " style="display: none" id="red-alert" role="alert"></div>

  <!-- form -->
  <div class="form-box border col-md-6 p-4  shadow p-3 mb-5 bg-white rounded ">

    <div class="text-center">

      <h2>Sign In</h2>
    </div>
    <form class="form my-3" id="signin" method="POST">

      <div class="mb-3">
        <label for="user-or-email" class="form-label mx-2">Username or Email </label>
        <input type="text" class="form-control" id="user-or-email" name="user-or-email" aria-describedby="emailHelp" <?= prevInputValue("email") ?> required>
        <div id="emailHelp" class="form-text text-danger"></div>
      </div>

      <div class="mb-3">
        <label for="user-pass" class="form-label mx-2">Password</label>
        <div class="input-group">
          <input type="password" name="user_pass" class="form-control" id="user-pass" min="10" max="15" data-bs-toggle="popover" data-bs-content="Please Verify Your Password Here.
                    " data-bs-placement="left" data-bs-trigger="focus" required>
          <button class="btn btn-primary " type="button" id="signin-show-pass">Show</button>
        </div>
      </div>
      <div class="d-flex justify-content-between align-items-center">
        <button type="submit" class="btn btn-primary" id="signin-btn">Sign In</button>
        <a href="./forget_pass.php?forget" class="text-decoration-none mx-1">Forget Password?</a>
      </div>
      <p class="my-3">If You Don't Have An Account Please Creat A <a href="./signup.php">New Account</a>.</p>
    </form>

  </div>
  <script type="module" src="./scripts/signin.js"></script>
  
  <?php
  include_once('./footer.php');
  ?>