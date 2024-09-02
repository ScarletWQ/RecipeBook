



        // registration//

        // Global variables for elements and regex patterns
        const emailElement = document.getElementById("email");
        const loginElement = document.getElementById("login");
        const passElement = document.getElementById("pass");
        const pass2Element = document.getElementById("pass2");
        const newsletterElement = document.getElementById("newsletter");
        const termsElement = document.getElementById("terms");

        const emailError = document.getElementById("email-error");
        const usernameError = document.getElementById("username-error");
        const passwordError = document.getElementById("password-error");
        const pass2Error = document.getElementById("re-type-password-error");
        const agreeTerm = document.getElementById("agree-term");

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Email pattern
        const passwdRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/; // Password pattern

    function validate() {
        let isValid = true;

            // Validate email
        const email = emailElement.value;
        if (!emailRegex.test(email)) {
            emailError.textContent = "x Email address should be non-empty with the format xyx@xyz.xyz.";
            emailElement.style.borderColor = "red";
            isValid = false;
        } else {
            emailError.textContent = "";
            emailElement.style.borderColor = "grey";
        }

            // Validate user name
        const login = loginElement.value.trim().toLowerCase();
        if (login === "" || login.length > 30) {
            usernameError.textContent = "x User Name should be non-empty and within 30 characters.";
            loginElement.style.borderColor = "red";
            isValid = false;
        } else {
            usernameError.textContent = "";
            loginElement.style.borderColor = "#ccc";
            //    loginElement.value = loginElement.value.toLowerCase();
        }

            // Validate password
        const password = passElement.value;
        if (!passwdRegex.test(password)) {
            passwordError.textContent = "x Password should be at least 8 characters long, with 1 uppercase, 1 lowercase, and 1 digit.";
            passElement.style.borderColor = "red";
            isValid = false;
        } else {
            passwordError.textContent = "";
        }

            // Validate re-typed password
        const pass2 = pass2Element.value;
        if (pass2 !== password) {
            pass2Error.textContent = "x Please re-type password correctly.";
            pass2Element.style.borderColor = "red";
            isValid = false;
        } else {
            pass2Error.textContent = "";
        }

        //error message for agreeTerm when newsletter checked.
        if ( !(termsElement.checked)) {
            agreeTerm.textContent = "x Please accept the terms and conditions.";
                isValid = false;
                } else {
                    agreeTerm.textContent = "";
                }
            if (isValid) {
                loginElement.value = loginElement.value.toLowerCase();
            } 
        return isValid;
    }

        //dynamic checking email input.
    function checkEmail() {
        const email = emailElement.value;
        if (!emailRegex.test(email)) {
            emailError.textContent = "x Email address should be non-empty with the format xyx@xyz.xyz.";
            emailElement.style.borderColor = "red";
        } else {
            emailError.textContent = "";
            emailElement.style.borderColor = "#ccc";
        }
    }

        //dynamic checking username input.
    function validateLogin() {
        const login = loginElement.value.toLowerCase();
        if (login === "" || login.length > 30) {
            usernameError.textContent = "x User Name should be non-empty and within 30 characters.";
        } else {
            usernameError.textContent = "";
            loginElement.style.borderColor = "#ccc";
        }
    }

        //dynamic checking password input.
    function validatePass() {
        const password = passElement.value;
        if (!passwdRegex.test(password)) {
            passwordError.textContent = "x Password should be at least 8 characters long, with 1 uppercase, 1 lowercase，and 1 digit.";
        } else {
            passwordError.textContent = "";
            passElement.style.borderColor = "#ccc";
        }
    }

        //dynamic checking passs2 input.
    function validatePass2() {
        const password = passElement.value;
        const pass2 = pass2Element.value;
        if (pass2 !== password) {
            pass2Error.textContent = "x Please retype password correctly.";
        } else {
            pass2Error.textContent = "";
            pass2Element.style.borderColor = "#ccc";
        }
    }

    //Alert when newsletter checked.
    function validateTerm() {
        const newsletter = newsletterElement.checked;
            const terms = termsElement.checked;
        if (newsletter) {
            alert("Thank you for subscribing to our newsletter! You will be receiving our newsletter.");
            agreeTerm.textContent = "x Please accept the terms and conditions.";
        } 
    }

        //add event listener to the newsletter on change.
    document.termsElement.addEventListener('change', validateTerm);

        //clear agree term error message on click agree.
    function checkTerm() {
        if (newsletter) {
            agreeTerm.textContent = "";
        }
    }

        //Clear error message on click reset button;
    function clearError() {
        emailError.textContent = "";
        usernameError.textContent = "";
        passwordError.textContent = "";
        pass2Error.textContent = "";
        agreeTerm.textContent = "";
    
        emailElement.style.borderColor = "#ccc";
        loginElement.style.borderColor = "#ccc";
        passElement.style.borderColor = "#ccc";
        pass2Element.style.borderColor = "#ccc";
    }

