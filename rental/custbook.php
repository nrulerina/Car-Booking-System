<?php

include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
?>

<div id="wrapper">
    <?php include 'sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?php include 'topbar.php'; ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class=container>
                       <br>
        <br>
         <div class="card card-position">
              <div class="card-header">


        <h1 class="h3 mb-4 text-gray-800">Booking Form</h1>
        <h1 class="h3 mb-4 text-gray-800"></h1>

     

                    <form method="POST" action="custbookprocess.php">


                            <div class="form-group">
                                <label for="exampleSelect1" class="form-label mt-4">Select Vehicle</label>

                                <?php
                                $sql = "SELECT * FROM tb_vehicle WHERE v_status = 'active'";
                                $result = mysqli_query($con, $sql);

                                echo '<select class="form-select" name="fvehicle" id="exampleSelect1" fdprocessedid="3ydaon">';

                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value='" . $row['v_req'] . "'>" . $row['v_model'] . ", RM" . $row['v_price'] . "</option>";
                                }

                                echo '</select>';
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1" class="form-label mt-4">Select Pickup Date</label>
                                <input type="date" name="fpdate" class="form-control" id="pickupDate" placeholder="IC number without dash(-)" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1" class="form-label mt-4">Select Return Date</label>
                                <input type="date" name="frdate" class="form-control" id="returnDate" placeholder="IC number without dash(-)" required>
                            </div>

                            <button type="reset" class="btn btn-secondary" fdprocessedid="n4qfe8">Reset</button>
                            <button type="submit" class="btn btn-primary" fdprocessedid="xyaiug">Book</button>

                    </form>
                </div><br><br><br>

                </form>

            </div>
        </div>
    </div>

</div>
</div>
</div>
</div>



<?php include 'footer.php'; ?><!-- Add these scripts at the end of your <body> tag -->
<script>
    $(document).ready(function() {
        $('#pickupDate').change(function() {
            var pickupDate = $(this).val();
            $('#returnDate').attr('min', pickupDate);
        });
    });
</script>