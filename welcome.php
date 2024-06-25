<?php
include_once("./functions.php");
showPage('header', ['title' => 'welcome']);

?>

<main class="welcome-page">

    
    <div class="d-grid text-center">
        <div class="card m-auto  my-3  ">
            <div class="card-header ">
            <h2>Welcome To This Website</h2>
            </div>
            <div class="card-body">
                <h5 class="card-title text-dark">
                    <p>Please Visit The <a class="" href="./signup.php?signup">Sign Up</a> If You Don't Have A Account Yet.</p>
                </h5>
                <p class="card-text">If You Have A Registered Account Please <a href="./sign_in.php?signin">Log In </a>.</p>

            </div>
        </div>
    </div>

</main>







<?php

showPage('footer');

?>