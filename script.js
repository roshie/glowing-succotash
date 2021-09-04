$(document).ready(() => { 

    const page = window.location.pathname.split("/").pop(); 
    var _checkAuthStatus = checkAuthStatus();

    if (page == "index.html") { 

        _checkAuthStatus.then((msg) => {
            if (msg == 'success') {
                window.location.href = "profile.html";
            }
        })
        .catch((msg) => {
            if (msg == 'fail') {
                console.log('logged out')
            }
        })

        document.getElementById("loginform").addEventListener('submit', (e) => {
            e.preventDefault();
            document.getElementById('message-error').innerHTML = "";
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim(); 

            if ( email != "" && password != "")
                login(email, password);
            else 
                document.getElementById('message-error').innerHTML = "One of the fields is empty." 
        })

    } else if (page == "signup.html") { 

        _checkAuthStatus.then((msg) => {
            if (msg == 'success') {
                window.location.href = "profile.html";
            }
        })
        .catch((msg) => {
            if (msg == 'fail') {
                console.log('logged out');
            }
        })

        document.getElementById("signupform").addEventListener('submit', (e) => {
            e.preventDefault();
            document.getElementById('message-error').innerHTML = "";
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim(); 
            const confirmPassword = document.getElementById('confirmPassword').value.trim(); 
            const answer = document.getElementById('answer').value.trim();

            if ( email != "" && password != "" && confirmPassword != "" && answer != "") {
                if (password === confirmPassword) 
                    signup(email, password, answer);
                else 
                    document.getElementById('message-error').innerHTML = "Passwords does not match";
            } else 
                document.getElementById('message-error').innerHTML = "One or more fields are empty." 
        })

    } else if (page == "profile.html") { 

        _checkAuthStatus.then((msg) => {
            if (msg == 'success') {
                document.getElementById('email').innerHTML = localStorage.email;
            }
        })
        .catch((msg) => {
            if (msg == 'fail') {
                window.location.href = "index.html";
            }
        })

    } else if (page == "forget-password.html") {

        _checkAuthStatus.then((msg) => {
            if (msg == 'success') {
                window.location.href = "profile.html";
            }
        })
        .catch((msg) => {
            if (msg == 'fail') {
                console.log('logged out')
            }
        })
    }
    
});

function login(email, password) {
    $.ajax({
        type: "POST",
        url: "api/login.php",
        datatype: "html",
        data: {
            email: email, 
            password: password,
        },
        success: function (response) {  
            
            console.log(response) 
            try {
                 response = JSON.parse(response); 
            } catch {
                 document.getElementById('message-error').innerHTML = "There was a problem logging you in. Please Try again later."; 
            }
            if (response == "invalid") 
                document.getElementById('message-error').innerHTML = "Invalid Credentials";
            else if (response.authToken != null) { 
                localStorage.authToken = response.authToken;
                localStorage.email = email; 
                
                window.location.href = "index.html"; 
            } 
            else 
                  document.getElementById('message-error').innerHTML = "There was a problem logging you in. Please Try again later."; 
        }, 
        error: function (error) {}
    })
}

function signup(email, password, answer) {
    $.ajax({
        type: "POST",
        url: "endpoints/sign-up.php",
        datatype: "html",
        data: {
            email: email, 
            password: password, 
            answer: answer
        },
        success: function (response) { 
            response = JSON.parse(response); 
            if (response == "exists") 
                document.getElementById('message-error').innerHTML = "The Account with this email already exists. Try <a href='index.html'>Logging in.</a>";
            else if (response == "fail") 
                document.getElementById('message-error').innerHTML = "There was a problem while Signing up. Please Try again later."; 
            else {
                localStorage.authToken = response.authToken;
                localStorage.email = email;
                window.location.href = "profile.html";
            }
        }, 
        error: function (error) {}
    })
}

function checkAuthStatus() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: "api/auth-status.php",
            datatype: "html",
            data: {
                email: email, 
                authToken: authToken, 
            },
            success: function (response) {  
                console.log(response)
                response = JSON.parse(response);  
                
                if (response == "success") { 
                    resolve('success');
                } else {
                    reject('fail');
                }
            }, 
            error: function (error) {}
        })
    });
} 

function logout() { 
    $.ajax({
        type: "POST",
        url: "api/logout.php",
        datatype: "html",
        data: {
            email: localStorage.email, 
        },
        success: function (response) { 
            response = JSON.parse(response); 
            if (response == "success") { 
                 localStorage.removeItem("email");
                 localStorage.removeItem("authToken");
                window.location.href = "index.html";
            } else {
                 window.location.href = "index.html";
            }
        }, 
        error: function (error) {}
    })
 } 