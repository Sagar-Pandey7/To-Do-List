document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    if (username === "test" && password === "12345") {
        alert("Login Successful!");
        window.location.href = "index.php";
    } else {
        alert("Invalid Username or Password!");
    }
});
