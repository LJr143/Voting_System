<?php
   session_start();
   include '../../config/db_config.php';
   include '../Decryption.php';

   $connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

   $voter = mysqli_real_escape_string($connect,decryption($_POST['voter']));
   $campus = mysqli_real_escape_string($connect, decryption($_POST['campus']));
   $year;

   $query = 'select * from vw_voter where stud_id="'.$voter.'" AND campus="'.$campus.'"';
   $result = mysqli_query($connect,$query);
   $resultChecke = mysqli_num_rows($result);
   if($resultChecke > 0){
      while($row = mysqli_fetch_assoc($result)){
         $year = $row['year'];
      }
    } 
    
   //Function For Checking Special Position
   function Make_Query_For_Student_Council($connect, $campus, $year, $position) {
      if ($campus == "Mabini" && $position == "Representative") {
         $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND year ="'.$year.'"  AND indicator = "student council" ORDER BY id ASC ';
         $result = mysqli_query($connect, $query);
      } else {
         $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND indicator = "student council"  ORDER BY id ASC ';
         $result = mysqli_query($connect, $query);
      }
      return $result;
   }
   //Check If The Student Proceed to the Local Council
   //Only 10 Position in The Student Council Available
   if (isset($_SESSION["Proceed"])) {
      $ID = array($_SESSION["Id"][0], $_SESSION["Id"][1], $_SESSION["Id"][2], $_SESSION["Id"][3], $_SESSION["Id"][4], $_SESSION["Id"][5], $_SESSION["Id"][6], $_SESSION["Id"][7], $_SESSION["Id"][8], $_SESSION["Id"][9]);
      $Start = array($_SESSION["Start"][0], $_SESSION["Start"][1], $_SESSION["Start"][2], $_SESSION["Start"][3], $_SESSION["Start"][4], $_SESSION["Start"][5], $_SESSION["Start"][6], $_SESSION["Start"][7], $_SESSION["Start"][8], $_SESSION["Start"][9]);
      $flag = array(false, false, false, false, false, false, false, false, false, false);
      echo json_encode(array($ID, $Start, $flag, "Session"));
   } else {
      $ID = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
      $Start = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
      $flag = array(false, false, false, false, false, false, false, false, false, false);
      $check = false;
      for ($count = 0; $count < 10; $count++) {

         $query = 'SELECT DISTINCT position_name FROM tbcouncil WHERE campus = "'.$campus.'" ';
         $resultPosition = mysqli_query($connect, $query);

         if ($check == false) {
            while ($rowPosition = mysqli_fetch_array($resultPosition)) {

               $resultCandidate = Make_Query_For_Student_Council($connect, $campus, $year, $rowPosition["position_name"]);

               if (mysqli_num_rows($resultCandidate) > 0) {
                  $flag[$count] = true;
                  $count++;
               } else {
                  $flag[$count] = false;
                  $count++;
               }
            }
            $check = true;
         } else {
            $flag[$count] = false;
         }
      }

      echo json_encode(array($ID, $Start, $flag, "NoSession"));
   } 
?>