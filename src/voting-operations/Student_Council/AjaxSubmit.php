<?php
    session_start();
    include '../../config/db_config.php';
    include '../Decryption.php';

    $connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    //Ajax Submit For Pamulaan And Without Local Council
    $studid = mysqli_real_escape_string($connect, decryption($_POST["voter"]));
    $campus = mysqli_real_escape_string($connect, decryption($_POST["campus"]));
    $voter_college;

    $Voted = array($_POST['ID1'], $_POST['ID2'], $_POST['ID3'], $_POST['ID4'], $_POST['ID5'], $_POST['ID6'], $_POST['ID7'], $_POST['ID8'], $_POST['ID9'], $_POST['ID10']);

    $queryChecker = 'select * from tb_votes where studID="'.$studid.'" AND campus="'.$campus.'"';
    $resultChecker = mysqli_query($connect, $queryChecker);
    $resultCountChecker = mysqli_num_rows($resultChecker);
    if ($resultCountChecker > 0) {
        echo json_encode(array('NotCast'));
    } else {
        $query = 'select * from vw_voter where stud_id="'.$studid.'" AND campus="'.$campus.'"';
        $result = mysqli_query($connect, $query);
        $resultChecke = mysqli_num_rows($result);

        if ($resultChecke > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $campus = $row['campus'];
                $voter_college = $row['college_name'];
            }
        }

        $count = 0;
        $query = 'SELECT DISTINCT position_name FROM tbcouncil WHERE campus = "'.$campus.'" ';
        $result = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_array($result)) {

            $querynominees = 'SELECT * FROM tbnominees WHERE id = "'.$Voted[$count].'" AND position ="'.$row["position_name"].'" ';
            $resultnominees = mysqli_query($connect, $querynominees);
            if (mysqli_num_rows($resultnominees) > 0) {
                while ($rownominees = mysqli_fetch_array($resultnominees)) {
                    $nameCand = $rownominees['fname']." ".$rownominees['lname'];
                    $college = $rownominees['college'];
                    $program = $rownominees['program'];
                    $position = $rownominees['position'];
                    $image = $rownominees['image'];
                    $indicator = $rownominees['indicator'];

                    $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','$nameCand','$campus','$voter_college','$college','$program','$position','$image','$indicator')";
                    $connect -> query($sql);
                    $count++;
                }
            } else {
                $position = $row['position_name'];
                $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','Abstain','$campus','$voter_college','Abstain','Abstain','$position','Abstain.jpg','Student Council')";
                $connect -> query($sql);
                $count++;
            }
        }
        echo json_encode(array('Cast'));
    }

    $_SESSION["Ticket"] = "Pass";
    unset($_SESSION["saved"]);
    unset($_SESSION["Proceed"]);
    unset($_SESSION["ProceedLocal"]);
    unset($_SESSION["Usep-Comelec"]);
    setcookie("top", "", time() - 3600); 
?>