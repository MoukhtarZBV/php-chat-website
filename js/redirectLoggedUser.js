function redirectAlreadyLoggedUser() {
    $.get("php/userStillLoggedIn.php", function (data) {
        if (data == 1) {
            window.location = "chat.php";
        }
    });
}

redirectAlreadyLoggedUser();

/**
 * Checks if the user is already logged in in another tab
 *  and heads back to the chat if so
 */
setInterval(function() {
    redirectAlreadyLoggedUser();
}, userStillLoggedIn);