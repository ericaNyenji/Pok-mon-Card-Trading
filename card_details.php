<?php
include_once("storage.php");

// Create an instance of the Storage class with JsonIO as the data storage mechanism
$stor = new Storage(new JsonIO('cards.json'));

$cardId = $_GET['card_id'] ?? '';

// Assuming $cardId is the unique identifier for your card, you can fetch the card details based on this ID.

// Fetch the card details using your Storage class or any other method you have.
$card = $stor->findById($cardId);

if ($card) {
    echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . $card['name'] . ' Details</title>
            <style>
                body {
                    background-color: ' . getColorBasedOnType($card['type']) . ';
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    padding: 20px;
                }

                img {
                    max-width: 100%;
                    height: auto;
                    margin-right: 20px;
                }

                p {
                    margin: 10px 0;
                    font-weight: bold;
                }

                .back-to-main {
                    margin-top: 20px;
                    text-decoration: none;
                    margin-top: 20px;
                    text-decoration: none;
                    position: absolute;
                    top: 10px;
                    left: 10px;
                }
                
                
                
                
            </style>
        </head>
        <body>
        <h1>' . $card['name'] . ' </h1>
        <a href="main.php" class="back-to-main"><h3><b>Back to Main Page</b></h3></a>

        <div style="display: flex; align-items: center;">
    <img src="' . $card['image'] . '" alt="' . $card['name'] . ' Image">
    <div>       
        <p>Type: ' . $card['type'] . '</p>
        <p>HP: ' . $card['hp'] . '</p>
        <p>Attack: ' . $card['attack'] . '</p>
        <p>Defense: ' . $card['defense'] . '</p>
        <p>Price: ' . $card['price'] . '</p>
        <p>Description: ' . $card['description'] . '</p>
    </div>
</div>

         
        </body>
        </html>';
} else {
   
    echo 'Card not found';
}

// Function to get color based on the card's type
function getColorBasedOnType($type) {
    
    switch ($type) {
        case 'electric':
            return 'yellow';
        case 'fire':
            return '#FFA500'; 
        case 'grass':
            return 'green';
        case 'water':
            return '#87CEEB'; 
        case 'bug':
            return 'brown';
        case 'normal':
            return 'gray';
        case 'poison':
            return 'purple';
        default:
            return 'white';
    }
}
?>
