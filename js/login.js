
var userStillLoggedIn = 3000;

// Removes the "passlogin" parameter from the url when the login failed
function deleteGetURL() {
    var url = window.location.href;

    if (url.indexOf('passlogin=') !== -1) {
        var newURL = url.replace(/([?&])passlogin=[^&]+(&|$)/, '$1');
        
        window.history.replaceState({}, document.title, newURL);
    }
}

// Delete the parameter from the url
deleteGetURL();

// Assign events listeners when everything loaded
$(document).ready(function() {
    
    // Event listener for the password input field to remove every spaces
    $("#password").on("input", function(event) {
        $(this).val($(this).val().replace(/ +?/g, ''));
    });

    // Event listener for the login input field to remove every spaces AND special characters
    $("#login").on("input", function(event) {
        $(this).val($(this).val().replace(/[^a-zA-Z0-9]/g, ''));
    });

    // Event listener for the 'hide password' button
    let isRegisterPasswordShow = false;
    $("#hide-password").on("click", function() {
        if (isRegisterPasswordShow) {
            $("#hide-password").html('<i class="fa-solid fa-eye"></i>');
            $("#password").attr("type", "password");
            isRegisterPasswordShow = false;
        } else {
            $("#hide-password").html('<i class="fa-solid fa-eye-slash"></i>');
            $("#password").attr("type", "text");
            isRegisterPasswordShow = true;
        }
    });
});


