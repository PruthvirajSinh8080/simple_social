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

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="profile-pic.jpg" class="img-fluid rounded-circle" alt="Profile Picture">
                            </div>
                            <div class="col-md-8 align-middle">
                                <h3><?= $_SESSION['user_name'] ?></h3>
                                <p><?= $_SESSION['user_email'] ?></p>
                                <p><?php if (isset($_SESSION['user_address'])) {
                                        echo $_SESSION['user_address'];
                                    } else {
                                        echo "Address Is Not Provided.";
                                    }
                                    ?></p>
                                <p><?php if (isset($_SESSION['user_mobile'])) {
                                        echo $_SESSION['user_mobile'];
                                    } else {
                                        echo "Mobile Number Is Not Provided.";
                                    } ?></p>
                            </div>
                        </div>
                        <hr>
                        <h5>About Me</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet justo sit amet ante semper, eu dictum nulla cursus. Phasellus nec sapien nec lorem feugiat ultrices ac eu nisl.</p>
                        <h5>Interests</h5>
                        <p>Travel, Photography, Reading</p>

                        <p>Social: <a href="#">Facebook</a>, <a href="#">Twitter</a>, <a href="#">Instagram</a></p>
                    </div>
                </div>

                <!-- Post Creation Form -->
                <div class="card my-2">
                    <div class="card-body">
                        <form id="postForm">
                            <div class="mb-3">
                                <label for="postTitle" class="form-label">Title</label>
                                <input type="text" class="form-control" id="postTitle" placeholder="Enter post title" required>
                            </div>
                            <div class="mb-3">
                                <label for="postContent" class="form-label">Content</label>
                                <textarea class="form-control" id="postContent" rows="3" placeholder="Enter post content"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="postedia" class="form-label">Image</label>
                                <input class="form-control" type="file" id="postMedia" accept="image/*, video/*">
                            </div>
                            <button type="submit" id="submitPostData" class="btn btn-primary">Create Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="module" src="./scripts/uploadPost.js"></script>
<?php
include("./footer.php");
?>