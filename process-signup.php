<?php
if (!preg_match("/^\d{12}$/", $_POST["aadhar"])) {
    die("Aadhar must be 12 digits long and contain only numbers.");
}
if (!preg_match("/^\d{10}$/", $_POST["mobile"])) {
    die("Mobile must be 10 digits long and contain only numbers.");
}



if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}



$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO signup (fname,lname,aadhar,birthDate,mobile, password_hash)
        VALUES (?, ?, ?,?,?,?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("ssssss",
                  $_POST["fname"],
                  $_POST["lname"],
                  $_POST["aadhar"],
                  $_POST["birthDate"],
                  $_POST["mobile"],
                  $password_hash);
                  
if ($stmt->execute()) {

    header("Location: sample.html");
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}