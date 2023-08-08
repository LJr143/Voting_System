<?php
session_start();
include '../config/db_config.php';
include 'Encryption.php';
include 'Decryption.php';
require_once('../vendor/autoload.php');

$dbname = DB_NAME;
$pdo = new PDO("mysql:host=localhost;dbname=$dbname", DB_USER, DB_PASS);
$conn = new PDO("mysql:host=localhost;dbname=$dbname", DB_USER, DB_PASS);

$otpsend = rand(1000, 9999); //generate an OTP

ini_set("SMTP","smtp.hostinger.ph");
ini_set("smtp_port","587");

use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;

$mail = new Message;

$messageBody = "
                    <html>
                        <head>
                            <title>HTML email</title>
                        </head>
                        <body>
                            <div style= 'border: 2px solid #BFBFBF; box-shadow: 10px 10px 5px #aaaaaa;padding: 10px 10px 20px 10px;text-align:center;width:50%;margin:0 auto;display:block;border-radius:1rem'>
                                <h1>Your One-Time-Password 
                                <strong style='color:red'>".$otpsend."</strong></h1> <br> <h4>Thank you for loving USeP E-Voting<h4> 
                            </div>
                        </body>
                    </html>
                        ";

$resend = filter_var($_POST['resend'], FILTER_SANITIZE_STRING);

if($resend == "resend"){
    $username = filter_var(decryption($_COOKIE['username']), FILTER_SANITIZE_STRING);
    $password = filter_var(decryption($_COOKIE['password']), FILTER_SANITIZE_STRING);
    $campus = filter_var(decryption($_COOKIE['campus']), FILTER_SANITIZE_STRING);
    $mode = filter_var(decryption($_COOKIE['mode']), FILTER_SANITIZE_STRING);
}else{
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $campus = filter_var($_POST['campus'], FILTER_SANITIZE_STRING);
    $mode = filter_var($_POST['mode'], FILTER_SANITIZE_STRING);
}

//$ip_address = strip_tags(file_get_contents('http://checkip.dyndns.com/'));
//$final = str_replace("Current IP CheckCurrent IP Address: ","",$ip_address);
$final = $_SERVER['REMOTE_ADDR'];
$proxy = 'false';

if ($mode === 'Student Council and Local Council') {
    // Check for Proxy Voting in Campus Election
    $stmtProxy = $pdo->prepare('CALL CheckProxyVoting(:ip, @isProxy)');
    $stmtProxy->bindParam(':ip', $final, PDO::PARAM_STR);
    $stmtProxy->execute();

    $stmtProxy->closeCursor();

    // Retrieve the result from the stored procedure
    $stmtResult = $pdo->query('SELECT @isProxy AS isProxy');
    $result = $stmtResult->fetch(PDO::FETCH_ASSOC);

    if ($result['isProxy'] == 'true') {
        $proxy = 'true';
    }

    $stmt= $pdo->prepare('SELECT * from tbelectiondate');
    $stmt->execute();
    if($stmt ->rowCount() > 0){
        while($row = $stmt->fetch()){
            $electionEnd = $row['end_date']." ".$row['end_time'];
        }
    }

    $electionEnd = strtotime($electionEnd);
    $currDT= strtotime(date(" j F Y h:i"));

//Check for the Election Date

    if($currDT > $electionEnd){
        echo json_encode(array('Election Due','Student Council and Local Council'));
    }else{
        //Check For If they are voters In Campus Election
        $stmtVoter= $pdo->prepare('SELECT * FROM tb_voter WHERE campus= :campus AND stud_id= :username AND password= :password');
        $stmtVoter->execute([ 'campus' => $campus , 'username' => $username , 'password' => $password]);
        if($stmtVoter ->rowCount() > 0){
            while($row = $stmtVoter->fetch()){
                //Check For If they have voted In Campus Election
                $stmtVoted= $pdo->prepare('SELECT * FROM tb_votes WHERE campus= :campus AND studID= :username ');
                $stmtVoted->execute([ 'campus' => $campus , 'username' => $username ]);
                if($stmtVoted ->rowCount() > 0){
                    echo json_encode(array('Voted'));
                }else{
                    if($proxy == 'true'){
                        echo json_encode(array('Proxy'));
                    }else{
                        //Check For If they have already login with another device In Campus Election
                        $stmtLogs= $pdo->prepare('SELECT * FROM tbloginlogs WHERE stud_id= :username AND campus= :campus');
                        $stmtLogs->execute([ 'username' => $username , 'campus' => $campus ]);
                        if($stmtLogs ->rowCount() > 0){
                            echo json_encode(array('Login'));
                        }else{
                            $email = $row['email'];

                            if(!$email){
                                echo json_encode(array('No Email'));
                            }else{
                                $subject ="USeP E-Voting OTP Code";
                                $message = "Your Code: '".$otpsend."'";


                                $mail->setFrom('comelecusep@gmail.com','USeP E-Voting')
                                    ->addTo($email)
                                    ->setSubject($subject)
                                    ->setHTMLBody($messageBody);

                                $mailer = new Nette\Mail\SmtpMailer([
                                    'host' => 'smtp.gmail.com',
                                    'username' => 'lorjohn143@gmail.com',
                                    'password' => 'ldwxkzolwbqinjyf',
                                    'secure' => 'ssl',
                                ]);
                                $mailer->send($mail);

                                setcookie("top", encrypt($otpsend), time() + (60 * 15)); //set otp cookie attached with 15 minutes
                                setcookie("username", encrypt($username), time() + (60 * 15)); //set username cookie attached with 15 minutes
                                setcookie("password", encrypt($password), time() + (60 * 15)); //set password cookie attached with 15 minutes
                                setcookie("campus", encrypt($campus), time() + (60 * 15)); //set campus cookie attached with 15 minutes
                                setcookie("mode", encrypt($mode), time() + (60 * 15)); //set mode cookie attached with 15 minutes
                                $_SESSION["Uemail"] = $email;
                                $_SESSION["OTP"] = "OTP";

                                echo json_encode(array('success',$email));

                            }
                        }
                    }
                }
            }

        }
    }
}else{
    echo json_encode(array('failed'));
}
?>