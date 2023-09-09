<?php 
session_start();
require_once '../config/db_config.php';
date_default_timezone_set('Asia/Manila');

$dbname = DB_NAME;
$pdo = new PDO("mysql:host=localhost;dbname=$dbname", DB_USER, DB_PASS);
$conn = new PDO("mysql:host=localhost;dbname=$dbname", DB_USER, DB_PASS);
$username = strtolower(filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$password = strtolower(filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$campus = filter_var($_POST['campus'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);



//for watcher string to find
$tempStr = "watcher";


$stmt= $pdo->prepare('SELECT * FROM tbadmin WHERE username = :username LIMIT 1');
$stmt->execute([ 'username' => $username ]);

$resultCheck = $stmt ->rowCount() ;

// logs
$dt = date('Y-m-d G:i:s');
$action = "Logged in";
$userCampus = $_POST['username'];
$query = $pdo->prepare('CALL insert_admin_log(:username, :action, :dt)');
$query->execute(['username' => $userCampus, 'action' => $action, 'dt' => $dt]);


$login_response = array();

if(empty($username) || empty($password)){
    $login_response[] = array("login_result" => "empty_fields");
}else if($campus == 'Central-Chairperson'){

    if($resultCheck > 0){
        foreach($stmt as $row){
            if(md5($password )== $row['password'] && $row['role'] == 'Central-Chairperson'){


                $login_response[] = array("login_result" => "central_admin_success");
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['loggedName'] = $row['firstName']." ".$row['lastName'];



    
            }else{
                $login_response[] = array("login_result" => "wrong_password");
    
            }
        }
    }else{
        $login_response[] = array("login_result" => "unknownAccount");
    
    }


}else if($campus == 'Technical-Officer' ){
    if($resultCheck > 0){
        foreach($stmt as $row){
            if(md5($password )== $row['password'] && $row['role'] == 'Technical-Officer'){

                $login_response[] = array("login_result" => "tech_success");
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['loggedName'] = $row['firstName']." ".$row['lastName'];



    
            }else{
                $login_response[] = array("login_result" => "wrong_password");
    
            }
        }
    }else{
        $login_response[] = array("login_result" => "unknownAccount");
    
    }
}else if($campus == 'Monitoring'){

    if($resultCheck > 0){
        foreach($stmt as $row){
            if(md5($password )== $row['password'] && $row['role'] == 'Monitoring'){
                
                $login_response[] = array("login_result" => "monitor_success");
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['loggedName'] = $row['firstName']." ".$row['lastName'];


    
            }else{
                $login_response[] = array("login_result" => "wrong_password");
    
            }
        }
    }else{
        $login_response[] = array("login_result" => "unknownAccount");
    
    }

}else if($campus == 'Mabini-Watcher'){

            if($resultCheck > 0){
                foreach($stmt as $row){
                    if(md5($password )== $row['password'] && $row['role'] == 'Mabini-Watcher'){
            
                        $login_response[] = array("login_result" => "watcher_success");
                        $_SESSION['username'] = $_POST['username'];
                        $_SESSION['loggedName'] = $row['firstName']." ".$row['lastName'];
                        $_SESSION['campus'] = "Mabini";


        
            
                    }else{
                        $login_response[] = array("login_result" => "wrong_password");
            
                    }
                }
            }else{
                $login_response[] = array("login_result" => "unknownAccount");
            
            }

        }else if($campus == 'Tagum-Watcher'){

                if($resultCheck > 0){
                    foreach($stmt as $row){
                        if(md5($password )== $row['password'] && $row['role'] == 'Tagum-Watcher'){
                
                            $login_response[] = array("login_result" => "watcher_success");
                            $_SESSION['username'] = $_POST['username'];
                            $_SESSION['loggedName'] = $row['firstName']." ".$row['lastName'];
                            $_SESSION['campus'] = "Tagum";


            
                
                        }else{
                            $login_response[] = array("login_result" => "wrong_password");
                
                        }
                    }
                }else{
                    $login_response[] = array("login_result" => "unknownAccount");
                
                }
            

}else if($campus == "campus"){
    $login_response[] = array("login_result" => "campus_error");
   
}else{
    if($resultCheck > 0){
        foreach($stmt as $row){
            if(md5($password )== $row['password'] && $campus == $row['role']){
    
                $login_response[] = array("login_result" => "success");
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['loggedName'] = $row['firstName']." ".$row['lastName'];
                $_SESSION['campus'] = $_POST['campus'];



    
            }else{
                $login_response[] = array("login_result" => "wrong_password");
    
            }
        }
    }else{
        $login_response[] = array("login_result" => "unknownAccount");
    
    }
}

echo json_encode($login_response);



?>