<?php 
   session_start();
   include '../../config/db_config.php';
   include '../Decryption.php';

   $connect = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

   $voter = mysqli_real_escape_string($connect,decryption($_POST['voter']));
   $campus = mysqli_real_escape_string($connect,decryption($_POST['campus']));
   $college;
   $program;
   $year;

   $query = 'select * from vw_voter where stud_id="'.$voter.'" AND campus="'.$campus.'"';
   $result = mysqli_query($connect,$query);
   $resultChecke = mysqli_num_rows($result);
   if($resultChecke > 0){
      while($row = mysqli_fetch_assoc($result)){
         $campus = $row['campus'];
         $college = $row['college_name'];
         $program = $row['college_program_name'];
         $year = $row['year'];
      }
    } 
   
   //Function For Checking Special Position
   function Make_Query_For_Local_Council($connect,$campus,$college,$program,$year,$position){
   if($campus == "Tagum"){
      if($position == "Senator" || $position == "Business Manager"){
         //Senator (2 per program)
         //dili kay kung siya lng isa
         $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND college ="'.$college.'" AND program ="'.$program.'"  AND indicator = "local council" ORDER BY id ASC ';
         $result = mysqli_query($connect, $query);
      }else{
         if($program == "BS in Agricultural and Biosystems Engineering" || $program == "Bachelor of Science in Agricultural Engineering"){
         //Society of Agricultural and Biosystem Engineering Students (SABES)
         $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND college ="'.$college.'" AND (program = "BS in Agricultural and Biosystems Engineering" OR program = "Bachelor of Science in Agricultural Engineering")  AND indicator = "local council" ORDER BY id ASC ';
         $result = mysqli_query($connect, $query);
         $lcname = "Society of Agricultural and Biosystem Engineering Students";
         }elseif($program == "Bachelor of Elementary Education" || $program == "Bachelor of Special Needs Education" || $program == "Bachelor of Early Childhood Education"){
         //Organization of Future Elementary Educators (OFEE)
         $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND college ="'.$college.'" AND (program = "Bachelor of Elementary Education" OR program = "Bachelor of Special Needs Education" OR program = "Bachelor of Early Childhood Education")  AND indicator = "local council" ORDER BY id ASC ';
         $result = mysqli_query($connect, $query);
         $lcname = "Organization of Future Elementary Educators";
         }elseif($program == "BSEd"|| $program == "Bachelor of Technical-vocational Teacher Education"){
         //Association of Future Secondary Teachers (AFSeT)
         $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND college ="'.$college.'" AND (program = "BSEd" OR program = "Bachelor of Technical-vocational Teacher Education")  AND indicator = "local council" ORDER BY id ASC ';
         $result = mysqli_query($connect, $query);
         $lcname = "Association of Future Secondary Teachers";
         }elseif($program == "Bachelor of Science in Information Technology"){
         //Society of Information and Technology Students
         $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND college ="'.$college.'" AND program ="'.$program.'"  AND indicator = "local council" ORDER BY id ASC ';
         $result = mysqli_query($connect, $query);
         $lcname = "Society of Information and Technology Students";
         }
      }
   }elseif($campus == "Mabini"){
      if($position == "Representative" ){
         $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND college ="'.$college.'" AND program ="'.$program.'" AND year ="'.$year.'"  AND indicator = "local council" ORDER BY id ASC ';
         $result = mysqli_query($connect, $query);
      }else{
         $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND college ="'.$college.'" AND program ="'.$program.'" AND indicator = "local council" ORDER BY id ASC ';
         $result = mysqli_query($connect, $query);
      }
      $lcname = $program;
   }
   else{
   }  
   return $result;
   }
   
   //Check If The Student Proceed to the Local Council
   //Only 10 Position in The Local Council Available
   //Only 2 Available For Special Position
    if(isset($_SESSION["ProceedLocal"])){
      $ID = array($_SESSION["IdLocal"][0],$_SESSION["IdLocal"][1],$_SESSION["IdLocal"][2],$_SESSION["IdLocal"][3],$_SESSION["IdLocal"][4],$_SESSION["IdLocal"][5],$_SESSION["IdLocal"][6],$_SESSION["IdLocal"][7],$_SESSION["IdLocal"][8],$_SESSION["IdLocal"][9],$_SESSION["IdLocal"][10],$_SESSION["IdLocal"][11],$_SESSION["IdLocal"][12],$_SESSION["IdLocal"][13],$_SESSION["IdLocal"][14]);
      $Start = array($_SESSION["StartLocal"][0],$_SESSION["StartLocal"][1],$_SESSION["StartLocal"][2],$_SESSION["StartLocal"][3],$_SESSION["StartLocal"][4],$_SESSION["StartLocal"][5],$_SESSION["StartLocal"][6],$_SESSION["StartLocal"][7],$_SESSION["StartLocal"][8],$_SESSION["StartLocal"][9],$_SESSION["StartLocal"][10],$_SESSION["StartLocal"][11],$_SESSION["StartLocal"][12],$_SESSION["StartLocal"][13],$_SESSION["StartLocal"][14]);
      $flag = array(false,false,false,false,false,false,false,false,false,false,false,false,false,false,false);
      echo json_encode(array($ID,$Start,$flag,"Session"));
    }else{
      $ID=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
      $Start=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
      $flag = array(false,false,false,false,false,false,false,false,false,false,false,false,false,false,false);
      $check = false;

      for($count = 0 ; $count < 15 ;$count++ ){
         $query = 'SELECT DISTINCT position_name FROM tbposition WHERE campus = "'.$campus.'" ';
         $resultPosition = mysqli_query($connect, $query);
         
         if($check == false){
            while($rowPosition = mysqli_fetch_array($resultPosition)){
               $resultCandidate = Make_Query_For_Local_Council($connect,$campus,$college,$program,$year,$rowPosition["position_name"]);
               
               if(mysqli_num_rows($resultCandidate) > 0){
                  $position = $rowPosition["position_name"];

                  if($position == "Business Manager" && $campus == "Tagum"){
                     $number = 10;
                     $flag[$number] = true;
                     $flag[$count] = false;
                     $count++;
                        if($position === "Business Manager" && $campus === "Tagum" && mysqli_num_rows($resultCandidate) > 1){
                           $number = 11;
                           $flag[$number] = true;
                           $flag[$count] = false;
                           $count++;
                        }
                  }elseif($position == "Senator" && $campus == "Tagum"){
                     $number = 12;
                     $flag[$number] = true;
                     $flag[$count] = false;
                     $count++;
                        if($position === "Senator" && $campus === "Tagum" && mysqli_num_rows($resultCandidate) >= 2){
                           $number = 13;
                           $flag[$number] = true;
                           $flag[$count] = false;
                           $count++;
                        }

                        if($position === "Senator" && $campus === "Tagum" && mysqli_num_rows($resultCandidate) >= 3){
                           $number = 14;
                           $flag[$number] = true;
                           $flag[$count] = false;
                           $count++;
                        }
                  }else{
                     $flag[$count] = true;
                     $count++;
                  }
               }else{
                  $flag[$count] = false;
                  $count++;
               }
            }
            $check = true;
         }else{
            if(($count == 10 || $count == 11) && $campus == "Tagum"){
               $count++;
            }elseif(($count == 12 || $count == 13 || $count == 14) && $campus == "Tagum"){
               $count++;
            }else{
               $flag[$count] = false;
               $count++;
            }
            
         }
      }
      
      echo json_encode(array($ID,$Start,$flag,"NoSession"));
   }
?>