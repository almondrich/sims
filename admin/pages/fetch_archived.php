<?php
include('../db_conn.php');

// Get the remarks filter from POST
$remarks = $_POST['remarks'];

// Initial query to fetch archived senior citizens
$query = "SELECT senior_id, first_name, middle_name, last_name, age, gender, address, archive_remarks, other_remarks FROM senior_profiles WHERE status = 'Archive'";

// Add remarks filter if selected
if (!empty($remarks)) {
    if ($remarks === 'Other') {
        $query .= " AND archive_remarks = 'Other'";
    } else {
        $query .= " AND archive_remarks = '" . mysqli_real_escape_string($conn, $remarks) . "'";
    }
}

// Execute the query
$result = mysqli_query($conn, $query);

// Check if any records are returned
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $remarksText = $row['archive_remarks'] === 'Other' ? $row['other_remarks'] : $row['archive_remarks'];
        echo "<tr>";
        echo "<td>SNR-" . htmlspecialchars($row['senior_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['middle_name']) . " " . htmlspecialchars($row['last_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['age']) . "</td>";
        echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
        echo "<td>" . htmlspecialchars($remarksText) . "</td>";
        echo "<td>
               <a class='btn btn-sm btn-success' href='#' data-toggle='modal' data-target='#restoreModal' 
               data-id='" . htmlspecialchars($row['senior_id']) . "'><i class='fa fa-undo'></i> Restore</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No archived records found.</td></tr>";
}

// Close the connection
mysqli_close($conn);
?>
