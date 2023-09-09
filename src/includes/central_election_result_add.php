
<!-- mabini campus -->
<!-- student council -->
<?php
include '../config/db_config.php';
  $mabinistudents = array();
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select studID,nameCand,position,image,college, COUNT(*) from tb_votes where campus = 'Mabini' && indicator = 'Student Council' group by position,nameCand";
  $result = mysqli_query($conn,$query);
  while ($row = mysqli_fetch_assoc($result)) {
    $mabinistudents[] = $row;
  }
  
  $conn -> close(); 

?>

<!-- tagum campus -->
<!-- student council -->
<?php
  $tagumstudents = array();
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select studID,nameCand,position,image,college, COUNT(*) from tb_votes where campus = 'Tagum' && indicator = 'Student Council' group by position,nameCand";
  $result = mysqli_query($conn,$query);
  while ($row = mysqli_fetch_assoc($result)) {
    $tagumstudents[] = $row;
  }
  
  $conn -> close(); 

?>

<!-- mabini campus -->
<!-- local council -->
<?php
  $localmabinistudents = array();
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select studID,nameCand,position,image,college,program, COUNT(*) from tb_votes where campus = 'Mabini' && indicator = 'Local Council' group by position,nameCand";
  $result = mysqli_query($conn,$query);
  while ($row = mysqli_fetch_assoc($result)) {
    $localmabinistudents[] = $row;
  }
  
  $conn -> close(); 

?>

<!-- tagum campus -->
<!-- local council -->
<?php
  $localtagumstudents = array();
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select studID,nameCand,position,image,college,program, COUNT(*) from tb_votes where campus = 'Tagum' && indicator = 'Local Council' group by position,nameCand";
  $result = mysqli_query($conn,$query);
  while ($row = mysqli_fetch_assoc($result)) {
    $localtagumstudents[] = $row;
  }
  
  $conn -> close(); 

?>


<!-- election date data -->
<?php
  $campus = $_SESSION['campus'];
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "SELECT * FROM tbelectiondate";
  $dates = array();
  $result = mysqli_query($conn,$query);
  while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = $row;
  }
  $conn -> close();
  
?>
<!-- get the date and time in the db -->
<?php 
  $campus = $_SESSION['campus'];
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query = "SELECT * from tbelectiondate";
  $result = mysqli_query($conn,$query);

  while($row = mysqli_fetch_assoc($result)){
    $GLOBALS['sDate'] = $row['start_date'];
    $GLOBALS['eDate'] = $row['end_date'];
    $GLOBALS['sTime'] = $row['start_time'];
    $GLOBALS['eTime'] = $row['end_time'];

  }

  $conn -> close();

?>

<!-- logs -->
<?php
//
//$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
//$tempCampus = $_SESSION['username'];
//$dt = date('Y-m-d G:i:s');
//$action = "Election Result | Access Granted";
//$query = "INSERT into tb_admin_action_logs(username,action,log_action_date)VALUES('$tempCampus','$action','$dt')";
//mysqli_query($conn, $query);
//
//$conn->close();
//
//?>