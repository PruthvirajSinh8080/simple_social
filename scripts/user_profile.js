import { redAlert } from "./alerts.js";
import { handleData } from "./function.js";

redAlert();
//html nodes to show the user info received from server
let editBtn = document.getElementById("edit_profile");
let form = document.getElementById("profile_form");
let editChoice = true;
let addressPara = document.getElementById("address_p");
let phonePara = document.getElementById("phone_p");
let aboutMePara = document.getElementById("about_me_p");
let profile_pic = document.getElementById("profile_pic");
let first_name = document.getElementById("first_p");
let last_name = document.getElementById("last_p");
let dob_p = document.getElementById("dob_p");
let city_p = document.getElementById("city_p");
let zipcode_p = document.getElementById("zipcode_p");
let state_p = document.getElementById("state_p");
let country_p = document.getElementById("country_p");
let lastOnline = document.getElementById("last_online_p");
let update_profile_btn = document.getElementById("update_profile");

//form fields  to accsess them for manipulation
let firstName = document.getElementById("first_name");
let lastName = document.getElementById("last_name");
let dateOfBirth = document.getElementById("dob");
let phoneNumber = document.getElementById("phone");
let address = document.getElementById("address");
let city = document.getElementById("city");
let state = document.getElementById("state");
let zipCode = document.getElementById("zip");
let country = document.getElementById("country");
let profilePic = document.getElementById("profile_pic_file");
let aboutMe = document.getElementById("about_me_text");

editBtn.addEventListener("click", (e) => {
  e.preventDefault;

  if (editChoice === true) {
    //set the form to visible
    form.style.display = "block";

    firstName.removeAttribute("disabled");
    lastName.removeAttribute("disabled");
    dateOfBirth.removeAttribute("disabled");
    phoneNumber.removeAttribute("disabled");
    address.removeAttribute("disabled");
    city.removeAttribute("disabled");
    state.removeAttribute("disabled");
    zipCode.removeAttribute("disabled");
    country.removeAttribute("disabled");
    profilePic.removeAttribute("disabled");
    aboutMe.removeAttribute("disabled");

    editChoice = false;
    console.log(editChoice);
    return editChoice;
  } else {
    //set form to invisible
    form.style.display = "none";

    firstName.setAttribute("first_name", "disabled");
    lastName.setAttribute("last_name", "disabled");
    dateOfBirth.setAttribute("dob", "disabled");
    phoneNumber.setAttribute("phone", "disabled");
    address.setAttribute("address", "disabled");
    city.setAttribute("city", "disabled");
    state.setAttribute("state", "disabled");
    zipCode.setAttribute("zip", "disabled");
    country.setAttribute("country", "disabled");
    profilePic.setAttribute("profile_pic_file", "disabled");
    aboutMe.setAttribute("about_me_text", "disabled");

    editChoice = true;
    console.log(editChoice);
    return editChoice;
  }
});

async function loadProfileInfo() {
  let profileForm = document.getElementById("profile_form");
  let arrgument = "loadData";

  const profileData = await fetch("get_profile_data.php?q=loadData", {
    method: "POST",
    body: arrgument,
  });
  let data = await profileData.json();
  if (data) {
    if (data.first_name) {
      firstName.value = data.first_name;
      first_name.textContent = "First Name :- " + data.first_name;
    }

    if (data.last_name) {
      lastName.value = data.last_name;
      last_name.textContent = "Last Name :- " + data.last_name;
    }

    if (data.dob) {
      dob.value = data.dob;
      dob_p.textContent = "D.O.B :- " + data.dob;
    }

    if (data.phone_number) {
      phoneNumber.value = data.phone_number;
      phonePara.textContent = "Mobile :- " + data.phone_number;
    }

    if (data.address) {
      address.value = data.address;
      addressPara.textContent = "Address :- " + data.address;
    }

    if (data.city) {
      city.value = data.city;
      city_p.textContent = "City :- " + data.city;
    }

    if (data.state) {
      state.value = data.state;
      state_p.textContent = "State :- " + data.state;
    }

    if (data.zip_code) {
      zipCode.value = data.zip_code;
      zipcode_p.textContent = "Zip Code :- " + data.zip_code;
    }

    if (data.country) {
      country.value = data.country;
      country_p.textContent = "Country :- " + data.country;
    }

    if (data.profile_pic) {
      profile_pic.src = "./images/" + data.profile_pic;
    }

    if (data.about_me) {
      aboutMe.value = data.aboutMe;
      aboutMePara.textContent = data.aboutMe;
    }

    if (data.last_online) {
      lastOnline.textContent = "Last Online :- " + data.last_online;
    }
  } else {
    throw new Error("Can't Get user profile data. try again.");
  }
}
loadProfileInfo();

update_profile_btn.addEventListener("click", async (e) => {
  e.preventDefault();
  try {
    const updateDate = new FormData();
    updateDate.append("first", firstName.value);
    updateDate.append("last", lastName.value);
    updateDate.append("dob", dateOfBirth.value);
    updateDate.append("phone", phoneNumber.value);
    updateDate.append("address", address.value);
    updateDate.append("city", city.value);
    updateDate.append("state", state.value);
    updateDate.append("zip", zipCode.value);
    updateDate.append("country", country.value);
    updateDate.append("profile_pic", profilePic.files[0]);
    updateDate.append("about_me", aboutMe.value);

    let response = await fetch("get_profile_data.php?q=updateData", {
      method: "POST",
      body: updateDate,
    });

    let confirm = await response.json();
    form.style.display ="none",
    handleData(confirm);
    console.log(response);
  } catch (error) {
    console.error(error);
  }
});
