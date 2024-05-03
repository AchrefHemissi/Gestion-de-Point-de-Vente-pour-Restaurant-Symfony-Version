let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function () {
    sidebar.classList.toggle("active");
    if (sidebar.classList.contains("active")) {
        sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
    } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
};
function showCustomers() {
    document.getElementById("customersList").style.display = "block";
    document.getElementById("salesBoxes").style.display = "none";
    document.getElementById("ordersList").style.display = "none";
    document.querySelector(".chartcontainer").style.display = "none";
    document.getElementById("emailForm").style.display = "none";
}

function showDashboard() {
    document.getElementById("customersList").style.display = "none";
    document.getElementById("ordersList").style.display = "none";
    document.getElementById("salesBoxes").style.display = "flex";
    document.querySelector(".chartcontainer").style.display = "flex";
    document.getElementById("emailForm").style.display = "none";
}
function showOrders() {
    document.getElementById("customersList").style.display = "none";
    document.getElementById("ordersList").style.display = "block";
    document.getElementById("salesBoxes").style.display = "none";
    document.querySelector(".chartcontainer").style.display = "none";
    document.getElementById("emailForm").style.display = "none";
}
function showMessages() {
    document.getElementById("customersList").style.display = "none";
    document.getElementById("ordersList").style.display = "none";
    document.getElementById("salesBoxes").style.display = "none";
    document.querySelector(".chartcontainer").style.display = "none";
    document.getElementById("emailForm").style.display = "flex";
}

// Select all ban buttons
// Select all ban buttons
document.querySelectorAll(".ban-button").forEach((button) => {
    button.addEventListener("click", function () {
        var userId = this.getAttribute("data-id"); // Ensure that userId is being correctly retrieved

        // Optimistically update the button's color and text content
        var isBanned = button.textContent === "Ban User";
        button.textContent = isBanned ? "Unban User" : "Ban User";
        button.style.backgroundColor = isBanned ? "green" : "";

        fetch(`/toggle-user/${userId}`, {
            method: "POST",
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);

            })
            .catch((error) => {
                // If the fetch request failed, revert the button's color and text content and show an error message
                console.error('Error:', error);
                button.style.backgroundColor = isBanned ? "" : "green";
                button.textContent = isBanned ? "Ban User" : "Unban User";
                alert('An error occurred while trying to toggle the user\'s ban status.');
            });
    });
});