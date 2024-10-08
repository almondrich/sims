<?php include '../includes/header.php';?>
<?php include '../includes/sidenav.php';?>

<div class="content-wrapper">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0"><span class="fa fa-archive"></span> Archived Senior Citizens</h1>
            </div>
         </div>
      </div>
   </div>

   <section class="content">
       <div class="container-fluid">
          <div class="card card-info elevation-2">
             <div class="col-md-12">
                <table id="archiveTable" class="table table-bordered">
                   <thead>
                      <tr>
                         <th>ID No.</th>
                         <th>Name</th>
                         <th>Age</th>
                         <th>Gender</th>
                         <th>Address</th>
                         <th>Remarks</th>
                         <th>Action</th>
                      </tr>
                   </thead>
                   <tbody>
                   <?php
                   // Include database connection
                   include('../db_conn.php');

                   // Query to fetch archived senior citizens
                   $query = "
                       SELECT sp.senior_id, sp.first_name, sp.middle_name, sp.last_name, sp.age, sp.gender, 
                              sp.address, sp.archive_remarks, sp.other_remarks 
                       FROM senior_profiles sp
                       WHERE sp.status = 'Archive'
                   ";

                   $result = mysqli_query($conn, $query);

                   if ($result && mysqli_num_rows($result) > 0) {
                       while ($row = mysqli_fetch_assoc($result)) {
                           $remarks = $row['archive_remarks'] === 'Other' ? $row['other_remarks'] : $row['archive_remarks'];
                           echo "<tr>";
                           echo "<td>SNR-" . htmlspecialchars($row['senior_id']) . "</td>";
                           echo "<td>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['middle_name']) . " " . htmlspecialchars($row['last_name']) . "</td>";
                           echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                           echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                           echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                           echo "<td>" . htmlspecialchars($remarks) . "</td>";
                           echo "<td>
                                  <a class='btn btn-sm btn-success' href='#' data-toggle='modal' data-target='#restoreModal' 
                                  data-id='" . htmlspecialchars($row['senior_id']) . "'><i class='fa fa-undo'></i> Restore</a>
                                  </td>";
                           echo "</tr>";
                       }
                   } else {
                       echo "<tr><td colspan='7'>No archived records found.</td></tr>";
                   }

                   mysqli_close($conn);
                   ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </section>
</div>

<!-- Restore Modal -->
<div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="restoreModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreModalLabel">Restore Senior Citizen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="restore_senior.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="restore_senior_id" name="senior_id">
                    <p>Are you sure you want to restore this senior citizen to active status?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Restore</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php';?>

<script>
    $(document).ready(function() {
        // Set the senior_id in the Restore Modal when opening
        $('#restoreModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var seniorId = button.data('id'); // Extract senior_id from the data-* attributes
            var modal = $(this);
            modal.find('#restore_senior_id').val(seniorId);
        });
    });
</script>
