<?php
session_start();

$con = mysqli_connect('localhost', 'root', '', 'bloodbank'); // Update with your database credentials and name

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $raw_password = $_POST['pass'];
    $useremail = $_POST['useremail'];
    $bloodgroup = $_POST['bloodgroup'];
    $gender = $_POST['gender'];

    // Check if the username exists
    $check_user_query = "SELECT * FROM login WHERE user='$user' LIMIT 1";
    $check_result = mysqli_query($con, $check_user_query);
    $user_exists = mysqli_fetch_assoc($check_result);

    if ($user_exists) {
        echo "<script>alert('Username Taken')</script>";
    } elseif (empty($user) || empty($raw_password)) {
        echo "Please fill all the fields.";
    } else {
        // Hash the password
        $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

        // Insert hashed password into the database
        $insert_query = "INSERT INTO login (user, pass, useremail, bloodgroup, gender) VALUES ('$user', '$hashed_password', '$useremail', '$bloodgroup', '$gender')";
        
        if (mysqli_query($con, $insert_query)) {
            echo "<script>alert('Registration successful. Sign in with your Username')</script>";
            header("location: successfull.html");
            exit();
        } else {
            echo "Error: " . $insert_query . "<br>" . mysqli_error($con);
        }
    }
}
mysqli_close($con);
?>
