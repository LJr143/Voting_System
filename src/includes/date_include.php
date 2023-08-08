<?php
    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    $flag;
    $flag1;
    $flag2;

    //Check For Election Date In SSG 
    $result = mysqli_query($conn,'SELECT * FROM tbelectiondate_other WHERE indicator = "SSG"');
    $totalRow = mysqli_num_rows($result);

    if($totalRow > 0){
        while($row = mysqli_fetch_assoc($result)){
            $electionEnd = $row['end_date']." ".$row['end_time'];

            $electionEnd = strtotime($electionEnd);
            $currDT= strtotime(date(" j F Y h:i"));
                    
            if($currDT > $electionEnd){
                $flag = 'true';
            }else{
                $flag = 'false';
            }
        }
    }

    //Check For Election Date In Plebiscite
    $result = mysqli_query($conn,'SELECT * FROM tbelectiondate_other WHERE indicator = "Plebiscite"');
    $totalRow = mysqli_num_rows($result);

    if($totalRow > 0){
        while($row = mysqli_fetch_assoc($result)){
            $electionEnd = $row['end_date']." ".$row['end_time'];

            $electionEnd = strtotime($electionEnd);
            $currDT= strtotime(date(" j F Y h:i"));
                    
            if($currDT > $electionEnd){
                $flag1 = 'true';
            }else{
                $flag1 = 'false';
            }
        }
    }

    //Check For Election Date In Student Council and Local Council
    $result = mysqli_query($conn,'SELECT * FROM tbelectiondate');
    $totalRow = mysqli_num_rows($result);

    if($totalRow > 0){
        while($row = mysqli_fetch_assoc($result)){
            $electionEnd = $row['end_date']." ".$row['end_time'];

            $electionEnd = strtotime($electionEnd);
            $currDT= strtotime(date(" j F Y h:i"));
                    
            if($currDT > $electionEnd){
                $flag2 = 'true';
            }else{
                $flag2 = 'false';
            }
        }
    }

    $conn -> close();
?>