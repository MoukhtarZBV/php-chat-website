/**
 * Resets the input state and stores the sent message in the database
 */
function sendMessage() {
    var input = $("#chat-message-input");
    var message = input.val();

    var canSendMessage = canSend;
    disableMessageSubmitButton();
    input.val("");

    var msgWithoutSpaces = message.replace(' ', '');

    if (msgWithoutSpaces.length > 0 && canSendMessage) {
        $.ajax({
            type: 'GET',
            url: 'php/enregistrer.php',
            data: {
                message: message
            },
            success: function(data) {
                if (data) {
                    scrollDownChat();
                } 
            }
        });
    }
}

/**
 * Logs out the user
 */
function logout() {
    $.ajax({
        type: 'GET',
        url: 'php/loginOrRegister.php',
        data: {
            logout: true
        },
        success: function(data) {
            window.location.href = "index.php";
        }
    });
}

/** 
 * Scrolls down the chat
 */
function scrollDownChat() {
    let chat = document.getElementById("chat-body");
    chat.scrollTop = chat.scrollHeight;
}

/**
 * Updates the displayed messages every 400 miliseconds
 */
setInterval(function() {
    $.ajax({
        type: 'POST',
        url: 'php/recuperer.php',
        success: function(data) {
            if (data) {
                $("#chat-body").html(data);
            } else {
                $("#chat-body").html("<p>No message</p>");
            }
        }
    });
}, 400);

/**
 * Checks if two html contents are equal
 * 
 * @param {string} html1    First html content
 * @param {string} html2    Second html content
 * @returns                 TRUE if they are equal, FALSE else
 */
function htmlEquals(html1, html2) {
    return html1.replace(/\s/g, '') === html2.replace(/\s/g, '');
}

/**
 * Updates the logged users list every second
 */
setInterval(function() {
    $.ajax({
        type: 'GET',
        url: 'php/loggedUsers.php',
        success: function(data) {
            if (data) {
                if (!htmlEquals(data, $("#logged-users-list").html())) {
                    $("#logged-users-list").html(data);
                }
            } else {
                $("#logged-users-list").html("<p>No logged user</p>");
            }
        }
    });
}, 1000);


