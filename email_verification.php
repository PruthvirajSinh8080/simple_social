<?php
include_once("./functions.php");
session_start();

//show the visiting page and change the title of page to current page name
showPage("header", ['title' => 'Please Verify Your Email']);

?>


<div class="container vh-100 d-flex flex-column justify-content-center align-items-center ">
    
    <div class="alert alert-danger" id="red-alert" role="alert"></div>


    <!-- form  -->

    <div class="card col-md-6 shadow p-3 mb-5 bg-white rounded ">
        <div class="card-body">
            <h5 class="card-title">Email Verification</h5>
            <form>
                <div class="mb-3">
                    <label for="user-email" class="form-label ">Email address</label>
                    <input type="text" class="form-control" id="user-email" aria-describedby="emailHelp" value="" readonly>
                    <p id="email-p"></p>
                </div>
                <div class="mb-3">
                    <label for="verificationCode" class="form-label">Verification Code</label>
                    <input type="text" class="form-control" id="verificationCode"  required>
                </div>

                <button type="button" class="btn btn-primary" id="verifyBtn">Verify</button>
                <button type="button" class="btn btn-primary" id="sendOtp" >Send OTP</button>
            </form>
        </div>
    </div>


    <script type="module" src="./scripts/email_verification.js"></script>
    
   
    
   
    <?php

    include_once('./footer.php');
    ?>