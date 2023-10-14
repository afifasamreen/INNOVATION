<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM signup
                    WHERE aadhar = '%d'",
                   $mysqli->real_escape_string($_POST["aadhar"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: choice.html");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">-->
</head>
<style>
body {
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #FCFBF4;
}

.login-container {
    text-align: center;
}

.login-box {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    width: 300px;
}

h2 {
    margin: 0;
}

form {
    text-align: left;
}

label {
    display: block;
    margin-top: 10px;
}

input {
    width: 75%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

button {
    background-color: #007BFF;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    margin-top: 10px;
}
.required-label::after {
        content: " *";
        color: red;
    }
 a {
            text-decoration: none;
        }

</style>
<body>
    

    
 
    
   

    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2><br>
            Do not have an account? <a href="signup.html">Sign-Up</a><br>
            <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
          <form method="POST">
          <label for="aadhar" class="required-label">Aadhar</label>
        <input type="text" name="aadhar" id="aadhar"
               value="<?= htmlspecialchars($_POST["aadhar"] ?? "") ?>">
               <label for="password" class="required-label"> Password</label>
        <input type="password" name="password" id="password">
 <center>   <button type="submit">Log In</button></center>
</form>
        </div>
    </div>
    
</body>
</html>
