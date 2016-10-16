<?php ob_start();
    require_once "config.php";

    $op = $_REQUEST['op'];

    if($op == "load_data"){
        load_data();
    }

    function load_data(){
        global $conn;
        $response = array();
        $response['success'] = 0;
        $response['error'] = "";
        try{
            $room_no = $_REQUEST['room_no'];
            $room_password = $_REQUEST['room_password'];
            $sql = "SELECT *
                    FROM room_account
                    WHERE room_no = '$room_no' 
                      AND room_password = '$room_password' ";
            if($stmt = $conn->query($sql)){
                $response["data_list"] = array();
                if($rs = $stmt->fetchAll()) {
                    foreach($rs as $row){
                        $data_list = array();
                        $data_list['room_no'] = $row['room_no'];
                        $data_list['room_no'] = $row['room_password'];
                        $data_list['login_date'] = $row['login_date'];
                        array_push($response['data_list'], $data_list);
                    }
                    $response['success'] = 1;
                }
            }else{
                $response['error'] = "No found record!";
            }
        }catch(PDOException $pdo_ex){
            $response['error'] = $pdo_ex->getMessage();
        }catch(Exception $ex){
            $response['error'] = $ex->getMessage();

        }
        echo json_encode($response);
    }

ob_end_flush();?>