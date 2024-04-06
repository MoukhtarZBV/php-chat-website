<?php
session_start();
date_default_timezone_set('Europe/Paris');
// If the user is disconnected (but, for some reason, a request is still sent), exit the script
if (empty($_SESSION)) {
    exit();
}

require "dbConnection.php";
require "messageDAO.php";
require "userDAO.php";

/**
 * Returns the difference, in minutes, between two timestamps
 * 
 * @param  int  $firstSentDate  The timestamp of the first message
 * @param  int  $secondSentHour The timestamp of the second message
 * @return int  The difference, in minutes, between the two timestamps
 */
function differenceInMinutes(int $firstMessageTimestamp, int $secondMessageTimestamp): float {
    return abs($firstMessageTimestamp - $secondMessageTimestamp) / 60.0;
}

$pdo = createConnection();

// Retrieve the last 10 messages from the database
$messages = get10LastMessages($pdo);

// Updates the user's "last seen" column as he sent a request to the server
updateLastSeen($pdo, $_SESSION["username"]);

$profilePicture = "default-picture.png";
$lastSender = "<em>Deleted user</em>";
$lastTimestamp = 0;
$firstGroup = true;
$messages = array_reverse($messages);

$messageGroups = array();
$formatedMessages = '';
$lastInsertedID = null;

$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('yesterday')); 

// Create a group of messages for each message sent by the same user in a row
foreach ($messages as $message) {
    // If the last message sender is different from the current message, 
    // or if the last message was sent more than 5 minutes before the current one, create a new group
    if ($message["userPseudo"] != $lastSender || differenceInMinutes($message["horaire"], $lastTimestamp) > 5.0) {

        if ($message["userPseudo"] != $lastSender) {
            $profilePicture = 'default-picture.png';
            // If the user has been deleted
            if (empty($message["userPseudo"])) {
                $lastSender = "<em>Deleted user</em>";
            } else {
                $lastSender = htmlspecialchars($message["userPseudo"]);
                $user = getUserByUsername($pdo, $message["userPseudo"]);
                if (!empty($user["pfp"])) {
                    $profilePicture = $user["pfp"];
                }
            }
        }
        
        $lastTimestamp = $message["horaire"];
        if (!$firstGroup) { 
            $formatedMessages .= '</div>';
            $messageGroups[] = array("messages" => $formatedMessages, "displayedIDs" => $displayedIDs);
            $displayedIDs = array();
            $formatedMessages = '';
        } else {
            $firstGroup = false;
        }

        // Append a class to the div if the message comes from the logged user
        $classUserMe = '';
        if ($message["userPseudo"] == $_SESSION["username"]) {
            $classUserMe = 'user-me';
        }

        $date = date('Y-m-d', ($message["horaire"] - 7200));
        if ($date == $today) {
            $messageTime = gmdate("H:i", $message["horaire"]);
        } else if ($date == $yesterday) {
            $messageTime = "Yesterday at " . gmdate("H:i", $message["horaire"]);
        } else {
            $messageTime = date('F jS', $message["horaire"]) . " at " . gmdate("H:i", $message["horaire"]);
        }

        // Build the div containing the timestamp, the username and the profile picture
        $formatedMessages .= '<div class="message-sender ' . $classUserMe . '">
                <img class="message-pfp" src="images/pfp/' . $profilePicture . '">
                <p class="message-infos ' . $classUserMe . '">
                    <span class="message-sender-username">'. $lastSender .'</span><span class="message-sent-date">'. $messageTime .'</span>
                </p>
            </div>';
        // Build the messages group
        $formatedMessages .= '<div class="message-group ' . $classUserMe . '">';
    }

    // Append the new message to the messages group
    $formatedMessages .= '<div class="message ' . $classUserMe . '" data-message-id="'. $message["idMessage"] .'">'. htmlspecialchars($message["contenu"]) .'</div>';

    // Store the message ID
    $displayedIDs[] = $message["idMessage"];
}

$messageGroups[] = array("messages" => $formatedMessages, "displayedIDs" => $displayedIDs);

echo json_encode($messageGroups);

