// show popovers to page -- --  --  --  --  --  used on (signup.php,signin.php)
export function loadPopOvers() {
  document.addEventListener("DOMContentLoaded", function () {
    var popoverTriggerList = [].slice.call(
      document.querySelectorAll('[data-bs-toggle="popover"]')
    );
    var popoverList = popoverTriggerList.map(function (element) {
      return new bootstrap.Popover(element);
    });
  });
}
//// generate rendome  password ---------
export function randomPassCode(length) {
  var charset =
    "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]:;?><,./-=";
  var password = "";

  for (var i = 0; i < length; i++) {
    var randomIndex = Math.floor(Math.random() * charset.length);
    password += charset[randomIndex];
  }

  return password;
}
//// checks if the pass match with the confirm pass used on --  --  (signup.php)
export function checkPassIsMatch() {
  let pass = document.getElementById("user-pass");
  let conPass = document.getElementById("user_confirm-pass");
  if (pass.value === conPass.value) {
    console.log("pass match");
    return true;
  }

  console.log("pass doenst match.");
  return false;
}
//// used to check and send data to server for validation
export function UserInfo() {
  const userData = {
    username: `${document.getElementById("user-name").value}`,
    email: `${document.getElementById("user-email").value}`,
    password: `${document.getElementById("user_confirm-pass").value}`,
  };
  //send data to server
  fetch("./signup_controller.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(userData),
  }) //check the response from server is not empty
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    }) //handle data received from server
    .then((serverData) => {
      // Handle the response from the PHP script
      handleData(serverData, userData);
    });
}
export function hideAlert() {
  let RedAlert = document.getElementById("alert");
  setTimeout((RedAlert.style.display = "none"), 3000);
  // RedAlert.style.display = "none";
}
export function redAlertDanger(data) {
  if (typeof data === "object") {
    let RedAlert = document.getElementById("red-alert");
    RedAlert.style.display = "block";
    RedAlert.classList.add("alert-danger");
    RedAlert.classList.remove("alert-success");
    RedAlert.textContent = data.errMsg;
  }

  if (typeof data === "string") {
    let RedAlert = document.getElementById("red-alert");
    RedAlert.style.display = "block";
    RedAlert.classList.add("alert-danger");
    RedAlert.classList.remove("alert-success");
    RedAlert.textContent = data;
  }
}
export function redAlertGreen(data) {
  if (typeof data === "object") {
    let RedAlert = document.getElementById("red-alert");
    RedAlert.classList.remove("alert-danger");
    RedAlert.classList.add("alert-success");
    RedAlert.textContent = data.successMsg;
    RedAlert.style.display = "block";
  }

  if (typeof data === "string") {
    let RedAlert = document.getElementById("red-alert");
    RedAlert.style.display = "block";
    RedAlert.classList.add("alert-danger");
    RedAlert.classList.remove("alert-success");
    RedAlert.textContent = data;
  }
}
//handle error from server
export function handleData(data, data2 = null) {
  if (data.type === "error") {
    console.log(data.errId);
    redAlertDanger(data);
    console.log("redirecting....");
    if (data.errId == "email_verification_panding") {
      sessionStorage.setItem("UserEmail", data.userEmail);
    }
    // Redirect after a delay (e.g., 3 seconds)
    if (data.redirect !== null && data.redirect !== "") {
      redirectUser(data.redirect);
    }
    return false;
  } else {
    console.log(data.successId);
    //check if data2 is passed as second parameter
    if (data2 !== null) {
      sessionStorage.setItem("userNameEncrypt", btoa(data2.username));
      sessionStorage.setItem("userEmailEncrypt", btoa(data2.email));
      // sessionStorage.setItem("userPassEncrypt", btoa(data2.password));
      console.log("items sets.");
    }
    redAlertGreen(data);
    // console.log("redirecting....");
    // Redirect after a delay (e.g., 3 seconds)
    if (data.redirect !== null && data.redirect !== "") {
      redirectUser(data.redirect);
    }
    return true;
  }
}
export function redirectUser(data) {
  setTimeout(() => {
    window.location.href = `./${data}.php?`;
  }, 3000);
}
// use to check the password include this patterns also
export function passCheck(pass) {
  const regex =
    /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*-+=/?.,<>;':"`~])/;
  return regex.test(pass);
}
export function isPassStrong(pass, btn) {
  let passStrength = document.getElementById("pass-strength");
  let progressBar = document.getElementById("progress-bar");
  let submitBtn = document.getElementById(btn);
  if (!pass.length) {
    passStrength.style.display = "none";
    submitBtn.classList.add("disabled");
    // console.log("password is empty");
    return false;
  } else {
    passStrength.style.display = "block";
    progressBar.style.width = (pass.length * 100) / 10 + "%";
    // console.log(`pass is ${pass.length} character.`)
    if (pass.length <= 10) {
      if (pass.length >= 5) {
        progressBar.classList.add("bg-warning");
        progressBar.classList.remove("bg-danger", "bg-success");
        submitBtn.classList.add("disabled");
        // console.log("pass warning");
        return false;
      } else {
        progressBar.classList.add("bg-danger");
        progressBar.classList.remove("bg-warning", "bg-success");
        submitBtn.classList.add("disabled");
        // console.log("pass danger");
        return false;
      }
    } else {
      if (passCheck(pass) && pass.length >= 10) {
        progressBar.classList.add("bg-success");
        progressBar.classList.remove("bg-danger", "bg-warning");
        submitBtn.classList.remove("disabled");
        // console.log("btn enable")
        return true;
      } else if (!passCheck(pass) && pass.length >= 10) {
        progressBar.classList.add("bg-warning");
        progressBar.classList.remove("bg-danger", "bg-success");
        submitBtn.classList.add("disabled");
        // console.log("btn should be diabled")
        return false;
      } else {
        submitBtn.classList.add("disabled");
        // console.log("btn diabled");
        return false;
      }
    }
  }
}
// use a button to show and hide password value if clicked
export function showPass(passBtn, passvalue, conpassvalue = undefined) {
  let showPassBtn = document.getElementById(passBtn);
  let passValue = document.getElementById(passvalue);
  let conPassValue = document.getElementById(conpassvalue);

  showPassBtn.addEventListener("click", () => {
    if (passValue.type === "password") {
      passValue.type = "text";
      showPassBtn.textContent = "Hide";
      if (conPassValue !== undefined) {
        conPassValue.type = "text";
      }
      // console.log("yes");
    } else {
      passValue.type = "password";
      showPassBtn.textContent = "Show";
      if (conPassValue !== undefined) {
        conPassValue.type = "password";
      }
      // console.log("no")
    }
    return;
  });
}
////this function send info to server and get authenticity from server to log in user used on --    --  --  --  --      --      --      --   (signin.php)
export function verifyUserInfo() {
  console.log("runs..step 1");
  const userData = {
    userOrEmail: `${document.getElementById("user-or-email").value}`,
    password: `${document.getElementById("user-pass").value}`,
  };
  // console.log("userdata builded and crossing it")
  // console.log(userData)
  //send data to server
  fetch("./signin_controller.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(userData),
  })
    .then((response) => {
      // console.log("got the response.. and cheking it")

      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json(); // Parse JSON directly here
    })
    .then((data) => {
      // console.log(data + "    here");
      sessionStorage.setItem("u_id", data.u_id);
      handleData(data, userData);
    })
    .catch((error) => {
      console.log("error is thrown");
      console.error("Error:", error);
    });
}
// check if user try to access the site without loging in
export function unaothorizedLoggig() {
  let alert = document.getElementById("red-alert");
  // Extract the error message from the URL
  const urlParams = new URLSearchParams(window.location.search);
  const errorParam = urlParams.get("error");

  // Display the error message if it exists
  if (errorParam) {
    // Decode the error message (if it was URL-encoded)
    const errorMessage = decodeURIComponent(errorParam);
    alert.style.display = "block";
    alert.textContent = errorMessage;

    setTimeout(() => {
      alert.style.display = "none";
    }, 10000);
  }
}
// --------------------- email Verification page ------------------------------
// check if the item is set or can be set by this if not
export function checkSessionItemIsSet(item) {
  if (sessionStorage.getItem(item) !== null) {
    // console.log("inside of decrypted loop")
    let userEmailValue = sessionStorage.getItem(item);
    let userEmailDcrypted = atob(userEmailValue);
    let userEmail = document.getElementById("user-email");
    userEmail.value = userEmailDcrypted;
    return true;
  } else {
    let userEmail = document.getElementById("user-email");
    let userEmailValue = sessionStorage.getItem("UserEmail");
    // console.log(userEmailValue);
    userEmail.value = userEmailValue;
  }
}
export async function sendOtp(otp) {
  let email = document.getElementById("user-email");
  let sendBtn = document.getElementById("sendOtp");
  sendBtn.textContent = "Resend OTP";
  // if otp is not submited for the first time..
  if (otp !== "sented" && email !== null) {
    //if user is redirected from signup or login page the value of email is set automatically and asigned to Email to send to server
    if (
      checkSessionItemIsSet(
        "userEmailEncrypt",
        "user-email",
        "readonly",
        "email-p",
        "Please Provide Your Email Address.."
      )
    ) {
      email = atob(sessionStorage.getItem("userEmailEncrypt"));
      // console.log(email + "   1");
    }
    //create pass for verify
    let ranPassCode = randomPassCode(8);
    //seting the pass to session for checking
    sessionStorage.setItem("verify-Passcode", ranPassCode);
    const data = {
      //data to be sent to server for sending email to user
      Email: email,
      ranPass: ranPassCode,
      OTP: otp,
    };
    try {
      const response = await fetch("./sendEmail.php", {
        method: "POST",
        body: JSON.stringify(data),
      });
      let ranPassFromServer = await response.json();
      // console.log(ranPassFromServer);
      otp = "sented";
      document.getElementById("verificationCode").value =
        ranPassFromServer.ranPass;
      return otp;
    } catch (error) {
      console.error(error);
    }
    //it set otp that means otp is sented now verify it

    console.log(otp + "otp at end");
    return otp;
  }
}
export async function verifyPasscode(otp) {
  let verifyCode = document.getElementById("verificationCode");
  let userEmail = document.getElementById("user-email");
  console.log("Button clicked. otp:", otp);
  if (otp === "sented") {
    console.log("if statement run. otp:", otp);
    verifyBtn.disabled = false;
    if (verifyCode.value === sessionStorage.getItem("verify-Passcode")) {
      const data = {
        userEmail: userEmail.value,
        acStatus: "1",
      };
      try {
        const response = await fetch("./signin_controller.php?verifyed", {
          method: "POST",
          body: JSON.stringify(data),
        });
        console.log("verify-Passcode match.");
        sessionStorage.removeItem("verify-Passcode");

        const responseData = await response.json();
        console.log(responseData);
        handleData(responseData);
      } catch (error) {
        console.error(error);
      }
    } else {
      let RedAlert = document.getElementById("red-alert");
      RedAlert.style.display = "block";
      RedAlert.classList.add("alert-danger");
      RedAlert.textContent = "The Verify-Passcode Does Not Match.";
      console.log("verify-Passcode does not match.");
    }
    otp = null;
    return otp;
  } else {
    console.log("else of verify func. otp:", otp);
  }
}
//-----------------------------------------------------
//------------------Forget Password -------------------
export function forgetPass() {
  let email = document.getElementById("email");
  let RedAlert = document.getElementById("red-alert");
  RedAlert.style.display = "none";
  //check if email is not empty befor sending to the server
  if (!email.value) {
    redAlertDanger("Email Should Not Empty.");
    return false;
  }
  //send email info to check if the enterd email is registerd to site
  fetch("./sendEmail.php?forget", {
    method: "POST",
    body: JSON.stringify(email.value),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error();
      }
      return response.json();
    })
    .then((data) => {
      if (data.type === "error") {
        redAlertDanger(data);
        if (data.redirect !== null && data.redirect !== "") {
          redirectUser(data.redirect);
        }
      } else {
        redAlertGreen(data);
      }
      let ranPassCode = randomPassCode(8);
      const info = {
        //data to be sent to server for sending email to user
        Email: data.email,
        ranPass: ranPassCode,
        OTP: "sented",
      };
      try {
        fetch("./sendEmail.php?forgetotp", {
          method: "POST",
          body: JSON.stringify(info),
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error();
            }
            return response.json();
          })
          .then((data) => {
            if (data.type === "error") {
              redAlertDanger(data);
            } else {
              redAlertGreen(data);
              sessionStorage.setItem("forgetOTP", data.ranPass);
              console.log("forgetpass is set to session storege");
              let otpDiv = document.getElementById("otpDiv");
              otpDiv.classList.remove("collapse");
            }
          });
      } catch (error) {
        console.error(error);
      }
    })
    .catch((error) => {
      console.error("error :-", error);
    });
}
export function verifyForgetOtp() {
  console.log("start verify");
  let forgetOTP = document.getElementById("forgetOtp");
  let verifyOTPbtn = document.getElementById("verifyOTP");
  let RedAlert = document.getElementById("red-alert");
  RedAlert.style.display = "none";
  //check if email is not empty befor sending to the server
  verifyOTPbtn.addEventListener("click", (e) => {
    if (forgetOTP.value === sessionStorage.getItem("forgetOTP")) {
      console.log("cheking pass otp");
      let newPassDiv = document.getElementById("newPassDiv");
      newPassDiv.classList.remove("collapse");

      //calls the isPassStrong function to show pass strength meter
      const userPassInput = document.getElementById("newPass");
      userPassInput.addEventListener("input", (e) => {
        isPassStrong(userPassInput.value, "newPassBtn");
      });
    } else {
      redAlertDanger("Enter OTP Here.");
    }
  });
  console.log("end verify");
}
export function changePass() {
  let conNewPass = document.getElementById("conNewPass");
  let newPass = document.getElementById("newPass").value;
  const data = {
    newPass: newPass,
  };
  hideAlert();
  if (newPass === conNewPass.value) {
    fetch("./update_pass.php?updatePass", {
      method: "POST",
      body: JSON.stringify(data),
    })
      .then((res) => {
        if (res.ok) {
          let data = res.json();
          return data;
        } else {
          return new Error();
        }
      })
      .then((data) => {
        handleData(data);
      })
      .catch((error) => {
        console.error("error :-", error);
      });
  } else {
    redAlertDanger("Password Did Not Match.");
  }
}
//--------------------- post logic-----------
export async function loadPost(currentOffset) {
  const postDiv = document.getElementById("post");

  // get posts from database

  try {
    // console.log(currentOffset);
    const response = await fetch("dashboard_controller.php?", {
      method: "POST",
      body: JSON.stringify(currentOffset),
    });
    if (!response.ok) {
      throw new Error(`Server responded with status: ${response.status}`);
    }
    const feedData = await response.json();

    feedData.forEach((feed) => {
      //calls post body createing function
      createPostBody(feed);
    });

    // turn off the loading animation

    return feedData.length;
  } catch (error) {
    console.error("Error fetching data:", error);
    return null;
  }
}
///templet for post body
export function createPostBody(feed) {
  const postDiv = document.getElementById("post");

  const card = document.createElement("div");
  card.classList.add("card", "mt-2");

  const cardBody = document.createElement("div");
  cardBody.classList.add("card-body", "border");

  const postInfo = document.createElement("div");
  postInfo.classList.add(
    `${feed.post_id}`,
    "d-flex",
    "align-items-center",
    "mb-1"
  );

  const userPic = document.createElement("img");
  userPic.classList.add("user-pic", "rounded");
  userPic.src = `images/${feed.user_profile_pic}`;
  userPic.alt = "Profile_Picture ";
  userPic.width = "40";
  userPic.height = "40";

  const userDetails = document.createElement("div");
  userDetails.classList.add("user-details", "ms-2");

  //user name div of post

  const userName = document.createElement("div");
  userName.classList.add("user-name", "fw-bold");
  userName.textContent = feed.u_name;

  //upload time div for post

  const PostCreationTime = document.createElement("div");
  PostCreationTime.classList.add("post-time", "text-muted");
  PostCreationTime.textContent = new Date(feed.created_at).toLocaleString();

  // title div for post

  const title = document.createElement("h5");
  title.classList.add("card-title", "my-1");
  title.textContent = feed.title;

  //image div for post

  const imageDiv = document.createElement("div");
  imageDiv.classList.add("card-img", "border");

  //this make decision if the type of media is image or video

  const mediaContainer = document.createElement("div");
  if (feed.media_type == "image/jpeg") {
    const image = document.createElement("img");
    image.src = `images/${feed.media}`;
    image.alt = "";
    image.classList.add("img-fluid", "card-img-top", "p-1");
    mediaContainer.appendChild(image);
  } else {
    const video = document.createElement("video");
    video.src = `images/${feed.media}`;
    video.controls = true; // Adds play, pause, volume controls
    video.classList.add("img-fluid", "card-img-top", "p-1");
    mediaContainer.appendChild(video);
  }

  //discription area for post

  const description = document.createElement("div");
  description.classList.add("my-2", "mx-2");
  description.textContent = feed.post_content;

  const buttonsDiv = document.createElement("div");
  buttonsDiv.classList.add("d-flex", "gap-2", "w-100", "my-2");

  //---------like button--------//

  const likeButton = document.createElement("button");
  likeButton.classList.add("btn", "btn-primary", "likes");
  likeButton.type = "button";
  likeButton.innerHTML = `<b>${feed.like_count}</b> Like`;

  // Attach event listener to the like button
  likeButton.addEventListener("click", async function (event) {
    try {
      await likePost(feed.post_id, event);
    } catch (error) {
      console.error("An error occurred while liking the post:", error);
    }
  });

  //---------comment button--------//

  const commentButton = document.createElement("button");
  commentButton.classList.add("btn", "btn-secondary");
  commentButton.type = "button";
  commentButton.setAttribute("data-toggle", "modal");
  commentButton.setAttribute("data-target", "#comment_popup");
  commentButton.innerHTML = `<b>${feed.comment_count}</b> Comments`;

  //update the comment count as user adds one
  async function handlePostComment(event, postId) {
    try {
      /////// Extract the current number of comments
      let currentCommentCount = parseInt(
        commentButton.querySelector("b").textContent.match(/\d+/)[0]
      );

      //////// Update the comment count on the button
      const commentPosted = await sendComment(postId, event);
      if (commentPosted) {
        commentButton.querySelector("b").textContent = `${
          currentCommentCount + 1
        }`;
      }
    } catch (error) {
      console.error("An error occurred while posting the comment:", error);
    }
  }

  // Attach event listener to comment button
  commentButton.addEventListener("click", async function (event) {
    try {
      // Load comments from the database when the user clicks the comment button
      await loadComment(feed.post_id, event);

      let sendCommentBtn = document.getElementById("post_comment");

      // Remove any existing event listener to avoid multiple triggers
      sendCommentBtn.replaceWith(sendCommentBtn.cloneNode(true)); // Clone the button to remove all existing listeners
      sendCommentBtn = document.getElementById("post_comment"); // Get the new button with no listeners

      // Attach a new event listener for posting a comment
      sendCommentBtn.addEventListener("click", (e) =>
        handlePostComment(e, feed.post_id)
      );
    } catch (error) {
      console.error("An error occurred while getting the post comment:", error);
    }
  });
  //---------share button--------//

  const shareButton = document.createElement("button");
  shareButton.classList.add("btn", "btn-info");
  shareButton.type = "button";
  shareButton.innerHTML = `<b>${feed.share_count}</b> Shares`;

  //append created divs to their respective parent div

  card.appendChild(cardBody);
  cardBody.appendChild(postInfo);
  postInfo.appendChild(userPic);
  postInfo.appendChild(userDetails);
  userDetails.appendChild(userName);
  userDetails.appendChild(PostCreationTime);
  cardBody.appendChild(title);
  cardBody.appendChild(imageDiv);
  imageDiv.appendChild(mediaContainer);
  cardBody.appendChild(description);
  cardBody.appendChild(buttonsDiv);
  buttonsDiv.appendChild(likeButton);
  buttonsDiv.appendChild(commentButton);
  buttonsDiv.appendChild(shareButton);

  return postDiv.appendChild(card);
}

//          ----upload post to database ----
export async function uploadPostData(submitPostBtn) {
  try {
    //gather info post data and
    let uploadProgress = document.getElementById("upload-progress");
    let ProgressBar = document.getElementById("progress-bar");
    let postTitle = document.getElementById("postTitle").value;
    let postContent = document.getElementById("postContent").value;
    let postMedia = document.getElementById("postMedia").files[0];

    // create a new form object and append post info to it
    let formData = new FormData();
    formData.append("u_id", sessionStorage.getItem("u_id"));

    if (postTitle !== "") {
      formData.append("postTitle", postTitle);
    }

    if (postContent !== "") {
      formData.append("postContent", postContent);
    }

    if (postMedia !== undefined) {
      formData.append("postMedia", postMedia);
    }
    //once the upload is started make upload bar visible
    uploadProgress.style.display = "block";
    ProgressBar.style.width = 0 + "%";
    submitPostBtn.classList.add("disabled");

    // Send data to the server
    const response = fetch("uploadPost.php?", {
      method: "POST",
      body: formData,
    });
    //wait for data to arrive from server
    const res = await response;

    if (!res.ok) {
      throw new Error("Network response was not ok for the first request");
    }

    const data = await res.json();
    //show the user that post is uploaded
    handleData(data);
    ProgressBar.style.width = data.percent + "%";
    ProgressBar.classList.add("bg-success");
    submitPostBtn.classList.remove("disabled");
    // console.log(data);
  } catch (error) {
    console.error("An error occurred:", error.message);
  }
}

//updated like count upon clicking it

export async function likePost(postId, event) {
  try {
    //extract current like count from string

    let currentLikeCount = parseInt(
      event.target.querySelector("b").textContent.match(/\d+/)[0]
    );
    //send like request to server
    const response = await fetch("Likes.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ postId: postId }),
    });

    if (!response.ok) {
      throw new Error("Network response was not ok.");
    }

    const res = await response.json();

    //updates the like count to the clicked like button
    if (res.type === "error") {
      event.target.querySelector("b").textContent = `${currentLikeCount - 1}`;
    }
    if (res.type === "success") {
      event.target.querySelector("b").textContent = `${currentLikeCount + 1}`;
    }
  } catch (error) {
    console.error("An error occurred:", error);
  }
}
function renderComment(comment_data) {
  // let commentBox = document.getElementById("comment_section");

  let commentCard = document.createElement("div");
  commentCard.classList.add("card", "mb-2");
  commentCard.id = "comment_card";

  let cardBody = document.createElement("div");
  cardBody.classList.add("card-body");

  let userInfoDiv = document.createElement("div");
  userInfoDiv.classList.add("d-flex", "align-items-center", "mb-1");

  let userPic = document.createElement("img");
  userPic.classList.add("user-pic");
  userPic.src = "images/" + comment_data.user_pic;
  userPic.width = 40;
  userPic.height = 40;
  userPic.alt = "User-Profile-pic";

  let userInfo = document.createElement("div");
  userInfo.classList.add("ms-2");

  let userNameDiv = document.createElement("div");
  userNameDiv.classList.add("fw-bold", "user_name");
  userNameDiv.textContent = comment_data.userName;

  let postTimeDiv = document.createElement("div");
  postTimeDiv.classList.add("text-muted", "small", "post_time");
  postTimeDiv.textContent = comment_data.commentTime;

  let commentContent = document.createElement("p");
  commentContent.classList.add("card-text", "ms-2", "comment_content");
  commentContent.textContent = comment_data.comment_content;

  commentCard.appendChild(cardBody);
  cardBody.appendChild(userInfoDiv);
  userInfoDiv.appendChild(userPic);
  userInfoDiv.appendChild(userInfo);
  userInfo.appendChild(userNameDiv);
  userInfo.appendChild(postTimeDiv);
  cardBody.appendChild(commentContent);

  return commentCard;
}

// loadcomment function that will load comment of  particular post in modal
export async function loadComment(postId, event) {
  //comment box div to get accese to it
  let commentBox = document.getElementById("comment-box");
  commentBox.textContent = "No Comments Yet, Be The First One To Comment...";

  //loader animation
  const loadingIndicator = document.querySelector(".loader");

  //close btn to close the modal that is poped up
  const closeBtn = document.getElementById("comment_close_btn");
  //loader is now visible
  loadingIndicator.style.display = "block";
  let modal = document.getElementById("comment_section");

  const response = await fetch("load_comment.php?q=getcomments", {
    method: "POST",
    body: postId,
  });

  let res = await response.json();
  // console.log(res);

  loadingIndicator.style.display = "none";

  // Load comments in a proper manner
  if (res.comment_data && res.comment_data.length > 0) {
    commentBox.textContent = ""; // Clear the placeholder text
    res.comment_data.forEach((comment) => {
      commentBox.appendChild(renderComment(comment));
    });
  } else {
    commentBox.textContent = "No comments to load"; // Set message if no comments
  }

  // commentBox.appendChild(renderComment(res.comment_data));
  // this removes the previously added comment from model so the modal only contains the current post's comment
  // closeBtn.addEventListener("click", (e) => {
  //   commentBox.innerHTML = "";
  // });
}

export async function sendComment(postId, event) {
  let commentText = document.getElementById("comment");
  let postBtn = document.getElementById("post_comment");

  const data = {
    text: commentText.value,
    post_id: postId,
  };

  try {
    if (!commentText.value) {
      console.log("message is empty");
      return false;
    } else {
      let response = await fetch("load_comment.php?q=setcomments", {
        method: "POST",
        body: JSON.stringify(data),
      });
      let confirm = await response.json();
      handleData(confirm);

      // this will add the newly append comment in the box so user can see it
      let commentBox = document.getElementById("comment-box");
      const closeBtn = document.getElementById("comment_close_btn");

      commentBox.appendChild(renderComment(confirm));

      return true;
    }
  } catch (error) {}
}
