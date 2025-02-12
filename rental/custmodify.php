<?php 
    include('mysession.php');
    if(!session_id())
    {
        session_start();
    }

//Get booking Id from url
    if(isset($_GET['id']))
    {
      $fbid=$_GET['id'];
    }

include ('dbconnect.php');


//Retrieve booking Operation

$sqlr=" SELECT * FROM tb_booking 
        LEFT JOIN tb_vehicle ON tb_booking.b_req=tb_vehicle.v_req 
        WHERE b_id=$fbid";


//Execute 
$resultr=mysqli_query($con, $sqlr);
$rowr=mysqli_fetch_array($resultr);



  ?>
    
  <div id="wrapper">
  <?php include 'sidebar.php'; ?>




  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

      <?php include 'topbar2.php'; ?>

      <!-- Begin Page Content -->
      <div class="container-fluid">
<div class=container>
           <br>
        <br>
         <div class="card card-position">
              <div class="card-header">
                <h1 class="h3 mb-4 text-gray-800">Modify Form</h1>
        <h1 class="h3 mb-4 text-gray-800"></h1>

<form method="POST" action="custmodifyprocess.php">
  <br>
  <br>


     <div class="form-group">
      <label for="exampleSelect1" class="form-label mt-4">Select vehicle</label>

      <?php

      echo'<input type="hidden" value="'.$rowr['b_id'].'" name="fbid" >';

      $sql="SELECT * FROM tb_vehicle";
      $result= mysqli_query($con, $sql);

      echo'<select class="form-select" name="fvehicle" id="exampleSelect1" >';
        while($row=mysqli_fetch_array($result))
        {
          if($row['v_req']==$rowr['b_req'])
          {
            echo"<option selected='selected' value= '".$row['v_req']."'>".$row['v_model'].", RM".$row['v_price']."</option value>";
          }
          else
          {
            echo"<option value= '".$row['v_req']."'>".$row['v_model'].", RM".$row['v_price']."</option value>";
          }

        }

      echo'</select>';

      ?>
    </div>

<div class="form-group">
    <label for="exampleInputPassword" class="form-label mt-4">Select Pickup Date</label>
    <?php  
        echo '<input type="date" value="'.$rowr['b_pdate'].'" name="fpdate" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="off" required oninput="setMinReturnDate(this.value)">';
    ?>
</div>

<div class="form-group">
    <label for="exampleInputPassword" class="form-label mt-4">Select Return Date</label>
    <?php  
        echo '<input type="date" value="'.$rowr['b_rdate'].'" name="frdate" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="off" required oninput="setReturnDate()">';
    ?>
</div>

<script>
    function setMinReturnDate(pickupDate) {
        // Set the minimum date for the return date input
        var returnDateInput = document.getElementsByName("frdate")[0];
        returnDateInput.min = pickupDate;

        // Ensure that the return date is not before the pickup date
        if (returnDateInput.value && returnDateInput.value < pickupDate) {
            returnDateInput.value = pickupDate;
        }
    }

    function setReturnDate() {
        var pickupDateInput = document.getElementsByName("fpdate")[0];
        var returnDateInput = document.getElementsByName("frdate")[0];
        
        // Ensure that the return date is not before the pickup date
        if (returnDateInput.value && returnDateInput.value < pickupDateInput.value) {
            returnDateInput.value = pickupDateInput.value;
        }
    }
</script>

<br><br>
<button type="reset" class="btn btn-dark">Reset</button>
<button type="submit" class="btn btn-primary" >Modify</button>

  </div>
</div>


</form>


</div>   
</div>
</div>

</div>
</div>

<?php 

mysqli_close($con);

include 'footer.php';?>