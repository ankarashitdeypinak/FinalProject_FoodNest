document.addEventListener("DOMContentLoaded", function () {
    
    const registerForm = document.querySelector("form[action='register.php']") || document.querySelector("form");
    
    if (registerForm && registerForm.querySelector("input[name='confirm_password']")) {
        registerForm.addEventListener("submit", function (event) {
            const nameField = registerForm.querySelector("input[name='name']");
            const emailField = registerForm.querySelector("input[name='email']");
            const passwordField = registerForm.querySelector("input[name='password']");
            const confirmField = registerForm.querySelector("input[name='confirm_password']");
            const termsCheck = registerForm.querySelector("input[type='checkbox']");

            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (nameField && nameField.value.trim().length < 3) {
                alert("Name must be at least 3 characters long.");
                event.preventDefault();
                return false;
            }

            if (emailField && !emailRegex.test(emailField.value.trim())) {
                alert("Please enter a valid email address.");
                event.preventDefault();
                return false;
            }

            if (passwordField && passwordField.value.length < 6) {
                alert("Password must be at least 6 characters long.");
                event.preventDefault();
                return false;
            }

            if (passwordField && confirmField && passwordField.value !== confirmField.value) {
                alert("Passwords do not match. Please verify.");
                event.preventDefault();
                return false;
            }

            if (termsCheck && !termsCheck.checked) {
                alert("You must agree to the Terms & Conditions to register.");
                event.preventDefault();
                return false;
            }
        });
    }

    
    const loginForm = document.querySelector("form[action='login.php']");
    if (loginForm) {
        loginForm.addEventListener("submit", function (event) {
            const emailField = loginForm.querySelector("input[name='email']");
            const passwordField = loginForm.querySelector("input[name='password']");

            if (!emailField.value.trim() || !passwordField.value) {
                alert("Please fill in all fields.");
                event.preventDefault();
                return false;
            }
        });
    }
});