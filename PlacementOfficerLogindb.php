<?php
if (isset($_POST['lsubmit'])) {
    $email = $_POST['txtEmail'];
    $password = $_POST['txtPassword'];
    $password = md5($password);
    $conn = mysqli_connect("localhost", "root", "", "minor_project");
    $query = "select * from faculty where f_email='$email' and f_password='$password' and role=1";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);

    if ($count == 0) {
        echo "<h1> Username and Password is Incorrect...!!! </h1>";
        include "PlacementOfficerDashboard.php";
    } else {
        session_start();
        $row = mysqli_fetch_array($result);
        $_SESSION['roleid'] = $row['role'];
        header("Location: ./po_dashboard.php");
        mysqli_close($conn);
    }
}
?>