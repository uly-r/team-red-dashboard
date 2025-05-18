const form = document.getElementById('form');
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const password2 = document.getElementById('confirm_password');

// this list can be added onto 
const allowedDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'bmcc.cuny.edu', 'stu.bmcc.cuny.edu'];


form.addEventListener('submit', function (e) {
    e.preventDefault();
    validateInputs();
});

// simpy allows to set error messages for user
function setError(element, message) {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');

    errorDisplay.innerText = message;
    inputControl.classList.add('error');
    inputControl.classList.remove('success');
}


function setSuccess(element) {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');

    errorDisplay.innerText = '';
    inputControl.classList.add('success');
    inputControl.classList.remove('error');
}

// rules for user name
function isValidUsername(usernameValue) {
    if (usernameValue === '') {
        setError(username, 'Username is required');
        return false;
    } else if (usernameValue.length < 3) {
        setError(username, 'Username must be greater than 3 characters.');
        return false;
    } else if (usernameValue.length > 12) {
        setError(username, 'Username must be greater than 3 characters.');
        return false;
    }

    setSuccess(username);
    return true;
}

// password rules
function isValidPassword(passwordValue) {
    if (passwordValue === '') {
        setError(password, 'Please create a valid password');
        return false;
    } else if (passwordValue.length < 3) {
        setError(password, 'Password must be at least 3 characters.');  
        return false;
    } else if (passwordValue.length > 64) {
        setError(password, 'Password must not exceed 64 characters.');
        return false;
    }
    setSuccess(password);
    return true;
}

// password2 (confirm password) rules
function isValidPasswordConfirmation(passwordValue, password2Value) {
    const isPasswordValid = isValidPassword(passwordValue);

    //if the first password isnt valid, just hightlight it red, dont give an error
    if (!isPasswordValid) {
        setError(password2, '');
        return false;
    } else if (password2Value === '') {
        setError(password2, 'Please confirm your password');
        return false;
    } else if (password2Value !== passwordValue) {
        setError(password2, 'Passwords do not match');
        return false;
    } else {
        setSuccess(password2);
        return true;
    }
}


function isValidEmailInput(emailValue)
{
    if (emailValue === '')
    {
        setError(email, 'Email is required');
        return false;
    }
    else if (!isAllowedDomain(emailValue))
    {
        setError(email, 'Provide a valid email address');
        return false;
    }
    else
    {
        setSuccess(email);
        return true;
    }
}

 
function isAllowedDomain(emailValue) {
    const parts = emailValue.trim().toLowerCase().split('@'); //trim then split at the @ symbol
    if (parts.length !== 2) return false;       //checks for @ symbol
    const domain = parts[1];    //grabs domain part
    return allowedDomains.includes(domain); //returns true or false
}



function validateInputs() {
    //trim email and username, checks for empty fields in the validators
    const usernameValue = username.value.trim();
    const emailValue = email.value.trim();

    //No trimming password / allows user to have space characters for password
    const passwordValue = password.value;
    const password2Value = password2.value;

    let isUsernameValid = isValidUsername(usernameValue);
    let isEmailValid = isValidEmailInput(emailValue);
    let isPasswordValid = isValidPassword(passwordValue);
    let isPassword2Valid = isValidPasswordConfirmation(passwordValue, password2Value);

    //all checks must pass
    if (isUsernameValid && isEmailValid && isPasswordValid && isPassword2Valid) {
        form.submit();
    }
}
