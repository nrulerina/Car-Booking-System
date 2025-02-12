<?php 
	include('mysession.php');
	if(!session_id())
	{
		session_start();
	}
	include('dbconnect.php');

  $suic= $_SESSION['suic']; //Get IC for current user


//Retrieve booking Operation

if(isset($_GET['id']))
{
  $fbid=$_GET['id'];
}
//Retrieve current booking Operation

$sql="SELECT *FROM tb_booking 
     LEFT JOIN tb_vehicle ON tb_booking.b_req=tb_vehicle.v_req 
     LEFT JOIN tb_status ON tb_booking.b_status=tb_status.s_id
       LEFT JOIN tb_user ON tb_booking.b_ic=tb_user.u_ic
     WHERE b_id ='$fbid' ";     

    
 
$result=mysqli_query($con,$sql);
$row= mysqli_fetch_array($result);



  ?>
	
  <div id="wrapper">
  <?php include 'sidebar2.php'; ?>




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
            
            <h3>New Bookings</h3><br>

  <form method="POST" action="staffapprovalprocess.php">
   
   <table class="table table-hover">

  <tbody>

    <tr>
         <td>Booking ID</td>
         <td><?php echo $row['b_id']  ?></td>
    </tr>

    <tr>
         <td>User ID</td>
         <td><?php echo $row['b_ic']  ?></td>
    </tr>

    <tr>
         <td>User Name</td>
         <td><?php echo $row['u_name']  ?></td>
    </tr>

    <tr>
         <td>Vehicle ID</td>
         <td><?php echo $row['b_req']  ?></td>
    </tr>

    <tr>
         <td>Vehicle model</td>
         <td><?php echo $row['v_model']  ?></td>
    </tr>

    <tr>
         <td>Pickup date</td>
         <td><?php echo $row['b_pdate']  ?></td>
    </tr>

    <tr>
         <td>Price per date</td>
         <td><?php echo $row['b_rdate']  ?></td>
    </tr>

    <tr>
         <td>Total price</td>
         <td><?php echo $row['v_price']  ?></td>
    </tr>

    <tr>
         <td>Approval</td>
         <td><?php 
              $sqls="SELECT * FROM tb_status ";
              $results= mysqli_query($con,$sqls);

              echo'<select class="form-select" name="fstatus" id="exampleSelect1" >';
              while($rows=mysqli_fetch_array($results))
              {

               
                 if($rows['s_id']!='1'){
                 echo"<option value='".$rows['s_id']."'>".$rows['s_desc']."</option>";}
               
              }

              echo '</select>';



               ?></td>
              
    </tr>
  
    <tr>
      <td>
        <input type="hidden" name="fbid" value="<?php echo $row['b_id'];?>" >;
      </td>

      <td>
      <button type="submit" class="btn btn-primary" >Approval</button>
      </td>

    </tr>





  </tbody>

  </table>

</form><br><br>

    <?php
    while($row=mysqli_fetch_array($result)){

        echo"<tr>";
        echo" <td>".$row['b_id']."</td>";
         echo" <td>".$row['b_ic']."</td>";
        echo" <td>".$row['v_model']."</td>";
        echo" <td>".$row['b_pdate']."</td>";
        echo" <td>".$row['b_rdate']."</td>";
        echo" <td>".$row['b_total']."</td>";
        echo" <td>".$row['s_desc']."</td>";
        echo" <td>";

              echo"<a href='staffapproval.php?id=".$row['b_id']."'class='btn btn-info'>Approval</a>&nbsp";


        echo" </td>";
        echo"</tr>";
    }

    ?>
  </tbody>
</table>

</div>   
</div>
</div>
</div>
</div>
<?php 

mysqli_close($con);

include 'footer.php';?>
</div>
</div>

