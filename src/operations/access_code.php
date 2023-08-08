<?php
    session_start();
    require_once '../config/db_config.php';
    $code = $_POST['code'];
    $type = $_POST['type'];
    

    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    $result_arr = array();

$query = "SELECT * FROM tb_access_code WHERE type = ? LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $type);
$stmt->execute();
$result = $stmt->get_result();
$resultCheck = $result->num_rows;

if ($resultCheck > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['access_code'] == $code) {
            $result_arr[] = array('result' => 'success');
            $_SESSION['admin_success'] = "success_admin";
            setcookie("admin_panel_access", "success_admin", time() + (86400 * 30), "/");
        } else {
            $result_arr[] = array('result' => 'error');
        }
    }
}


echo json_encode($result_arr);





?>