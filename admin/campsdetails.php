<?php
session_start();


$con = mysqli_connect('localhost', 'root', '', 'bloodbank'); 


if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $hospital = mysqli_real_escape_string($con, $_POST['hospital']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $time = mysqli_real_escape_string($con, $_POST['time']);


    $check_query = "SELECT * FROM camps WHERE hospital = '$hospital'";
    $check_result = mysqli_query($con, $check_query);
    $existing_hospital = mysqli_fetch_assoc($check_result);

    if ($existing_hospital) {
        echo "<script>alert('Hospital is already scheduled')</script>";
    } elseif (empty($hospital) || empty($contact)) {
        echo "Please fill all the fields.";
    } else {
        
        $insert_query = "INSERT INTO camps (hospital, address, city, contact, date, time) VALUES ('$hospital', '$address', '$city', '$contact', '$date', '$time')";
        
        if (mysqli_query($con, $insert_query)) {
            echo "<script>alert('Camps Entry is Successful')</script>";
        } else {
            echo "Error: " . $insert_query . "<br>" . mysqli_error($con);
        }
    }
}


mysqli_close($con);
?>
