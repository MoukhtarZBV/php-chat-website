<?php
session_start();
require "dbConnection.php";
require "messageDAO.php";
require "userDAO.php";

$pdo = createConnection();

// Retrieve the last 10 messages from the database
$messages = get30LastMessages($pdo);

// Updates the user's "last seen" column as he sent a request to the server
updateLastSeen($pdo, $_SESSION["username"]);

$lastSender = '';
$lastTimestamp = 0;
$firstGroup = true;
$messages = array_reverse($messages);

// Create a group of messages for each message sent by the same user in a row
foreach ($messages as $message) {
    // If the last message sender is different from the current message, 
    // or if the last message was sent more than 5 minutes before the current one, create a new group
    if ($message["userPseudo"] != $lastSender || differenceInMinutes($message["horaire"], $lastTimestamp) > 5) {
        if ($message["userPseudo"] != $lastSender) {
            $lastSender = $message["userPseudo"];
            $user = getUserByUsername($pdo, $message["userPseudo"]);
            $profilePicture = 'default-picture.png';
            if (!empty($user["pfp"])) {
                $profilePicture = $user["pfp"];
            }
        }
        
        $lastTimestamp = $message["horaire"];
        if (!$firstGroup) { 
            echo '</div>';
        } else {
            $firstGroup = false;
        }

        // Append a class to the div if the message comes from the logged user
        $classUserMe = '';
        if ($message["userPseudo"] == $_SESSION["username"]) {
            $classUserMe = 'user-me';
        }

        // Build the div containing the timestamp, the username and the profile picture
        echo '<div class="message-sender ' . $classUserMe . '">
                <img class="message-pfp" src="images/pfp/' . $profilePicture . '">
                <p class="message-infos ' . $classUserMe . '">
                    <span class="message-sender-username">'. $message["userPseudo"] .'</span><span class="message-sent-date">'. gmdate("H:i", $message["horaire"]) .'</span>
                </p>
            </div>';
        // Build the messages group
        echo '<div class="message-group ' . $classUserMe . '">';
    }

    // Append the new message to the messages group
    echo '<div class="message">'. $message["contenu"] .'</div>';
}

/**
 * Returns the difference, in minutes, between two timestamps
 * 
 * @param  int  $firstSentDate  The timestamp of the first message
 * @param  int  $secondSentHour The timestamp of the second message
 * @return int  The difference, in minutes, between the two timestamps
 */
function differenceInMinutes(int $firstMessageTimestamp, int $secondMessageTimestamp): int {
    return abs($firstMessageTimestamp - $secondMessageTimestamp) / 60;
}