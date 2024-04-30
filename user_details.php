<?php
session_start();

// Include your storage class and other necessary files
include_once("storage.php");

// Assuming the storage class can handle retrieving data
$userStorage = new Storage(new JsonIO('users.json'));
$cardStorage = new Storage(new JsonIO('cards.json'));

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Retrieve the user details
    $user = $userStorage->findById($userId);

    if ($user) {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>My Details</title>";
        echo "<style>";
        echo "body {";
        echo "    background-color: skyblue;";
        echo "    display: flex;";
        echo "    flex-direction: column;";
        echo "    align-items: center;";
        echo "    padding: 20px;";
        echo "}";
        // echo "p {";
        // echo "    font-weight: bold;";
        // echo "}";
        echo "</style>";
        echo "</head>";
        echo "<body>";

        echo "<h1>My Details</h1>";
        echo "<p>Username: <b> {$user['username']}</b></p>";
        echo "<p>Email: <b>{$user['email']}</b></p>";
        echo "<p>Amount of Money in Wallet:<b>{$user['amountOfMoneyInWallet']}.00 huf</b></p>";
        echo "<p>Number of Cards:<b>{$user['noOfCards']}</b></p>";

        // Display user's cards
        if (!empty($user['cards'])) {
            echo "<h2>My Cards</h2>";
            echo "<ul>";
            foreach ($user['cards'] as $cardName) {
                // Retrieve and display card details
                $card = $cardStorage->findOne(['name' => $cardName]);
                if ($card) {
                    echo "<li>";
                    echo "<strong>{$card['name']}</strong> - Type: {$card['type']} - Price: {$card['price']} Money";
                    echo "<img src='{$card['image']}' alt='{$card['name']}' style='max-width: 100px; max-height: 100px;'>";

                    echo "</li>";
                }
            }
            echo "</ul>";
        } else {
            echo "<p><h3>You don't own any cards.</h3></p>";
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid request.";
}
?>
