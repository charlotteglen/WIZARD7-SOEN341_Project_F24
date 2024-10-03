const signUpButton = document.getElementById('signUpButton');
const signInButton = document.getElementById('signInButton');
const signInForm = document.getElementById('signIn');
const signUpForm = document.getElementById('signup');

// shows the sign-up form and hides the sign-in form
signUpButton.addEventListener('click', function() 
{
    // hides sign-in form
    signInForm.style.display = "none"; 
    // shows sign-up form
    signUpForm.style.display = "block"; 
});

// show the sign-in form and hides the sign-up form
signInButton.addEventListener('click', function() 
{
    // hides sign-up form
    signUpForm.style.display = "none"; 
    // shows sign-in form
    signInForm.style.display = "block"; 
});
