<?php
//everytime you load this file the first 26 lines are also executed.
include_once("storage.php");
$stor = new Storage(new JsonIO('users.json'));

$adminData = [
    "username" => "admin",
    "email" => "admin@gmail.com",
    "password" => "admin", // Password in plain text
    "isAdmin" => true,
    "amountOfMoneyInWallet" => 1500,
    "noOfCards" => 10,
    "cards" => ["pikachu", "Pidgey", "Rattata"],
    "id" =>"5fcee306a7980"
];

// Check if the admin user already exists
$existingAdmin = $stor->findOne(['username' => 'admin']);

if (!$existingAdmin) {
    // Hash the admin password before storing it
    $adminData['password'] = password_hash($adminData['password'], PASSWORD_DEFAULT);
    
    // Add the admin data to the storage
    $stor->add($adminData);
}


    $errors = [];
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($_POST){
        //include_once("storage.php");//This line includes the content of the storage.php file in your current PHP script.

        //$stor = new Storage(new JsonIO('users.json'));//It creates an instance of the Storage class, passing an instance of the JsonIO class as a parameter. The JsonIO class is likely responsible for handling input and output operations related to JSON data.

        $existingUser = $stor->findOne(['username' => $username]);

       
    if ($existingUser) {
        $errors['username'] = 'The username is already taken!';
        } elseif (empty($username)){
            $errors['username'] = 'The username field should not be empty.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'The e-mail is not valid.';
        }elseif(empty($email)){
            $errors['email'] = 'The e-mail field should not be empty';
        }

        if($password !== $confirmPassword){
            $errors ['password'] = 'The passwords don\'t match!';
        }elseif(empty($password) || empty($confirmPassword)){
            $errors ['password'] = 'The password field should not be empty.';
        }

        if (count($errors) === 0){
              // Hash the password before storing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user = [
                "username" => $username,
                "email" => $email,
                "password" => $hashedPassword,  // Store the hashed password
                //If your database is compromised, storing hashed passwords makes it significantly harder for attackers to retrieve the original passwords.
                //Users trust websites and services to handle their sensitive information responsibly. Storing plaintext passwords exposes users to unnecessary risks, eroding trust in the security of your system.
                "isAdmin" => false,
                "amountOfMoneyInWallet" => 1500,
                "noOfCards" => 0,
                "cards" => []

            ];
            
            
            $stor -> add($user);
            // including a PHP file (storage.php), creating a new instance of a Storage class, and then adding a person to it. The person is likely represented by the variable $person. The data is being stored using the JsonIO class with the file name 'data.json'.
            header("location: main.php");
            exit();  // Ensure that no code is executed after the header redirection.When you send a Location header, you are instructing the browser to redirect to a different URL. However, the PHP script will continue to execute unless you explicitly stop it.
            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Registration</h2>


    <ul style= "color: red;">
        <?php 
            foreach($errors as $e)
                echo "<li>$e</li>";
        ?>
    </ul>

    <form action="registration.php" method="POST"  novalidate>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?= $username ?>" required>
        <?= $errors['username'] ?? '' ?>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $email ?>" required>
        <?= $errors['email'] ?? '' ?>
        <br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?= $password ?>"required>
        <br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" value="<?= $confirmPassword ?>"required>
        <?= $errors['password'] ?? '' ?>
        <br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
