var secure8letters = false;
var secureCapital = false;
var secureSpecial = false;
var secureNumber = false;
var isValidPassword = false;
var isValidPasswordVerify = false;
var isValidLogin = false;

var userStillLoggedIn = 3000;

// When everything loaded
$(document).ready(function() {

    // Events listener

    // Event listener for the first password input
    $("#password").on("input", function(event) {
        passwordInputBehavior();
    });

    // Event listener for the second password input
    $("#password-verify").on("input", function() {
        passwordVerifyInputBehavior();
    });

    // Event listener for the login (username) input,
    // allowing the user to be notified if the username is already taken
    $("#login").on('input', function(event) {
        $("#login").val($("#login").val().replace(/[^a-zA-Z0-9]/g, ''));

        var login = $("#login").val();

        $.ajax({
            type: 'GET',
            url: 'php/usernameTaken.php',
            data: {
                username: login,
            },
            success: function(data) {
                if (data == 1) {
                    isValidLogin = false;
                    $("#secure-login-details").css("height", "15px");
                } else {
                    isValidLogin = true;
                    $("#secure-login-details").css("height", "0");
                }
            }
        });
    });

    // Event listener for the submit button
    $("#form-reg").on("submit", function(e) {
        if (isValidPassword && isValidPasswordVerify && isValidLogin) {
            return true;
        }
        e.preventDefault();
    });

    var isRegisterPasswordShow = false;
    // Event listener for the 'hide password' button
    $("#hide-password").on("click", function() {
        var element = $("#hide-password");

        if (isRegisterPasswordShow) {
            element.html('<i class="fa-solid fa-eye"></i>');
            $("#password").attr("type", "password");
            isRegisterPasswordShow = false;
        } else {
            element.html('<i class="fa-solid fa-eye-slash"></i>');
            $("#password").attr("type", "text");
            isRegisterPasswordShow = true;
        }
    });

    var isRegisterPasswordVerifyShow = false;
    // Event listener for the 'hide second password' button
    $("#hide-password-verify").on("click", function() {
        var element = $("#hide-password-verify");

        if (isRegisterPasswordVerifyShow) {
            element.html('<i class="fa-solid fa-eye"></i>');
            $("#password-verify").attr("type", "password");
            isRegisterPasswordVerifyShow = false;
        } else {
            element.html('<i class="fa-solid fa-eye-slash"></i>');
            $("#password-verify").attr("type", "text");
            isRegisterPasswordVerifyShow = true;
        }
    });
});

/**
 * Input behavior for the first password that notifies
 * the user if the password is strong enough or not by 
 * showing each unsatisifed rule and displaying a level
 * of security bar
 */
function passwordInputBehavior() {
    var content = $("#password").val().replace(' ', '');

    var formatSpecial = /^[a-zA-Z0-9]*$/;
    var formatCapital = /[A-Z]/;
    var formatNumber = /[0-9]/;


    secure8letters = content.length >= 8;
    secureCapital = formatCapital.test(content);
    secureSpecial = !formatSpecial.test(content);
    secureNumber = formatNumber.test(content);

    // For each unsatisfied password rule, show a dialog text 
    $("#secure-8letters").css("display", secure8letters ? 'none' : 'block');
    $("#secure-capital").css("display", secureCapital ? 'none' : 'block');
    $("#secure-special").css("display", secureSpecial ? 'none' : 'block');
    $("#secure-number").css("display", secureNumber ? 'none' : 'block');

    var sumSecure;

    // Change the password's security according to the content
    if (content.length == 0) {
        sumSecure = 0;
        $("#secure-password-details").css("height", "0");
    } else {
        sumSecure = secure8letters * 20 + 20 + secureCapital * 20 + secureSpecial * 20 + secureNumber * 20;
        if (sumSecure == 100) {
            isValidPassword = true;
            $("#secure-password-details").css("height", "0");
        } else {
            isValidPassword = false;
            $("#secure-password-details").css("height", "40px");
        }
    }

    var barWidth = sumSecure + "%";
    var barColor;

    // For each percentage of security for the password, change 
    // the color of the security tracking bar
    if (sumSecure <= 20) {
        barColor = "rgb(192, 57, 43)";
    } else if (sumSecure <= 40) {
        barColor = "rgb(231, 76, 60)";
    } else if (sumSecure <= 60) {
        barColor = "rgb(230, 126, 34)";
    } else if (sumSecure <= 80) {
        barColor = "rgb(241, 196, 15)";
    } else {
        barColor = "rgb(46, 204, 113)";
    }
    $("#secure-password").css("color", barColor);

    // Used to change the css variables value used by passwordDiv
    var passwordStyle = $("#passwordDiv").get(0).style;
    passwordStyle.setProperty('--register-bar-password-color', barColor);
    passwordStyle.setProperty("--register-bar-password-width", barWidth);

    passwordVerifyInputBehavior();
}

/* 
 * Input behavior for the second password that notifies the user
 * if the first password is not valid yet, if the second password
 * does not match the first one, or if the second password is valid too
*/
function passwordVerifyInputBehavior() {
    var contentPassword = $("#password").val().replace(' ', '');
    var contentConfirmPassword = $("#password-verify").val().replace(' ', '');

    // Used to change the css variables value used by passwordVerifyDiv
    var confirmPasswordStyle = $("#passwordVerifyDiv").get(0).style;

    // If the content of the "confirm password" is empty
    if (contentConfirmPassword.length == 0) {
        confirmPasswordStyle.setProperty('--register-bar-password-verify-width', '0%');
        $("#secure-password-verify-details").css("height", "0");
    } else {
        confirmPasswordStyle.setProperty('--register-bar-password-verify-width', '100%');
        $("#secure-password-verify-details").css("height", "15px");
    }

    // If both passwords matches
    if (contentPassword == contentConfirmPassword) {
        if (isValidPassword) {
            isValidPasswordVerify = true;
            confirmPasswordStyle.setProperty('--register-bar-password-verify-color', 'rgb(46, 204, 113)');
            $("#secure-password-verify-details").css("height", "0");
        } else {
            isValidPasswordVerify = false;
            confirmPasswordStyle.setProperty('--register-bar-password-verify-color', 'rgb(231, 76, 60)');
        }

    } else {
        isValidPasswordVerify = false;
        confirmPasswordStyle.setProperty('--register-bar-password-verify-color', 'rgb(231, 76, 60)');
    }

    if (isValidPassword) {
        $("#message-valid-verify").html("&#8226 Password does not match");
    } else {
        $("#message-valid-verify").html("&#8226 Password not valid yet");
    }
}