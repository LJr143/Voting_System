
<?php
$campus = $_SESSION['campus'];
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$query  = "SELECT * FROM vw_voter WHERE campus = '$campus'
ORDER BY college_name";
$nominees = array();
$result = mysqli_query($conn,$query);
while ($row = mysqli_fetch_assoc($result)) {
    $nominees[] = $row;
}
$conn -> close();
?>

<?php
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if(isset($_POST["import"]))
{
    $file = $_FILES["file"]["tmp_name"];
    $file_open = fopen($file,"r");
    while(($csv = fgetcsv($file_open, 1000, ",")) !== false)
    {
        $studID = $csv[0];
        $fname = $csv[1];
        $lname = $csv[2];
        mysqli_query($conn,"INSERT INTO tb_voter VALUES ('$studID','$fname','$lname')");
    }
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