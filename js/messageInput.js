// Tracks the input's state (Can the user send a message or not ?)
var canSend = false;

/**
 * Enables the submit message button and allows the user to send a message
 */
function enableMessageSubmitButton() {
    $("#chat-message-submit").css({
        color: "var(--turquoise)",
        pointerEvents: "auto"
    });
    canSend = true;
}

/**
 * Disables the submit message button and prevents the user from sending a message
 */
function disableMessageSubmitButton() {
    $("#chat-message-submit").css({
        color: "var(--gray-02)",
        pointerEvents: "none"
    });
    canSend = false;
}

// When everything loaded
$(document).ready(function() {

    // Add a listener to the message input to send one when the "Enter" key is pressed
    $("#chat-message-input").on("keydown", function(e) {
        if (e.key == "Enter" && canSend) {
            sendMessage();
        }
    });

    // Add another listener to the message input to continuously track the user's input
    // and disable the submit option if nothing or only spaces have been input
    $("#chat-message-input").on("input", function() {
        if ($.trim($(this).val()) && !canSend) {
            enableMessageSubmitButton();
        } else if (!$(this).val()) { 
            disableMessageSubmitButton();
        }
    });
});
