<?php
session_start();
$userwatcher = $_SESSION['username']; ?>
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
$somstudents = array();
$campus = $_SESSION['campus'];
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$query  = "select studID,nameCand,position,image,college, COUNT(*) from tb_votes where campus = '$campus' && indicator = 'School of Medicine Student Council' group by position, nameCand";
$result = mysqli_query($conn,$query);
while ($row = mysqli_fetch_assoc($result)) {
    $somstudents[] = $row;
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
if($userwatcher == 'sitswatcher') {
    $students3 = array();
    $campus = $_SESSION['campus'];
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "select studID,nameCand,position,image,college,program, COUNT(*) from tb_votes where campus = '$campus' && program = 'Bachelor of Science in Information Technology' && indicator = 'Local Council' group by position,nameCand";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $students3[] = $row;
    }

    $conn->close();
}

if($userwatcher == 'aeceswatcher') {
    $students3 = array();
    $campus = $_SESSION['campus'];
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "select studID,nameCand,position,image,college,program, COUNT(*) from tb_votes where campus = '$campus' && program = 'Bachelor of Early Childhood Education' && indicator = 'Local Council' group by position,nameCand";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $students3[] = $row;
    }

    $conn->close();
}
if($userwatcher == 'afsetwatcher') {
    $students3 = array();
    $campus = $_SESSION['campus'];
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "select studID,nameCand,position,image,college,program, COUNT(*) from tb_votes where campus = '$campus' && program = 'Bachelor of Secondary Education' && indicator = 'Local Council' group by position,nameCand";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $students3[] = $row;
    }

    $conn->close();
}
if($userwatcher == 'btvtedwatcher') {
    $students3 = array();
    $campus = $_SESSION['campus'];
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "select studID,nameCand,position,image,college,program, COUNT(*) from tb_votes where campus = '$campus' && program = 'Bachelor in Technical-Vocational Teacher Education' && indicator = 'Local Council' group by position,nameCand";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $students3[] = $row;
    }

    $conn->close();
}
if($userwatcher == 'sabeswatcher') {
    $students3 = array();
    $campus = $_SESSION['campus'];
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "select studID,nameCand,position,image,college,program, COUNT(*) from tb_votes where campus = '$campus' && program = 'Bachelor of Science in Agricultural and Biosystems Engineering' && indicator = 'Local Council' group by position,nameCand";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $students3[] = $row;
    }

    $conn->close();
}
if($userwatcher == 'ofeewatcher') {
    $students3 = array();
    $campus = $_SESSION['campus'];
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "select studID,nameCand,position,image,college,program, COUNT(*) from tb_votes where campus = '$campus' && program = 'Bachelor of Elementary Education' && indicator = 'Local Council' group by position,nameCand";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $students3[] = $row;
    }

    $conn->close();
}
if($userwatcher == 'ofsetwatcher') {
    $students3 = array();
    $campus = $_SESSION['campus'];
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "select studID,nameCand,position,image,college,program, COUNT(*) from tb_votes where campus = '$campus' && program = 'Bachelor of Special Needs Education' && indicator = 'Local Council' group by position,nameCand";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $students3[] = $row;
    }

    $conn->close();
}


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
$query4 = "Select admin_id from tbadmin where username = '$tempCampus'";
$result = mysqli_query($conn, $query4);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $admin_id = $row['admin_id'];
    $query2 = "INSERT INTO tb_admin_action_logs(admin_id,action,log_action_date) VALUES('$admin_id', '$action','$dt')";

    mysqli_query($conn, $query2);
}

$conn->close();
?>