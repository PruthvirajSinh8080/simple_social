<?php
include_once("./functions.php");
showPage("header", ['title' => 'Forget Password']);
?>

<div class="container vh-100 d-flex flex-column justify-content-center align-items-center">
    <div class="row col-md-6 justify-content-center">
        <div class="alert alert-danger " style="display: none" id="red-alert" role="alert"></div>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Forgot Password</h3>
                <form id="forgotPasswordForm">
                    <div class="mb-3">
                        <label for="email" class="form-label mx-1">Email address</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" id="submitEmail">Submit</button>

                    <div class="mb-3 my-2 collapse" id="otpDiv">
                        <label for="forgetOtp" class="form-label mx-1">Enter OTP </label>
                        <input type="text" class="form-control" id="forgetOtp" placeholder="Enter your email" required>
                        <button type="submit" class=" my-2 btn btn-primary w-100" id="verifyOTP">Verify</button>
                    </div>

                    <div class="mb-3 my-2 collapse" id="newPassDiv">
                        <label for="newPass" class="form-label mx-1">Enter New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPass" placeholder="Enter your New Password" required>
                            <button class="btn btn-primary " type="button" id="confirm-new-pass">Show</button>
                        </div>
                        <div id="pass-strength" class="progress my-2" style="height: 6px; display: none;">
                            <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%; height: 100%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <label for="conNewPass" class="form-label mx-1">Confirm New Password</label>
                        <input type="text" class="form-control" id="conNewPass" placeholder="Confirm your New Password" required>
                        <button type="submit" class=" my-2 btn btn-primary w-100 disabled" id="newPassBtn">Change Password</button>
                    </div>
                </form>
                <div class="mt-3 text-center">
                    <a href="./sign_in.php?sign_in">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="module" src="./scripts/forget_pass.js"></script>
<?php
include_once("./footer.php")
?>