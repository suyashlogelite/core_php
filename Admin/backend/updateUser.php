<?php
include "dbconfig.php";

$responses = array();

    // Add User
    if (isset($_POST['addUser']) && $_POST['addUser'] !== "") {
        if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['gender']) && !empty($_POST['role']) && !empty($_POST['country'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $gender = $_POST['gender'];
            $role = $_POST['role'];
            $country = $_POST['country'];

            // Check if email already exists
            $selectUser = "SELECT * FROM `users` WHERE `email` = '$email'";
            $query_user_run = mysqli_query($conn, $selectUser);
            if ($query_user_run) {
                if (mysqli_num_rows($query_user_run) > 0) {
                    $responses['error'] = "Email id already exists!";
                } else {
                    $queryInsert = "INSERT INTO `users` (`name`, `email`, `phone`, `gender`, `role`, `country`) VALUES ('$name', '$email', '$phone', '$gender', '$role', '$country')";
                    $insert_run = mysqli_query($conn, $queryInsert);
                    if ($insert_run) {
                        $responses['success'] = "User Record Inserted Successfully";
                    } else {
                        $responses['error'] = "Failed To Insert User Record";
                    }
                }
            } else {
                $responses['error'] = "Error: " . mysqli_error($conn);
            }
        } else {
            $responses['error'] = "All Fields Are Mandatory";
        }
    }

// Edit User
if (isset($_GET['userid'])) {
    $user_id = $_GET['userid'];
    $query = "SELECT * FROM `users` WHERE id = $user_id";
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {
            $row = mysqli_fetch_array($query_run);
            echo json_encode($row);
            exit(); // Terminate script after sending JSON response for edit
        } else {
            $responses['error'] = "No record found";
        }
    } else {
        $responses['error'] = "Error in query run";
    }
}
// Update User
else if (isset($_POST['user_id']) && $_POST['user_id'] !== "") {
    $id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $country = $_POST['country'];
    $query1 = "UPDATE `users` SET name = '$name', email = '$email', phone = '$phone', gender = '$gender', role = '$role', country = '$country' WHERE id = $id";
    $query_run1 = mysqli_query($conn, $query1);
    if ($query_run1) {
        $responses['success'] = "User Updated Successfully";
    } else {
        $responses['error'] = "Failed To Update User";
    }
}
// Delete User
else if (isset($_POST['deleteUser']) && $_POST['deleteUser'] !== "") {
    $id = $_POST['deleteUser']; // Change to POST method
    $query = "DELETE FROM `users` WHERE id = $id";
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        $responses['success'] = "Record Deleted Successfully";
    } else {
        $responses['error'] = "Failed To Delete Record";
    }
}
// If none of the above conditions are met
else {
    $responses['error'] = "Invalid request";
}

// Send JSON response
echo json_encode($responses);
?>

?>