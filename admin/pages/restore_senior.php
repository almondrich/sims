<?php
// Include database connection
include('../db_conn.php');

// Check if senior_id is provided via POST
if (isset($_POST['senior_id'])) {
    $senior_id = mysqli_real_escape_string($conn, $_POST['senior_id']);

    // Update query to restore the senior's status to Active
    $query = "UPDATE senior_profiles SET status = 'Active', archive_remarks = NULL, other_remarks = NULL WHERE senior_id = '$senior_id'";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Redirect back with success status
        header("Location: manage-senior.php?status=success&action=restore");
    } else {
        // Redirect back with error message
        $error_message = mysqli_error($conn);
        header("Location: manage-senior.php?status=error&action=restore&message=" . urlencode($error_message));
    }
} else {
    // If no senior_id is provided, redirect back with error
    header("Location: manage-senior.php?status=error&action=restore&message=Invalid+ID");
}

// Close the database connection
mysqli_close($conn);
?>
