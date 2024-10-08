<?php
// Include database connection
include('../db_conn.php');

// Check if the required data is received from the form
if (isset($_POST['senior_id']) && isset($_POST['archive_remarks'])) {
    // Sanitize inputs
    $senior_id = mysqli_real_escape_string($conn, $_POST['senior_id']);
    $archive_remarks = mysqli_real_escape_string($conn, $_POST['archive_remarks']);
    $other_remarks = isset($_POST['other_remarks']) ? mysqli_real_escape_string($conn, $_POST['other_remarks']) : NULL;

    // Update the senior's status and archive remarks
    $query = "
        UPDATE senior_profiles 
        SET status = 'Archive', 
            archive_remarks = '$archive_remarks', 
            other_remarks = '$other_remarks'
        WHERE senior_id = '$senior_id'
    ";

    // Execute the query and handle errors
    if (mysqli_query($conn, $query)) {
        // Redirect with a success message
        header("Location: manage-senior.php?status=success&action=archive");
    } else {
        // Redirect with an error message
        $error_message = mysqli_error($conn);
        header("Location: manage-senior.php?status=error&action=archive&message=" . urlencode($error_message));
    }
} else {
    // Redirect with an error message if data is missing
    header("Location: manage-senior.php?status=error&action=archive&message=Invalid+Input");
}

// Close the connection
mysqli_close($conn);
?>
