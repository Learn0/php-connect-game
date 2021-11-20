<?php
require_once "../dao/mainDAO.php";
/*
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            exit(0);
}
*/
if(isset($_COOKIE["memberIdx"])){
    $dao = new mainDAO();
    $dao->setData();
    
    $memberIdx = (int)urldecode($_COOKIE["memberIdx"]);

    $result = $dao->dashAdventureCheck($memberIdx);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $arr = array("dia" => $row['dia'], "ball" => $row['ball'], "shop_ball"=> $row['shop_ball']
                , "normal_stage"=> $row['normal_stage'], "normal_stage_count"=> $row['normal_stage_count']
                , "hard_stage_open"=> $row['hard_stage_open'], "hard_stage"=> $row['hard_stage'], "hard_stage_count"=> $row['hard_stage_count']
            );
        }
        echo json_encode($arr);
    }
}else{
    echo "error";
}
?>