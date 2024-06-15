
const submitBtn = document.getElementById("submit-btn");
submitBtn.addEventListener("click", (e) =>{
e.preventDefault();
sendData();
})


function sendData() {
    // Data to be sent

    var data = {
        uName: `${document.getElementById("username").value}`,
        email: `${document.getElementById("email").value}`,
        pass : `${document.getElementById("password").value}`,
        status : "true",
    };

    // Fetch API
    fetch('./php.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(responseText => {
        // Handle the response from the PHP script
        if(responseText.status === 101){
            console.log(responseText.data);
        } else {
            console.log(responseText.data);
        }
    })
    .catch(error => {
        // Handle errors
        console.error('Error:', error);
    });
}


