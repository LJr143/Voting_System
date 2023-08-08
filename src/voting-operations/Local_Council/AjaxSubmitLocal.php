<?php
    session_start();
    include '../../config/db_config.php';
    include '../Decryption.php';
    $connect = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    $studid = mysqli_real_escape_string($connect,decryption($_POST["voter"]));
    $campus = mysqli_real_escape_string($connect,decryption($_POST["campus"]));
    $voter_college;

    $Voted = array($_POST['ID1'],$_POST['ID2'],$_POST['ID3'],$_POST['ID4'],$_POST['ID5'],$_POST['ID6'],$_POST['ID7'],$_POST['ID8'],$_POST['ID9'],$_POST['ID10']);

    //Check If The Voter Is Already Voted
        $queryChecker = 'select * from tb_votes where studID="'.$studid.'" AND campus="'.$campus.'"';
        $resultChecker = mysqli_query($connect,$queryChecker);
        $resultCountChecker = mysqli_num_rows($resultChecker);
        if($resultCountChecker > 0){
            echo json_encode(array('NotCast')); 
        }else{
            //Get the Voters Information
            $query = 'select * from vw_voter where stud_id="'.$studid.'" AND campus="'.$campus.'"';
            $result = mysqli_query($connect,$query);
            $resultChecke = mysqli_num_rows($result);

            if($resultChecke > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $campus = $row['campus'];
                    $voter_college = $row['college_name'];
                }
            }

            //Start Of Submitting Student Council
            $count = 0;
            $query = 'SELECT DISTINCT position_name FROM tbcouncil WHERE campus = "'.$campus.'" ';
            $result = mysqli_query($connect,$query);
            while($row = mysqli_fetch_array($result)){

                $querynominees = 'SELECT * FROM tbnominees WHERE id = "'.$Voted[$count].'" AND position ="'.$row["position_name"].'" ';
                $resultnominees = mysqli_query($connect,$querynominees);
                if(mysqli_num_rows($resultnominees) > 0){
                    while($rownominees = mysqli_fetch_array($resultnominees)){
                        $nameCand = $rownominees['fname']." ".$rownominees['lname'] ;
                        $college = $rownominees['college'];
                        $program = $rownominees['program'];
                        $position = $rownominees['position'];
                        $image = $rownominees['image'];
                        $indicator = $rownominees['indicator'];

                        $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','$nameCand','$campus','$voter_college','$college','$program','$position','$image','$indicator')";
                        $connect->query($sql);
                        $count++;
                    }
                }else{
                    $position = $row['position_name'];
                    $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','Abstain','$campus','$voter_college','Abstain','Abstain','$position','Abstain.jpg','Student Council')";
                    $connect->query($sql);    
                    $count++;    
                }
            }
            //End Of Submitting Student Council

            //Start Of Submitting Local Council
            $VotedLocal = array($_POST['IDLocal1'],$_POST['IDLocal2'],$_POST['IDLocal3'],$_POST['IDLocal4'],$_POST['IDLocal5'],$_POST['IDLocal6'],$_POST['IDLocal7'],$_POST['IDLocal8'],$_POST['IDLocal9'],$_POST['IDLocal10'],$_POST['IDLocal11'],$_POST['IDLocal12'],$_POST['IDLocal13'],$_POST['IDLocal14'],$_POST['IDLocal15']);
            $count = 0;
            $query = 'SELECT DISTINCT position_name FROM tbposition WHERE campus = "'.$campus.'" ';
            $result = mysqli_query($connect,$query);
            
            while($row = mysqli_fetch_array($result)){
                $querynominees = 'SELECT * FROM tbnominees WHERE id = "'.$VotedLocal[$count].'" AND position ="'.$row["position_name"].'" ';
                $resultnominees = mysqli_query($connect,$querynominees);
                if(mysqli_num_rows($resultnominees) > 0){
                    while($rownominees = mysqli_fetch_array($resultnominees)){
                        $nameCand = $rownominees['fname']." ".$rownominees['lname'] ;
                        $college = $rownominees['college'];
                        $program = $rownominees['program'];
                        $position = $rownominees['position'];
                        $image = $rownominees['image'];
                        $indicator = $rownominees['indicator'];

                        $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','$nameCand','$campus','$voter_college','$college','$program','$position','$image','$indicator')";
                        $connect->query($sql);
                        $count++;
                    }
                }else{
                    if($row['position_name'] == "Bussines Manager" && $campus == "Tagum"){
                        $querybussines = 'SELECT * FROM tbnominees WHERE position = "'.$row['position_name'].'" ';
                        $resultbussines = mysqli_query($connect,$querybussines);

                        if(mysqli_num_rows($resultbussines) > 1){
                            $query3 = 'select * from tbnominees where id="'.$VotedLocal[10].'" AND position ="'.$row["position_name"].'" ';
                            $result3 = mysqli_query($connect,$query3);
                                        
                            if(mysqli_num_rows($result3) > 0){
                                while($rownominees = mysqli_fetch_array($result3)){
                                    $nameCand = $rownominees['fname']." ".$rownominees['lname'] ;
                                    $college = $rownominees['college'];
                                    $program = $rownominees['program'];
                                    $position = $rownominees['position'];
                                    $image = $rownominees['image'];
                                    $indicator = $rownominees['indicator'];

                                    $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','$nameCand','$campus','$voter_college','$college','$program','$position','$image','$indicator')";
                                    $connect->query($sql);
                                    $count++;
                                }
                            }else{
                                $position = $row['position_name'];
                                $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','Abstain','$campus','$voter_college','Abstain','Abstain','$position','Abstain.jpg','Local Council')";
                                $connect->query($sql);    
                                $count++;   
                            }

                            $query4 = 'select * from tbnominees where id="'.$VotedLocal[11].'" AND position ="'.$row["position_name"].'" ';
                            $result4 = mysqli_query($connect,$query4);

                            if(mysqli_num_rows($result4) > 0){
                                while($rownominees = mysqli_fetch_array($result4)){
                                    $nameCand = $rownominees['fname']." ".$rownominees['lname'] ;
                                    $college = $rownominees['college'];
                                    $program = $rownominees['program'];
                                    $position = $rownominees['position'];
                                    $image = $rownominees['image'];
                                    $indicator = $rownominees['indicator'];

                                    $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','$nameCand','$campus','$voter_college','$college','$program','$position','$image','$indicator')";
                                    $connect->query($sql);
                                    $count++;
                                }
                            }else{
                                $position = $row['position_name'];
                                $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','Abstain','$campus','$voter_college','Abstain','Abstain','$position','Abstain.jpg','Local Council')";
                                $connect->query($sql);    
                                $count++;  
                            }

                        }else{
                            $query5 = 'select * from tbnominees where id="'.$VotedLocal[10].'" AND position ="'.$row["position_name"].'" ';
                            $result5 = mysqli_query($connect,$query5);
                                        
                            if(mysqli_num_rows($result5) > 0){
                                while($rownominees = mysqli_fetch_array($result5)){
                                    $nameCand = $rownominees['fname']." ".$rownominees['lname'] ;
                                    $college = $rownominees['college'];
                                    $program = $rownominees['program'];
                                    $position = $rownominees['position'];
                                    $image = $rownominees['image'];
                                    $indicator = $rownominees['indicator'];

                                    $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','$nameCand','$campus','$voter_college','$college','$program','$position','$image','$indicator')";
                                    $connect->query($sql);
                                    $count++;
                                }
                            }else{
                                $position = $row['position_name'];
                                $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','Abstain','$campus','$voter_college','Abstain','Abstain','$position','Abstain.jpg','Local Council')";
                                $connect->query($sql);    
                                $count++;  
                            }
                        }
                    }else if($row['position_name'] == "Senator" && $campus == "Tagum"){
                        $querysenator = 'SELECT * FROM tbnominees WHERE position = "'.$row['position_name'].'"';
                        $resultsenator = mysqli_query($connect,$querysenator);

                        if(mysqli_num_rows($resultsenator) >= 2){
                            $query3 = 'select * from tbnominees where id="'.$VotedLocal[12].'" AND position ="'.$row["position_name"].'" ';
                            $result3 = mysqli_query($connect,$query3);
                                        
                            if(mysqli_num_rows($result3) > 0){
                                while($rownominees = mysqli_fetch_array($result3)){
                                    $nameCand = $rownominees['fname']." ".$rownominees['lname'] ;
                                    $college = $rownominees['college'];
                                    $program = $rownominees['program'];
                                    $position = $rownominees['position'];
                                    $image = $rownominees['image'];
                                    $indicator = $rownominees['indicator'];

                                    $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','$nameCand','$campus','$voter_college','$college','$program','$position','$image','$indicator')";
                                    $connect->query($sql);
                                    $count++;
                                }
                            }else{
                                $position = $row['position_name'];
                                $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','Abstain','$campus','$voter_college','Abstain','Abstain','$position','Abstain.jpg','Local Council')";
                                $connect->query($sql);    
                                $count++;   
                            }

                            $query4 = 'select * from tbnominees where id="'.$VotedLocal[13].'" AND position ="'.$row["position_name"].'" ';
                            $result4 = mysqli_query($connect,$query4);

                            if(mysqli_num_rows($result4) > 0 ){
                                while($rownominees = mysqli_fetch_array($result4)){
                                    $nameCand = $rownominees['fname']." ".$rownominees['lname'] ;
                                    $college = $rownominees['college'];
                                    $program = $rownominees['program'];
                                    $position = $rownominees['position'];
                                    $image = $rownominees['image'];
                                    $indicator = $rownominees['indicator'];

                                    $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','$nameCand','$campus','$voter_college','$college','$program','$position','$image','$indicator')";
                                    $connect->query($sql);
                                    $count++;
                                }
                            }else{
                                $position = $row['position_name'];
                                $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','Abstain','$campus','$voter_college','Abstain','Abstain','$position','Abstain.jpg','Local Council')";
                                $connect->query($sql);    
                                $count++;  
                            }
                            
                            //above 3 candidate
                            if(mysqli_num_rows($resultsenator) >= 3){
                                $query5 = 'select * from tbnominees where id="'.$VotedLocal[14].'" AND position ="'.$row["position_name"].'" ';
                                $result5 = mysqli_query($connect,$query5);

                                if(mysqli_num_rows($result5) > 0){
                                    while($rownominees = mysqli_fetch_array($result5)){
                                        $nameCand = $rownominees['fname']." ".$rownominees['lname'] ;
                                        $college = $rownominees['college'];
                                        $program = $rownominees['program'];
                                        $position = $rownominees['position'];
                                        $image = $rownominees['image'];
                                        $indicator = $rownominees['indicator'];

                                        $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','$nameCand','$campus','$voter_college','$college','$program','$position','$image','$indicator')";
                                        $connect->query($sql);
                                        $count++;
                                    }
                                }else{
                                    $position = $row['position_name'];
                                    $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','Abstain','$campus','$voter_college','Abstain','Abstain','$position','Abstain.jpg','Local Council')";
                                    $connect->query($sql);    
                                    $count++;  
                                }
                            }
                        }else{
                            $query5 = 'select * from tbnominees where id="'.$VotedLocal[12].'" AND position ="'.$row["position_name"].'" ';
                            $result5 = mysqli_query($connect,$query5);
                                        
                            if(mysqli_num_rows($result5) > 0){
                                while($rownominees = mysqli_fetch_array($result5)){
                                    $nameCand = $rownominees['fname']." ".$rownominees['lname'] ;
                                    $college = $rownominees['college'];
                                    $program = $rownominees['program'];
                                    $position = $rownominees['position'];
                                    $image = $rownominees['image'];
                                    $indicator = $rownominees['indicator'];

                                    $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','$nameCand','$campus','$voter_college','$college','$program','$position','$image','$indicator')";
                                    $connect->query($sql);
                                    $count++;
                                }
                            }else{
                                $position = $row['position_name'];
                                $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','Abstain','$campus','$voter_college','Abstain','Abstain','$position','Abstain.jpg','Local Council')";
                                $connect->query($sql);    
                                $count++;  
                            }
                        }
                    }else{
                        $position = $row['position_name'];
                        $sql = "INSERT INTO tb_votes (studID,nameCand,campus,voter_college,college,program,position,image,indicator) VALUES ('$studid','Abstain','$campus','$voter_college','Abstain','Abstain','$position','Abstain.jpg','Local Council')";
                        $connect->query($sql);    
                        $count++;   
                    } 
                }
            }
            //End Of Submitting Local Council
            echo json_encode(array('Cast')); 
        }
    $_SESSION["Ticket"] = "Pass";
    unset($_SESSION["saved"]);
    unset($_SESSION["Proceed"]);
    unset($_SESSION["ProceedLocal"]);
    unset($_SESSION["Usep-Comelec"]);
    //session_destroy();
    setcookie("top","", time() -3600);
?>