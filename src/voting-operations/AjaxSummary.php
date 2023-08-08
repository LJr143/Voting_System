<?php
    session_start();
    include '../config/db_config.php';
    include 'Decryption.php';

    $connect = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    $campus = mysqli_real_escape_string($connect,decryption($_POST['campus']));
    $college = mysqli_real_escape_string($connect, $_POST['college']);

    $ID = array($_POST['ID1'],$_POST['ID2'],$_POST['ID3'],$_POST['ID4'],$_POST['ID5'],$_POST['ID6'],$_POST['ID7'],$_POST['ID8'],$_POST['ID9'],$_POST['ID10']);

    $IDLocal = array($_POST['IDLocal1'],$_POST['IDLocal2'],$_POST['IDLocal3'],$_POST['IDLocal4'],$_POST['IDLocal5'],$_POST['IDLocal6'],$_POST['IDLocal7'],$_POST['IDLocal8'],$_POST['IDLocal9'],$_POST['IDLocal10'],$_POST['IDLocal11'],$_POST['IDLocal12'],$_POST['IDLocal13'],$_POST['IDLocal14'],$_POST['IDLocal15']);

    //Student Council
    for($count = 0; $count < 10; $count++){
        $query = 'SELECT DISTINCT position_name FROM tbcouncil WHERE campus = "'.$campus.'" ';
        $resultposition = mysqli_query($connect, $query);
        $resultCheckeposition = mysqli_num_rows($resultposition);

        $flag = false;
        if($flag == false){
            while($rowPosition = mysqli_fetch_assoc($resultposition)){
                if($count < ($resultCheckeposition )){
                    $query1 = 'select * from tbnominees where id="'.$ID[$count].'" AND position ="'.$rowPosition["position_name"].'" ';
                    $resultId = mysqli_query($connect,$query1);
                    $resultCheckeId = mysqli_num_rows($resultId);

                    if($resultCheckeId > 0){
                        while($row = mysqli_fetch_assoc($resultId)){
                            $position[$count] = $rowPosition['position_name'];
                            $final[$count] = $row['fname'].' '.$row['lname'];
                            $count++;
                        }
                    }else{
                        $position[$count] = $rowPosition['position_name'];
                        $final[$count] = "No Vote";
                        $count++;
                    }
                }
            }
            $flag = true;
        }else{
            $position[$count] = 0;
            $count++;
            
        }  
    }
    
    //Local Council
    for($count = 0; $count < 16; $count++){
        $query = 'SELECT DISTINCT position_name FROM tbposition WHERE campus = "'.$campus.'" ';
        $resultpositionLocal = mysqli_query($connect, $query);
        $resultCheckepositionLocal = mysqli_num_rows($resultpositionLocal);

        $flag = false;
        if($flag == false){
            while($rowPosition = mysqli_fetch_assoc($resultpositionLocal)){
                if($count <= $resultCheckepositionLocal ){
                    $query1 = 'select * from tbnominees where id="'.$IDLocal[$count].'" AND position ="'.$rowPosition["position_name"].'" ';
                    $resultIdLocal = mysqli_query($connect,$query1);
                    $resultCheckeIdLocal = mysqli_num_rows($resultIdLocal);

                    if($resultCheckeIdLocal > 0){
                        while($row = mysqli_fetch_assoc($resultIdLocal)){
                            $positionLocal[$count] = $rowPosition['position_name'];
                            $finalLocal[$count] = $row['fname'].' '.$row['lname'];
                            $count++;
                        }
                    }else{
                        
                        if($rowPosition['position_name'] == "Business Manager" && $campus == "Tagum"){
                            $query2 = 'select * from tbnominees where position ="'.$rowPosition["position_name"].'" ';
                            $result2 = mysqli_query($connect,$query2);
                                
                            if(mysqli_num_rows($result2) > 1){
                                $query3 = 'select * from tbnominees where id="'.$IDLocal[10].'" AND position ="'.$rowPosition["position_name"].'" ';
                                $result3 = mysqli_query($connect,$query3);
                                
                                if(mysqli_num_rows($result3) > 0){
                                    while($row1 = mysqli_fetch_assoc($result3)){
                                    
                                        $finalLocal[$count] = $row1['fname'].' '.$row1['lname'];
                                        $positionLocal[$count] = $rowPosition['position_name'];
                                        $count++;
                                    }
                                }else{
                                    $positionLocal[$count] = $rowPosition['position_name'];
                                    $finalLocal[$count] = "No Vote";
                                    $count++;
                                }

                                $query4 = 'select * from tbnominees where id="'.$IDLocal[11].'" AND position ="'.$rowPosition["position_name"].'" ';
                                $result4 = mysqli_query($connect,$query4);

                                if(mysqli_num_rows($result4) > 0){
                                    while($row2 = mysqli_fetch_assoc($result4)){
                                        $finalLocal[$count] = $row2['fname'].' '.$row2['lname'];
                                        $positionLocal[$count] = $rowPosition['position_name'];
                                        $count++;
                                    }
                                }else{
                                    $positionLocal[$count] = $rowPosition['position_name'];
                                    $finalLocal[$count] = "No Vote";
                                    $count++;
                                }

                            }else{
                                $query5 = 'select * from tbnominees where id="'.$IDLocal[10].'" AND position ="'.$rowPosition["position_name"].'" ';
                                $result5 = mysqli_query($connect,$query5);
                                
                                if(mysqli_num_rows($result5) > 0){
                                    while($row3 = mysqli_fetch_assoc($result5)){
                                        $positionLocal[$count] = $rowPosition['position_name'];
                                        $finalLocal[$count] = $row3['fname'].' '.$row3['lname'];
                                        $count++;
                                    }
                                }else{
                                    $positionLocal[$count] = $rowPosition['position_name'];
                                    $finalLocal[$count] = "No Vote";
                                    $count++;
                                }
                            }
                        }else if($rowPosition['position_name'] == "Senator" && $campus == "Tagum"){
                            $query2 = 'select * from tbnominees where position ="'.$rowPosition["position_name"].'" ';
                            $result2 = mysqli_query($connect,$query2);
                               
                            if(mysqli_num_rows($result2) >= 2 ){
                                $query3 = 'select * from tbnominees where id="'.$IDLocal[12].'" AND position ="'.$rowPosition["position_name"].'" ';
                                $result3 = mysqli_query($connect,$query3);
                                
                                if(mysqli_num_rows($result3) > 0){
                                    while($row1 = mysqli_fetch_assoc($result3)){
                                    
                                        $finalLocal[$count] = $row1['fname'].' '.$row1['lname'];
                                        $positionLocal[$count] = $rowPosition['position_name'];
                                        $count++;
                                    }
                                }else{
                                    $positionLocal[$count] = $rowPosition['position_name'];
                                    $finalLocal[$count] = "No Vote";
                                    $count++;
                                }

                                $query4 = 'select * from tbnominees where id="'.$IDLocal[13].'" AND position ="'.$rowPosition["position_name"].'" ';
                                $result4 = mysqli_query($connect,$query4);

                                if(mysqli_num_rows($result4) > 0){
                                    while($row2 = mysqli_fetch_assoc($result4)){
                                        $finalLocal[$count] = $row2['fname'].' '.$row2['lname'];
                                        $positionLocal[$count] = $rowPosition['position_name'];
                                        $count++;
                                    }
                                }else{
                                    $positionLocal[$count] = $rowPosition['position_name'];
                                    $finalLocal[$count] = "No Vote";
                                    $count++;
                                }

                                //above 3 candidate
                                if(mysqli_num_rows($result2) >= 3 ){
                                    $query5 = 'select * from tbnominees where id="'.$IDLocal[14].'" AND position ="'.$rowPosition["position_name"].'" ';
                                    $result5 = mysqli_query($connect,$query5);

                                    if(mysqli_num_rows($result5) > 0){
                                        while($row3 = mysqli_fetch_assoc($result5)){
                                            $finalLocal[$count] = $row3['fname'].' '.$row3['lname'];
                                            $positionLocal[$count] = $rowPosition['position_name'];
                                            $count++;
                                        }
                                    }else{
                                        $positionLocal[$count] = $rowPosition['position_name'];
                                        $finalLocal[$count] = "No Vote";
                                        $count++;
                                    }
                                }
                            }else{
                                $query5 = 'select * from tbnominees where id="'.$IDLocal[12].'" AND position ="'.$rowPosition["position_name"].'" ';
                                $result5 = mysqli_query($connect,$query5);
                                
                                if(mysqli_num_rows($result5) > 0){
                                    while($row3 = mysqli_fetch_assoc($result5)){
                                        $positionLocal[$count] = $rowPosition['position_name'];
                                        $finalLocal[$count] = $row3['fname'].' '.$row3['lname'];
                                        $count++;
                                    }
                                }else{
                                    $positionLocal[$count] = $rowPosition['position_name'];
                                    $finalLocal[$count] = "No Vote";
                                    $count++;
                                }
                            }
                        }else{
                            $positionLocal[$count] = $rowPosition['position_name'];
                            $finalLocal[$count] = "No Vote";
                            $count++;
                        }
                    }
                }
            }
            $flag = true;
        }else{
            $positionLocal[$count] = 0;
            $count++;
        }  
    }
    echo json_encode(array($final,$position,$finalLocal,$positionLocal));
?>