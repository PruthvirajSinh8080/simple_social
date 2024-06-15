<?php
include_once("./functions.php");
//show the visiting page and change the title of page to current page name
showPage("header", ['title' => 'Sign-Up']);
session_start();
?>

<div class="container mt-3 d-flex flex-column justify-content-center align-items-center ">
    <div class="alert alert-danger" id="red-alert" role="alert"></div>

    <div class="form-box border col-md-6 p-4  shadow p-3 mb-5 bg-white rounded ">
        <!-- form  -->
        <div class="text-center">
            <h2>Sign Up</h2>
        </div>

        <!-- username input -->
        <form class="form my-3" id="signup" method="POST">
            <div class="mb-3">
                <label for="user-name" class="form-label mx-2">User Name</label>
                <input type="text" class="form-control" id="user-name" name="user_name" aria-describedby="emailHelp" <?= prevInputValue("name") ?> required>

            </div>
            <!-- email input -->
            <div class="mb-3">
                <label for="user-email" class="form-label mx-2">Email address</label>
                <input type="email" class="form-control" id="user-email" name="user_email" aria-describedby="emailHelp" <?= prevInputValue("email") ?> required>
            </div>

            <!-- password input -->
            <div class="mb-3">
                <label for="user-pass" class="form-label mx-2">Password</label>
                <div class="input-group">
                    <input type="password" name="user_pass" class="form-control" id="user-pass" min="10" max="15" data-bs-toggle="popover" data-bs-content="Passwords should contain at least one uppercase,one lowercase,one digit and a special character and password should be minimum 10 characters and maximum 15 characters.
                    " data-bs-placement="left" data-bs-trigger="focus" required>
                    <button class="btn btn-primary " type="button" id="signup-show-pass">Show</button>
                </div>
                <div id="pass-strength" class="progress my-2" style="height: 6px; display: none;">
                    <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%; height: 100%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>


            <!-- confirm password input -->
            <div class="mb-3">
                <label for="user_confirm-pass" class="form-label mx-2">Confirm Password</label>
                <input type="password" name="user_confirm-pass" class="form-control" id="user_confirm-pass" required>
                <div class="form-text text-danger"></div>
            </div>
            <!--  -->

            <!--submit button  -->
            <button type="submit" class="btn btn-primary" id="signup-btn">Sign Up</button>
            <p class="my-2">If Already Have An Account Please <a href="./sign_in.php?sign_in">Sign In</a>.</p>
        </form>

    </div>
    <script type="module" src="./scripts/signup.js"></script>
    <?php

    include_once('./footer.php');
    ?>