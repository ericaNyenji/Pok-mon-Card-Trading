<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Card Trading</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
session_start();////starting a session. (Put at the very beginning of our document)>>.
// Check if there's a message in the query parameters
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
    $messageColor = isset($_GET['success']) ? 'green' : 'red';

    echo '<h2 style="color: ' . $messageColor . '; font-weight: bold;">' . $message . '</h2>';
}

echo "<h1>Pokémon Card Trading</h1>";


echo '<div class="top-container">';
echo '<a href="login.php" class="login-link"><h2>Login</h2></a>';
echo '<a href="logout.php"><h2>Logout</h2></a>';
echo '</div>';

if (isset($_SESSION['user_id']) &&  ($_SESSION['user_id']==="65a34019f2372")){
    echo '<h2> <a href="new_card.php">Create New Card</a></h2>';
}


if (isset($_SESSION['user_id'])) {
    include_once("storage.php");
    $stor = new Storage(new JsonIO('users.json'));
    $allUsers = $stor->findAll();
    echo "<h2>Hello <a href='user_details.php'>{$allUsers[$_SESSION['user_id']]['username']}</a>!  Your current balance in the wallet is {$allUsers[$_SESSION['user_id']]['amountOfMoneyInWallet']} huf</h2>";
}

//echo '<a href="logout.php">Logout</a>';




//echo "<h3>Not a Member <a href=\"registration.php\">Click Here</a> to Sign Up </h3>";
if (!isset($_SESSION['user_id'])) {
    echo '<div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 15px;">';
    echo '<h3>To be able to buy a card, you need to <a href="login.php" style="font-weight: bold;">login</a>.</h3>';
    echo '<h3>Not a Member <a href="registration.php">Click Here</a> to Sign Up </h3>';
    echo '</div>';
    

}

echo "<p><h4>Welcome to our Pokémon Card Trading platform. Explore the amazing world of Pokémon cards!</h4></p>";

// if (isset($_SESSION['user_id'])) {
//     // Display link to User details page
//     echo "<p><h4>Check your details<a href='user_details.php'> here</a></h4></p>";//If the user is logged in, a link should be available to the "User details" page.
// }

//$adminUserName = "admin";

// Include your storage class and other necessary files
include_once("storage.php");//This line includes the content of the storage.php file in your current PHP script.
$stor = new Storage(new JsonIO('cards.json'));//It creates an instance of the Storage class, passing an instance of the JsonIO class as a parameter. The JsonIO class is likely responsible for handling input and output operations related to JSON data.

// Retrieve all cards using the findAll() method
$allCards = $stor->findAll();

// Display title and description


// // Display Pokémon cards
// foreach ($allCards as $cardId => $card) {
//     // echo "<div>";
    // echo "<h2>{$card['name']}</h2>";
    // echo "<img src='{$card['image']}' alt='{$card['name']}'>";
    // echo "<p>Type: {$card['type']}</p>";
    // echo "<p>Price: {$card['price']} Money</p>";




    // Display Pokémon cards
$cardCount = 0;
foreach ($allCards as $cardId => $card) {
    if($card['owner'] == "admin"){
    echo "<div style='width: 200px; display: inline-block; margin: 10px; text-align: center;'>";
    //echo "<h2>{$card['name']}</h2>";
     // Add link to card details page
     echo "<p><a href='interMediatedetails.php?card_id=$cardId'><h2>{$card['name']}</h2></a></p>";
    echo "<img src='{$card['image']}' alt='{$card['name']}' style='max-width: 100%; height: auto;'>";
    echo "<p>Type: {$card['type']}</p>";
    echo "<p>Price: {$card['price']} huf</p>";

            
    // Check if user is logged in
    if (isset($_SESSION['user_id']) && $_SESSION['user_id']!="65a34019f2372") {//>>IF THE USER IS LOGGED IN
        // Check if the card belongs to the admin
        if ($card['owner'] == "admin") {//IF THE CURRENT CARD BELONGS TO ADMIN
            // Display "Buy" button 
            echo "<form action='buy_card.php' method='post'>";////HTML form with a hidden input field and a submit button. 
            echo "<input type='hidden' name='card_id' value='$cardId'>";////Hidden input fields are not visible to users but are submitted with the form>>>The card ID is submitted to buy_card.php
            echo "<button type='submit'>Buy</button>";
            echo "</form>";
        }

        
    }
    }
   

    echo "</div>";

    $cardCount++;

    // Start a new row after every 5 cards
    if ($cardCount % 5 === 0) {
        echo "<br>";
    }
}

    
//     if (isset($_SESSION['user_id'])) {
       
//         if ($card['owner'] == "admin") {

//         echo "<form action='buy_card.php' method='post'>";
//         echo "<input type='hidden' name='card_id' value='$cardId'>";
//         echo "<button type='submit'>Buy</button>";
//         echo "</form>";

            
//         }

        
//     }

//     // Add link to card details page
//     echo "<p><a href='interMediatedetails.php?card_id=$cardId'>Card Details</a></p>";

//     echo "</div>";
 
?>

</body>
</html>
