<?php
    session_start();
    include '../../config/db_config.php';
    include '../Decryption.php';

    date_default_timezone_set('Asia/Manila');

    $connect = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    $studid = mysqli_real_escape_string($connect,decryption($_POST["voter"]));
    $campus = mysqli_real_escape_string($connect,decryption($_POST["campus"]));
    $voter_college;

    $Voted = array($_POST['ID1'], $_POST['ID2'], $_POST['ID3'], $_POST['ID4'], $_POST['ID5'], $_POST['ID6'], $_POST['ID7'], $_POST['ID8'], $_POST['ID9'], $_POST['ID10']);

    //Checks If The Voter Already Voted
        $queryChecker = 'select * from tb_ssgvotes where studID="'.$studid.'" AND campus="'.$campus.'"';
        $resultChecker = mysqli_query($connect,$queryChecker);
        $resultCountChecker = mysqli_num_rows($resultChecker);
        if($resultCountChecker > 0){
            echo json_encode(array('NotCast')); 
        }else{
            //Get the Voter Information
            $query = 'select * from tbssgvoters where stud_id="'.$studid.'" AND campus="'.$campus.'"';
            $result = mysqli_query($connect,$query);
            $resultChecke = mysqli_num_rows($result);

            if($resultChecke > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $voter_college = $row['college'];
                }
            }

            $count = 0;
            $query = 'SELECT DISTINCT position_name FROM tbssgposition';
            $result = mysqli_query($connect,$query);
            while($row = mysqli_fetch_array($result)){

                $querynominees = 'SELECT * FROM tbssgnominees WHERE stud_id = "'.$Voted[$count].'" AND position ="'.$row["position_name"].'" ';
                $resultnominees = mysqli_query($connect,$querynominees);
                if(mysqli_num_rows($resultnominees) > 0){
                    while($rownominees = mysqli_fetch_array($resultnominees)){
                        $nameCand = $rownominees['fname']." ".$rownominees['lname'] ;
                        $college = $rownominees['college'];
                        $program = $rownominees['program'];
                        $position = $rownominees['position'];
                        $image = $rownominees['image'];

                        $sql = "INSERT INTO tb_ssgvotes (studID,nameCand,campus,voter_college,college,program,position,image) VALUES ('$studid','$nameCand','$campus','$voter_college','$college','$program','$position','$image')";
                        $connect->query($sql);
                        $count++;
                    }
                }else{
                    $position = $row['position_name'];
                    $sql = "INSERT INTO tb_ssgvotes (studID,nameCand,campus,voter_college,college,program,position,image) VALUES ('$studid','Abstain','$campus','$voter_college','Abstain','Abstain','$position','Abstain.jpg')";
                    $connect->query($sql);    
                    $count++;    
                }
            }

            //tblogs for ssgadmin system logs
            $tempCampus ="ssgadmin";
            $dt = date('Y-m-d G:i:s');
            $action = ''.$studid.' | Casted Vote ';

            $query = "INSERT INTO tblogs(name,action,timestamp) VALUES('$tempCampus', '$action','$dt')";
            $connect->query($query); 

            //End Of Submitting SSG
            echo json_encode(array('Cast')); 
        }
    $_SESSION["Ticket"] = "Pass";
    unset($_SESSION["savedSSG"]);
    unset($_SESSION["Usep-Comelec"]);
    //session_destroy();
    setcookie("top","", time() -3600);
?>