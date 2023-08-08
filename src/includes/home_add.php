
<!-- script for counting the number rows in the tbnominees  -->
<?php

  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select * FROM tbnominees";
  $mResult = mysqli_query($conn,$query);
  $mCount = mysqli_num_rows($mResult);
  
  $conn -> close();

?>


<!-- script for counting the number of rows in the table -->
<?php

  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select * FROM tbnominees where campus = 'Mabini' ";
  $result4 = mysqli_query($conn,$query);
  $mabiniCount = mysqli_num_rows($result4);
  $mabiniCount = ($mabiniCount / $mCount) * 100;
  $mabiniCount = round($mabiniCount)."%";
  
  $conn -> close();

?>
<!-- script for counting the number of rows in the table -->
<?php

  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "SELECT * FROM tbnominees where campus = 'Tagum' ";
  $result5 = mysqli_query($conn,$query);
  $tagumCount = mysqli_num_rows($result5);
  $tagumCount = ($tagumCount / $mCount) * 100;
  $tagumCount = round($tagumCount)."%";
  
  $conn -> close();

?>

<!-- bar chart data -->
<?php
  $campus = $_SESSION['campus'];
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select college_name, COUNT(*)  from vw_voter where campus ='$campus' group by college_name";
  $resultBar1 = mysqli_query($conn,$query);
  $resultBar2= mysqli_query($conn,$query);
  
  $conn -> close(); 

?>
<?php
  $campus = $_SESSION['campus'];
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select count(distinct studID) from tb_votes where campus = '$campus' group by voter_college";
  $resultBar3 = mysqli_query($conn,$query);
  $resultBar4= mysqli_query($conn,$query);
  
  $conn -> close();

?>

<!-- pie chart data -->
<?php
  $campus = $_SESSION['campus'];
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select * from tb_voter where campus= '$campus'  ";
  $resultPie1 = mysqli_query($conn,$query);
  $resultPie2= mysqli_num_rows($resultPie1);
  
  $conn -> close();
?>

<?php
  $campus = $_SESSION['campus'];
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select DISTINCT studID  from tb_votes where campus = '$campus' ";
  $query2  = "select * from tb_voter where campus= '$campus'  ";
    
  $resultPie3 = mysqli_query($conn,$query);
  $resultPie5 = mysqli_query($conn,$query2);
  $resultPie4= mysqli_num_rows($resultPie3);
  $resultPie6 = mysqli_num_rows($resultPie5);
  
  $resultPie7 = (int)$resultPie6 - (int) $resultPie4;
  
  
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

<?php
$campus = $_SESSION['campus'];
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$query = "SELECT * from tbelectiondate";
$result = mysqli_query($conn,$query);

while($row = mysqli_fetch_assoc($result)){
    $_SESSION['election_end'] = $row['end_date']." ".$row['end_time'];
} 
$currDT= str_replace(' ', '', date(" j F Y h:i A"));
$end = str_replace(' ', '', $_SESSION['election_end']);

// if($end != $currDT){
//   echo "Go to no data.php";
// }
//  echo $end;

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

<!-- get the total number of voters -->
<?php
  $campus = $_SESSION['campus'];
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select * FROM tb_voter where campus = '$campus'";
  $vResult = mysqli_query($conn,$query);
  $vCount = mysqli_num_rows($vResult);
  
  $conn -> close();

?>
<!-- Total Number of Candidates Per Campus -->
<?php
$campus = $_SESSION['campus'];
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$query  = "select * FROM tbnominees WHERE campus = '$campus'";
$mResultC = mysqli_query($conn,$query);
$mCountC = mysqli_num_rows($mResultC);

$conn -> close();

?>

<!-- Total Number of Votes Cast Per Campus -->
<?php
$campus = $_SESSION['campus'];
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$query  = "select DISTINCT studID FROM tb_votes WHERE campus = '$campus'";
$vResultC = mysqli_query($conn,$query);
$vCountC = mysqli_num_rows($vResultC);

$conn -> close();

?>
