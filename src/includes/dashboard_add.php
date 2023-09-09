
<?php

include '../config/db_config.php';
?>
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
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$query = "SELECT * FROM tbnominees WHERE campus = 'Mabini'";
$result4 = mysqli_query($conn, $query);
$mabiniCount = mysqli_num_rows($result4);

// Avoid division by zero by checking if $mCount is not zero
if ($mCount != 0) {
    $mabiniCount = ($mabiniCount / $mCount) * 100;
    $mabiniCount = round($mabiniCount) . "%";
} else {
    // Handle the case where $mCount is zero
    $mabiniCount = "N/A"; // Set to a default value or handle as appropriate
}

$conn->close();
?>


<!--Percentage of the position in LC/SC being filled-->
<?php

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Query to count the number of positions with candidates
$queryFilledPositions = "SELECT COUNT(DISTINCT position) AS filled_positions FROM tbnominees where indicator = 'Local Council'";
$resultFilledPositions = mysqli_query($conn, $queryFilledPositions);
$rowFilledPositions = mysqli_fetch_assoc($resultFilledPositions);
$filledPositions = $rowFilledPositions['filled_positions'];

$queryFilledPositionsSC = "SELECT COUNT(DISTINCT position) AS filled_positionsSC FROM tbnominees where indicator = 'Student Council'";
$resultFilledPositionsSC = mysqli_query($conn, $queryFilledPositionsSC);
$rowFilledPositionsSC = mysqli_fetch_assoc($resultFilledPositionsSC);
$filledPositionsSC = $rowFilledPositionsSC['filled_positionsSC'];

// Query to count the total number of positions
$queryTotalPositions = "SELECT COUNT(*) AS total_positions FROM tbposition";
$resultTotalPositions = mysqli_query($conn, $queryTotalPositions);
$rowTotalPositions = mysqli_fetch_assoc($resultTotalPositions);
$totalPositions = $rowTotalPositions['total_positions'];

$queryTotalPositionsSC = "SELECT COUNT(*) AS total_positionsSC FROM tbcouncil";
$resultTotalPositionsSC = mysqli_query($conn, $queryTotalPositionsSC);
$rowTotalPositionsSC = mysqli_fetch_assoc($resultTotalPositionsSC);
$totalPositionsSC = $rowTotalPositionsSC['total_positionsSC'];

// Calculate the percentage of positions filled with candidates
if ($totalPositions > 0) {
    $percentageFilled = ($filledPositions / $totalPositions) * 100;
    $percentageFilled = number_format($percentageFilled, 2);
} else {
    $percentageFilled = 0;
}

if ($totalPositionsSC > 0) {
    $percentageFilledSC = ($filledPositionsSC / $totalPositionsSC) * 100;
    $percentageFilledSC = number_format($percentageFilledSC, 2);
} else {
    $percentageFilledSC = 0;
}


$conn->close();
?>


<?php
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$query = "SELECT * FROM tbnominees WHERE campus = 'Tagum'";
$result5 = mysqli_query($conn, $query);
$tagumCount = mysqli_num_rows($result5);

// Avoid division by zero by checking if $mCount is not zero
if ($mCount != 0) {
    $tagumCount = ($tagumCount / $mCount) * 100;
    $tagumCount = round($tagumCount) . "%";
} else {
    // Handle the case where $mCount is zero
    $tagumCount = "N/A"; // Set to a default value or handle as appropriate
}

$conn->close();
?>

<?php

$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$query  = "select * FROM tb_voter where campus = 'Tagum' ";
$result6 = mysqli_query($conn,$query);
$tagumCountVoter = mysqli_num_rows($result6);
$conn -> close();

?>
<?php

$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$query  = "select * FROM tb_voter where campus = 'Mabini' ";
$result7 = mysqli_query($conn,$query);
$mabiniCountVoter = mysqli_num_rows($result7);
$conn -> close();

?>

<!-- bar chart data -->
<?php
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Data fetching for Tagum chart
$queryTagumBar1 = "SELECT campus, COUNT(*) as 'tt_voter_tagum' FROM tb_voter WHERE campus = 'Tagum' GROUP BY campus";
$resultBar1Tagum = mysqli_query($conn, $queryTagumBar1);
$resultBar2Tagum = mysqli_query($conn, $queryTagumBar1);

$queryTagumBar3 = "SELECT campus, COUNT(DISTINCT studID) as 'count' FROM tb_votes WHERE campus = 'Tagum' GROUP BY campus";
$resultBar3Tagum = mysqli_query($conn, $queryTagumBar3);

// Data fetching for Mabini chart
$queryMabiniBar1 = "SELECT campus, COUNT(*) as 'tt_voter_mabini' FROM tb_voter WHERE campus = 'Mabini' GROUP BY campus";
$resultBar1Mabini = mysqli_query($conn, $queryMabiniBar1);
$resultBar2Mabini = mysqli_query($conn, $queryMabiniBar1);

$queryMabiniBar3 = "SELECT campus, COUNT(DISTINCT studID) as 'count_mabini' FROM tb_votes WHERE campus = 'Mabini' GROUP BY campus";
$resultBar3Mabini = mysqli_query($conn, $queryMabiniBar3);

$conn->close();
?>

<!-- pie chart data Tagum -->
<?php
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select *  from tb_voter  WHERE campus = 'Tagum'";
  $resultPie1 = mysqli_query($conn,$query);
  $resultPie2= mysqli_num_rows($resultPie1);

  $conn -> close();
?>
<!-- pie chart data Mabini -->
<?php
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$query  = "select *  from tb_voter  WHERE campus = 'Mabini'";
$resultPie3 = mysqli_query($conn,$query);
$resultPie4= mysqli_num_rows($resultPie3);

$conn -> close();
?>
<?php
  $campus = $_SESSION['campus'];
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select DISTINCT studID,voter_college,campus from tb_votes where campus = '$campus' ";
  $query2  = "select *  from tb_voter where campus = '$campus'";

  $resultPie3 = mysqli_query($conn,$query);
  $resultPie5 = mysqli_query($conn,$query2);
  $resultPie4= mysqli_num_rows($resultPie3);
  $resultPie6= mysqli_num_rows($resultPie5);

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

  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "select * FROM tb_voter";
  $vResult = mysqli_query($conn,$query);
  $vCount = mysqli_num_rows($vResult);

  $conn -> close();

?>
<?php
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Get the count of voters who voted
$query = "SELECT COUNT(DISTINCT studID) AS voteCount FROM tb_votes";
$voteResult = mysqli_query($conn, $query);
$rowVote = mysqli_fetch_assoc($voteResult);
$countVoterWhoVote = $rowVote['voteCount'];

// Get the count of overall voters
$query = "SELECT COUNT(*) AS voterCount FROM tb_voter";
$voterResult = mysqli_query($conn, $query);
$rowVoter = mysqli_fetch_assoc($voterResult);
$countOverallVoter = $rowVoter['voterCount'];

// Calculate the count of voters who did not vote
$countVoterWhoDidNotVote = $countOverallVoter - $countVoterWhoVote;

$conn->close();



?>
