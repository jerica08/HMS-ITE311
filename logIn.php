<?php
session_start();
include 'connect.php'; // Ensuring this file is connected to the database

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
}

$sql = "SELECT * FROM users WHERE username = ?"; // SQL query to select user by username
$stmt = $conn->prepare($sql);
   
    if ($stmt){
        $stmt->bind_param("s", $username);
        $stmt->execute(); // run the statement
        $result = $stmt->get_result(); //retrieve the result of the query

        if ($result->num_rows >0){  // Check if the user exists
            $row = $result->fetch_assoc(); // fetch the row from the result
            if (hash('sha256', $password) === $username['password']){ // Verify the password
               echo 'Welcome';
        } else{
            echo "<p style='color:red;'>Wrong credentials</p>";
        }
    }
    
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Log In to HMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    section{
        font-family: Arial, sans-serif;
        background-color:rgb(244, 245, 246);
        width: fit-content;
    }
</style>
<body>
    <header> 
            <h1 style="text-align: left;">Hospital Management System</h1>
        </div>
    </div>
    </header>
        <section>
            <header class="login-card" style="text-align:center;">
                <h4>Log-In</h4>
            </header>
            <div class="login-card">
                <div class="input-group">
                    <label for="role"> Select Role</label>
                    <select id="role" name="role" required>
                        <option value="" disabled selected>--</option>
                        <option value="admin"> Admin </option>
                        <option value="doctor"> Doctor </option>
                        <option value="nurse"> Nurse </option>
                        <option value="receptionist"> Receptionist </option>
                        <option value="laboratorist"> Laboratorist </option>
                        <option value="pharmacists"> Pharmacists </option>
                        <option value="accountants"> Acountants </option>
                        <option value="it-staff"> IT Staff </option>
                    </select>         
                </div>

                    <div class="input-group">
                        <label for="username"> Username </label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required>                       
                    
                    </div>
                    <div class="input-group">
                        <label for="password"> Password </label>
                        <input type="password" id="passwowrd" name="password" placeholder="Enter password" required>
                    </div>
                    <form method="POST" action="logIn.php">
                    <button onclick="login()">Log In </button>
                    <p class="signip-link"> Don't have an account? <a href="#"> Sign Up</a></p>
                </form>
            </div>
        </section>
        <script src ="login.js"></script>
</body>




</html>
</html>
?