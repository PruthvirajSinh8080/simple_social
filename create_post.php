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
<div class="container mt-2  d-flex flex-column justify-content-center align-items-center ">
    <div class="alert alert-danger " style="display: none  " id="red-alert" role="alert"></div>
    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-md-8">

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
                            <div class="mb-2">
                                <label for="postedia" class="form-label">Image</label>
                                <input class="form-control" type="file" id="postMedia" accept="image/*, video/*">
                            </div>
                            <div id="upload-progress" class="progress m-auto mb-2" style="height: 6px; display: none;">
                                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%; height: 100%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <button type="submit" id="submitPostData" class="btn btn-primary">Create Post</button>
                        </form>
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