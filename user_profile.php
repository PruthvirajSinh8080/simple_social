<?php
session_start();
include('./functions.php');
//check if session is set or not
if (!isset($_SESSION["user_name"])) {
    $error_message = "You cannot use our site without proper login.";
    header("Location: ./sign_in.php?error=" . urlencode($error_message));
    exit();
}
?>

<?php
$userName = $_SESSION["user_name"];
//show the visiting page and change the title of page to current page name
showPage("header", ['title' => "Welcome $userName"]);
?>

<!-- body -->
<div class="container mt-2  d-flex flex-column justify-content-center align-items-center ">
    <div class="alert alert-danger " style="display: none  " id="red-alert" role="alert"></div>
    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-md-8">
                        <!--alert  -->
                <div class="alert alert-danger position-sticky sticky-top  mt-2 mb-2 alert-dismissible fade show  " style="display: none" id="red-alert" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="profile-pic.jpg" id="profile_pic"
                                width="200px" height="200px"class="img-fluid bordered" alt="Profile Picture">
                            </div>
                            <div class="col-md-8 align-middle flex">
                                <h3>User:- <?= $_SESSION['user_name'] ?></h3>
                                <br>
                                <p>Email :- <?= $_SESSION['user_email'] ?></p>
                                <p id="phone_p">Address Is Not Provided.</p>
                                <p id="address_p">Address Is Not Provided.</p>
                                <p id="first_p">First Name :- Not Provided. </p>
                                <p id="last_p">Last Name :- Not Provided. </p>
                                <p id="dob_p">D.O.B :- Not Provided.</p>
                                <p id="city_p">City :- Not Provided.</p>
                                <p id="zipcode_p">Zip Code :- Not Provided.</p>
                                <p id="state_p">State :- Not Provided.</p>
                                <p id="country_p">Country :- Not Provided.</p>
                                <p id="last_online_p">Last Online :- Not Provided.</p>
                            </div>
                        </div>
                        <hr>
                        <h5 class="mb-1">About Me</h5>
                        <p id="about_me_p">Why Don't You Fill It Up???</p>
                        <br>

                        <button type="submit" id="edit_profile" class="btn btn-primary mb-3">Edit Profile</button>



                        <!-- Form for updating profile -->
                        <form action="" method="POST" id="profile_form" enctype="multipart/form-data" style="display : none">
                            <div class="form-group">
                                <label for="first-name">First Name</label>
                                <input type="text" class="form-label form-control" id="first_name" name="first_name" required disabled>
                            </div>
                            <div class="form-group">
                                <label for="last-name">Last Name</label>
                                <input type="text" class="form-label form-control" id="last_name" name="last_name" required disabled>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" class="form-label form-control" id="dob" name="date_of_birth" required disabled>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" class="form-label form-control" id="phone" name="phone_number" required disabled>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-label form-control" id="address" name="address" required disabled>
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-label form-control" id="city" name="city" required disabled>
                            </div>
                            <div class="form-group">
                                <label for="state">State</label>
                                <input type="text" class="form-label form-control" id="state" name="state" required disabled>
                            </div>
                            <div class="form-group">
                                <label for="zip">Zip Code</label>
                                <input type="text" class="form-label form-control" id="zip" name="zip_code" required disabled>
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-label form-control" id="country" name="country" required disabled>
                            </div>
                            <div class="form-group">
                                <label for="profile_pic_file">Profile Picture</label>
                                <input type="file" class="form-label form-control" id="profile_pic_file" required name="profile_pic" disabled>
                            </div>
                            <div class="form-group">
                                <label for="about_me_text">About Me</label>
                                <textarea class="form-label form-control" id="about_me_text" required disabled></textarea>
                            </div>
                            <button class="btn btn-primary" id="update_profile">Update Profile</button>
                        </form>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script type="module" src="./scripts/user_profile.js"></script>
<?php
include("./footer.php");
?>