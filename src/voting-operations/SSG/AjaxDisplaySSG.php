<?php 
session_start();
include '../../config/db_config.php';
include '../Decryption.php';

$connect=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$flag = array(false, false, false, false, false, false, false, false, false, false);
$check = false;

//Only 4 Position Available in SSG
for($count=0; $count < 10; $count++) {
    $campus=mysqli_real_escape_string($connect,decryption($_POST['campus']));

    $query='SELECT DISTINCT position_name FROM tbssgposition';
    $resultPosition=mysqli_query($connect, $query);

    if($check==false) {
        while($rowPosition=mysqli_fetch_array($resultPosition)) {
            $query1='SELECT * FROM tbssgnominees WHERE position = "'.$rowPosition["position_name"].'"';
            $resultCandidate=mysqli_query($connect, $query1);

            if(mysqli_num_rows($resultCandidate) > 0) {
                $flag[$count]=true;
                $count++;
            }else{
                $flag[$count]=false;
                $count++;
            }
        }
        $check=true;
    }else{
        $flag[$count]=false;
    }
}
echo json_encode(array($flag));
?>