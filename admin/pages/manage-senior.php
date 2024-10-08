<?php include '../includes/header.php';?>
<?php include '../includes/sidenav.php';?>

<div class="content-wrapper">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0"><span class="fa fa-blind"></span> List of Senior Citizens</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right"></ol>
            </div>
         </div>
      </div>
   </div>

   <section class="content">
       <div class="container-fluid">
          <div class="card card-info elevation-2">
             <div class="card-header">
                <h3 class="card-title">Manage List</h3>
             </div>
             <div class="card-body">
                <!-- Search and Filter Section -->
                <div class="row mb-3">
                   <!-- Search by Name -->
                   <div class="col-md-4">
                      <input type="text" id="searchName" class="form-control" placeholder="Search by Name">
                   </div>
                   <!-- Filter by Gender -->
                   <div class="col-md-3">
                      <select id="filterGender" class="form-control">
                         <option value="">All Genders</option>
                         <option value="Male">Male</option>
                         <option value="Female">Female</option>
                      </select>
                   </div>
                </div>

       
             <div class="col-md-12">
                <table id="example1" class="table table-bordered">
                   <thead class="btn-cancel">
                      <tr>
                         <th>ID No.</th>
                         <th>Name</th>
                         <th>Age</th>
                         <th>Gender</th>
                         <th>Address</th>
                         <th>Status</th>
                         <th>Action</th>
                      </tr>
                   </thead>
                   <tbody id="seniorTableBody">
                   <?php
// Include database connection
include('../db_conn.php');

// Query to fetch senior citizens data along with barangay_assigned
$query = "
    SELECT sp.senior_id, sp.first_name, sp.middle_name, sp.last_name, sp.age, sp.birthday, sp.gender, 
           sp.address, sp.status, bc.barangay_assigned 
    FROM senior_profiles sp
    JOIN barangay_captains bc ON sp.barangay_assigned = bc.barangay_assigned
    WHERE sp.status != 'Archive'
";



// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query returns any result
if ($result && mysqli_num_rows($result) > 0) {
    // Loop through each row and display data
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>SNR-" . htmlspecialchars($row['senior_id']) . "</td>";
        echo "<td><p class='info'><small class='text-danger'></small> " . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['middle_name']) . " " . htmlspecialchars($row['last_name']) . "</p></td>";
        echo "<td>" . htmlspecialchars($row['age']) . "</td>";
        echo "<td>" . htmlspecialchars($row['gender']) . "</td>"; // Display gender value
        echo "<td>" . htmlspecialchars($row['barangay_assigned']) . "</td>";
        echo "<td class='text-center'><span class='badge bg-success'>" . htmlspecialchars($row['status']) . "</span></td>";
        echo "<td class='text-center'>
              <a class='btn btn-sm btn-success' href='#' data-toggle='modal' data-target='#editModal' 
              data-id='" . htmlspecialchars($row['senior_id']) . "' data-firstname='" . htmlspecialchars($row['first_name']) . "' 
              data-middlename='" . htmlspecialchars($row['middle_name']) . "' data-lastname='" . htmlspecialchars($row['last_name']) . "' 
              data-gender='" . htmlspecialchars($row['gender']) . "' data-birthday='" . htmlspecialchars($row['birthday']) . "' 
              data-age='" . htmlspecialchars($row['age']) . "' data-barangay='" . htmlspecialchars($row['barangay_assigned']) . "' 
              data-status='" . htmlspecialchars($row['status']) . "'><i class='fa fa-user-edit'></i> Update</a>

              <a class='btn btn-sm btn-danger' href='#' data-toggle='modal' data-target='#deleteModal' 
              data-id='" . htmlspecialchars($row['senior_id']) . "'><i class='fa fa-trash-alt'></i> Delete</a>

              <a class='btn btn-sm btn-warning' href='#' data-toggle='modal' data-target='#archiveModal' 
      data-id='" . htmlspecialchars($row['senior_id']) . "'><i class='fa fa-archive'></i> Archive</a>

              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No records found.</td></tr>";
}

// Close the connection
mysqli_close($conn);
?>

                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </section>
</div>



<!-- Edit Modal -->
<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Senior Citizen Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../update_senior.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_senior_id" name="senior_id">
                    
                    <!-- Your Details Section -->
                    <div class="form-section">
                        <h6 class="section-title">Your Details</h6>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="edit_first_name">First Name:</label>
                                <input type="text" class="form-control form-field" id="edit_first_name" name="first_name" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="edit_middle_name">Middle Name:</label>
                                <input type="text" class="form-control form-field" id="edit_middle_name" name="middle_name">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="edit_last_name">Last Name:</label>
                                <input type="text" class="form-control form-field" id="edit_last_name" name="last_name" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="edit_gender">Gender:</label>
                                <select class="form-control form-field" id="edit_gender" name="gender" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Address and Contact Details Section -->
                    <div class="form-section">
                        <h6 class="section-title">Contact and Address Details</h6>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="edit_birthday">Birthday:</label>
                                <input type="date" class="form-control form-field" id="edit_birthday" name="birthday" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="edit_age">Age:</label>
                                <input type="number" class="form-control form-field" id="edit_age" name="age" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="edit_address">Address:</label>
                                <textarea class="form-control form-field" id="edit_address" name="address" required></textarea>
                            </div>
                            <!-- <div class="col-md-6 form-group">
                                <label for="edit_contact_number">Contact Number:</label>
                                <input type="text" class="form-control form-field" id="edit_contact_number" name="contact_number">
                            </div> -->
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Information</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Archive Modal -->
<!-- Archive Modal -->
<div class="modal fade" id="archiveModal" tabindex="-1" role="dialog" aria-labelledby="archiveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="archiveModalLabel">Archive Senior Citizen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="archive_senior.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="archive_senior_id" name="senior_id">
                    <div class="form-group">
                        <label for="archive_remarks">Remarks</label>
                        <select class="form-control" id="archive_remarks" name="archive_remarks">
                        <option value="">---Select---</option>
                            <option value="Deceased">Deceased</option>
                            <option value="Transferred to other barangay">Transferred to other barangay</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div id="otherRemarksInput" style="display: none;">
                        <div class="form-group">
                            <label for="other_remarks">Other Remarks</label>
                            <input type="text" class="form-control" id="other_remarks" name="other_remarks">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Archive</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery and Bootstrap scripts (place just before closing </body> tag) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- Your custom scripts -->
<script>
   // Set the senior_id in the Archive Modal when opening
   $('#archiveModal').on('show.bs.modal', function(event) {
       var button = $(event.relatedTarget); // Button that triggered the modal
       var seniorId = button.data('id'); // Extract info from data-* attributes
       var modal = $(this);
       modal.find('#archive_senior_id').val(seniorId); // Update the modal's hidden input
   });

   // Show or hide the "Other" remarks input field based on selection
   $('#archive_remarks').on('change', function() {
       if ($(this).val() === 'Other') {
           $('#otherRemarksInput').show();
       } else {
           $('#otherRemarksInput').hide();
       }
   });
</script>

</body>
</html>



<style>
    .form-section {
        margin-bottom: 20px;
        border: 1px solid #ccc;
        padding: 15px;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .section-title {
        font-weight: bold;
        margin-bottom: 15px;
        text-transform: uppercase;
        font-size: 14px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 5px;
    }
    .form-field {
        border: 1px solid #333;
        box-shadow: none;
    }
    .modal-lg {
        max-width: 80%;
    }
</style>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Senior Citizen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../delete_senior.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="delete_senior_id" name="senior_id">
                    <p>Are you sure you want to delete this senior citizen?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php';?>

<script>
   $(document).ready(function() {
    // Edit Modal: Populate the fields
    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal

        // Extract data from the button's data-* attributes
        var seniorId = button.data('id');
        var firstName = button.data('firstname');
        var middleName = button.data('middlename');
        var lastName = button.data('lastname');
        var gender = button.data('gender');
        var birthday = button.data('birthday');
        var age = button.data('age');
        var barangay = button.data('barangay'); 
        var contactNumber = button.data('contact');

        // Set the modal's input fields
        var modal = $(this);
        modal.find('#edit_senior_id').val(seniorId);
        modal.find('#edit_first_name').val(firstName);
        modal.find('#edit_middle_name').val(middleName);
        modal.find('#edit_last_name').val(lastName);
        modal.find('#edit_gender').val(gender);
        modal.find('#edit_birthday').val(birthday);
        modal.find('#edit_age').val(age);
        modal.find('#edit_address').val(barangay);
        modal.find('#edit_contact_number').val(contactNumber);
    });

    // Delete Modal: Populate the hidden input field
    $('#deleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var seniorId = button.data('id');

        var modal = $(this);
        modal.find('#delete_senior_id').val(seniorId);
    });

    // Show alert messages for a few seconds and then hide them
    $('.alert').show().delay(3000).fadeOut();
});
</script>

<script>
       $(document).ready(function() {
        // Existing code for modals...

        // Show alert messages for a few seconds and then hide them
        $('.alert').show().delay(3000).fadeOut();

        // Gender Filter
        $('#genderFilter').on('change', function() {
            var selectedGender = $(this).val();
            loadSeniorData(selectedGender);
        });

        function loadSeniorData(gender) {
            $.ajax({
                url: 'fetch.php',
                type: 'POST',
                data: {gender: gender},
                success: function(data) {
                    $('#seniorTableBody').html(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    });
    </script>
    <script>
   $(document).ready(function() {
       // Search and filter functionality
       $('#searchName').on('input', function() {
           var searchValue = $(this).val().toLowerCase();
           filterTable(searchValue, $('#filterGender').val());
       });

       $('#filterGender').on('change', function() {
           var genderValue = $(this).val();
           filterTable($('#searchName').val().toLowerCase(), genderValue);
       });

       function filterTable(search, gender) {
           $('#seniorTableBody tr').filter(function() {
               $(this).toggle(
                   $(this).text().toLowerCase().indexOf(search) > -1 &&
                   ($(this).find('td:nth-child(4)').text().indexOf(gender) > -1 || gender === "")
               );
           });
       }

       // Handle the archive modal
       $('#archiveModal').on('show.bs.modal', function(event) {
           var button = $(event.relatedTarget);
           var seniorId = button.data('id');
           var modal = $(this);
           modal.find('#archive_senior_id').val(seniorId);
       });

       // Show or hide the "Other" remarks input field based on selection
       $('#archive_remarks').on('change', function() {
           if ($(this).val() === 'Other') {
               $('#otherRemarksInput').show();
           } else {
               $('#otherRemarksInput').hide();
           }
       });
   });
</script>
</body>
</html>
