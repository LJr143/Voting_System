<?php
  $students = array();
  $campus = $_SESSION['campus'];
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select studID,nameCand,position,image,college, COUNT(*) from tb_votes where campus = '$campus' && indicator = 'Student Council' group by position, nameCand";
  $result = mysqli_query($conn,$query);
  while ($row = mysqli_fetch_assoc($result)) {
    $students[] = $row;
  }
  
  $conn -> close(); 

?>


<?php
  $students2 = array();
  $campus = $_SESSION['campus'];
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select studID,nameCand,position,image,college,program, COUNT(*) from tb_votes where campus = '$campus' && indicator = 'Local Council' group by position,nameCand";
  $result = mysqli_query($conn,$query);
  while ($row = mysqli_fetch_assoc($result)) {
    $students2[] = $row;
  }
  
  $conn -> close(); 

?>


<?php
  $campus = $_SESSION['campus'];
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "SELECT * FROM tbnominees where campus = '$campus'order by lname";
  $nominees = array();
  $result = mysqli_query($conn,$query);
  while ($row = mysqli_fetch_assoc($result)) {
    $nominees[] = $row;
  }
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
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$tempCampus = $_SESSION['username'];
$dt = date('Y-m-d G:i:s');
$action = "Election Result | Access Granted";
$query = "INSERT into tblogs(name,action,timestamp)VALUES('$tempCampus','$action','$dt')";
mysqli_query($conn, $query);

$conn->close();
?>