<?php

include('mysession.php');

if (!session_id()) {
    session_start();
}

// Get booking ID from URL
if (isset($_GET['id'])) {
    $fbid = $_GET['id'];

    include('dbconnect.php');

    // Update b_cond to 'deleted'
    $sqlUpdate = "UPDATE tb_booking SET b_cond = 'deleted' WHERE b_id = $fbid";
    $resultUpdate = mysqli_query($con, $sqlUpdate);

    // Check if the update was successful
    if ($resultUpdate) {
        mysqli_close($con);
        header('location:custmanage.php');
        exit(); // Exit to prevent further code execution after the header
    } else {
        // Handle the case where the update failed
        echo "Error updating b_cond: " . mysqli_error($con);
    }
} else {
    // Handle the case where 'id' is not set in the URL
    echo "Booking ID not provided.";
}

?>

<?php include 'footer.php'; ?>
