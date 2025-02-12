<?php 

include('mysession.php');

if(!session_id())
{
 session_start();
}

include('dbconnect.php');

//retrieve data from regsiter form and session

$fbid=$_POST['fbid'];
$fstatus=$_POST['fstatus'];



$sql="UPDATE tb_booking
      SET b_status='$fstatus'
      WHERE b_id='$fbid'";

    //  echo var_dump($sql);

mysqli_query($con,$sql);
mysqli_close($con);

header('Location: staffmanage.php') ?>

<?php include 'footer.php';?>