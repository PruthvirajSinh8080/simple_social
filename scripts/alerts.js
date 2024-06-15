//shows the red-alert in site
export function redAlert() {

    let redAlert = document.getElementById("red-alert");

    if (redAlert.style.display == "block") {
        setTimeout(() => {
            redAlert.style.display = "none"
        }, 10000);
    } else {
        console.log("no. alert is not yet displayed")
    }
}
// $2y$10$jyMpZl/HSIvt0wNg8SNDq.o.RFYu03kwGKD4ZfaKzKBFEFvleAjMu
