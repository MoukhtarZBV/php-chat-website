<?php session_start();
if (empty($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="css/chat.css">
    <script defer src="https://use.fontawesome.com/releases/v6.4.2/js/all.js"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <title>Chat</title>
</head>
<body>
    <main>
        <div id="logged-users-container">
            <div id="logged-users-header">Logged users</div>
            <div id="logged-users-list"></div>
        </div>
        <div id="chat-container">
            <div id="chat-header">
                <img id="profilePicture" src="<?php echo 'images/pfp/' . $_SESSION['pfp']; ?>">
                <p><?php echo $_SESSION["username"]; ?></p>
                <i class="fa-solid fa-right-from-bracket" id="logout" onclick="logout();"></i>  
            </div>
            <div id="chat-body"></div>
            <div id="chat-inputs-body">
                <div id="chat-inputs">
                    <input type="text" id="chat-message-input" name="message" placeholder="Saisissez un message..." autocomplete="off">
                    <div class='chat-option-separator'></div>
                    <i class="chat-option fa-solid fa-paper-plane" id="chat-message-submit" onclick = "sendMessage()"></i>
                </div>
            </div>
        </div>
    </main>

    <script src="js/messageInput.js"></script>
    <script src="js/chat.js"></script>
    
</body>
</html>
