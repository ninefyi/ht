<?php require_once 'config.php';

    $op = $_REQUEST['op'];
    if($op == "save"){
        profile_create();
    }else if($op == "update"){
        profile_update();
    }else if($op == "delete"){
        profile_delete($_REQUEST['id']);
    }else if($op == "save_assign"){
        profile_assign_medicine();
    }else if($op == "update_assign"){
        profile_update_assign_medicine();
    }else if($op == "save_history"){
        profile_assign_history_medicine();
    }

    function profile_create(){
        global $conn;
        try{
            $sql = "insert into ht_patient(patient_name, patient_user, patient_pwd, patient_bod, patient_weight, patient_height, patient_allergy, patient_breakfast, patient_lunch, patient_dinner, patient_phone, cdate) 
                    values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW()); ";
            $patient_breakfast = $_REQUEST['patient_breakfast_hh'].$_REQUEST['patient_breakfast_mm'];
            $patient_lunch = $_REQUEST['patient_lunch_hh'].$_REQUEST['patient_lunch_mm'];
            $patient_dinner = $_REQUEST['patient_dinner_hh'].$_REQUEST['patient_dinner_mm'];
            list($d, $m, $y) = explode("-", $_REQUEST['patient_bod']);
            $patient_bod = "$y/$m/$d";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $_REQUEST['patient_name'], PDO::PARAM_STR);
            $stmt->bindParam(2, $_REQUEST['patient_user'], PDO::PARAM_STR, 100);
            $stmt->bindParam(3, $_REQUEST['patient_pwd'], PDO::PARAM_STR, 100);
            $stmt->bindParam(4, $patient_bod, PDO::PARAM_STR);
            $stmt->bindParam(5, $_REQUEST['patient_weight'], PDO::PARAM_INT);
            $stmt->bindParam(6, $_REQUEST['patient_height'], PDO::PARAM_INT);
            $stmt->bindParam(7, $_REQUEST['patient_allergy'], PDO::PARAM_STR);
            $stmt->bindParam(8, $patient_breakfast, PDO::PARAM_STR, 100);
            $stmt->bindParam(9, $patient_lunch, PDO::PARAM_STR, 100);
            $stmt->bindParam(10, $patient_dinner, PDO::PARAM_STR, 100);
            $stmt->bindParam(11, $_REQUEST['patient_phone'], PDO::PARAM_STR, 100);
            $stmt->execute();
        }catch (PDOException $ex){
            var_dump($ex->getMessage());
        }
        echo "บันทึกข้อมูลสำเร็จ";
    }
    function profile_load($id){
        global $conn;
        try {
            if(!empty($id)){
                if(is_numeric($id)){
                    $sql = "SELECT *, DATE_FORMAT(patient_bod,'%d-%m-%Y') AS bod FROM ht_patient WHERE (patient_id='$id') ";
                }else{
                    $sql = "SELECT *, DATE_FORMAT(patient_bod,'%d-%m-%Y') AS bod FROM ht_patient WHERE (patient_name LIKE '%$id%') ";
                }

            }else{
                $sql = "SELECT *, DATE_FORMAT(patient_bod,'%d-%m-%Y') AS bod FROM ht_patient";
            }
            //var_dump($sql);
            return $conn->query($sql);
        }catch(PDOException $ex){
            var_dump($ex->getMessage());
        }
        return null;
    }
    function profile_update(){
        global $conn;
        try{
            $sql = "UPDATE ht_patient
                    SET patient_name = ?
                      , patient_user = ?
                      , patient_pwd = ?
                      , patient_bod = ?
                      , patient_weight = ?
                      , patient_height = ?
                      , patient_allergy = ?
                      , patient_breakfast = ?
                      , patient_lunch = ?
                      , patient_dinner = ?
                      , patient_phone = ? 
                    WHERE patient_id=?";
            $patient_breakfast = $_REQUEST['patient_breakfast_hh'].$_REQUEST['patient_breakfast_mm'];
            $patient_lunch = $_REQUEST['patient_lunch_hh'].$_REQUEST['patient_lunch_mm'];
            $patient_dinner = $_REQUEST['patient_dinner_hh'].$_REQUEST['patient_dinner_mm'];
            list($d, $m, $y) = explode("-", $_REQUEST['patient_bod']);
            $patient_bod = "$y/$m/$d";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $_REQUEST['patient_name'], PDO::PARAM_STR);
            $stmt->bindParam(2, $_REQUEST['patient_user'], PDO::PARAM_STR, 100);
            $stmt->bindParam(3, $_REQUEST['patient_pwd'], PDO::PARAM_STR, 100);
            $stmt->bindParam(4, $patient_bod, PDO::PARAM_STR);
            $stmt->bindParam(5, $_REQUEST['patient_weight'], PDO::PARAM_INT);
            $stmt->bindParam(6, $_REQUEST['patient_height'], PDO::PARAM_INT);
            $stmt->bindParam(7, $_REQUEST['patient_allergy'], PDO::PARAM_STR);
            $stmt->bindParam(8, $patient_breakfast, PDO::PARAM_STR, 100);
            $stmt->bindParam(9, $patient_lunch, PDO::PARAM_STR, 100);
            $stmt->bindParam(10, $patient_dinner, PDO::PARAM_STR, 100);
            $stmt->bindParam(11, $_REQUEST['patient_phone'], PDO::PARAM_STR, 100);
            $stmt->bindParam(12, $_REQUEST['patient_id'], PDO::PARAM_INT);
            $stmt->execute();
        }catch (PDOException $ex){
            var_dump($ex->getMessage());
        }
        echo "บันทึกข้อมูลสำเร็จ";
    }
    function profile_delete($id){
        global $conn;
        try {
            $sql = "DELETE FROM ht_patient WHERE patient_id='$id' ";
            $conn->exec($sql);
            echo '<script>window.location="profile_page.php";</script>';
        }catch(PDOException $ex) {
            var_dump($ex->getMessage());
        }
    }
    function profile_assign_medicine(){
        global $conn;
        try{
            $sql = "INSERT INTO ht_patient_med(patient_id, med_id, dosage, total, start_date, end_date, snooze, breakfast, lunch, dinner, description, cdate) 
                    VALUES (?, ?, ?, 0, ?, ?, ?, ?, ?, ?, '', NOW()); ";
            $row_index = $_REQUEST['row_index'];
            if(empty($row_index)){
                echo 'ไม่สามารถบันทึกข้อมูลได้ เพราะ row_index!';
                exit;
            }

            $patient_id = $_REQUEST['patient_id'.$row_index];
            $med_id = $_REQUEST['med_id'.$row_index];
            $start_date = $_REQUEST['start_date'.$row_index];
            $end_date = $_REQUEST['end_date'.$row_index];
            $snooze = $_REQUEST['snooze'.$row_index];
            $breakfast = $_REQUEST['breakfast'.$row_index];
            $lunch = $_REQUEST['lunch'.$row_index];
            $dinner = $_REQUEST['dinner'.$row_index];
            $dosage = $_REQUEST['dosage'.$row_index];

            //var_dump($patient_id, $med_id, $start_date, $end_date, $snooze, $breakfast, $lunch, $dinner, $dosage);

            if(empty($patient_id) or empty($med_id) or empty($start_date) or empty($end_date)
                or !isset($breakfast) or !isset($lunch) or !isset($dinner)){
                echo 'ไม่สามารถบันทึกข้อมูลได้ กรอกข้อมูลให้ครบถ้วน!!!!';
                exit;
            }
            list($d, $m, $y) = explode("-", $start_date);
            $start_date = "$y/$m/$d";
            list($d, $m, $y) = explode("-", $end_date);
            $end_date = "$y/$m/$d";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $patient_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $med_id, PDO::PARAM_INT);
            $stmt->bindParam(3, $dosage, PDO::PARAM_INT);
            $stmt->bindParam(4, $start_date, PDO::PARAM_STR);
            $stmt->bindParam(5, $end_date, PDO::PARAM_STR);
            $stmt->bindParam(6, $snooze, PDO::PARAM_INT);
            $stmt->bindParam(7, $breakfast, PDO::PARAM_INT);
            $stmt->bindParam(8, $lunch, PDO::PARAM_INT);
            $stmt->bindParam(9, $dinner, PDO::PARAM_INT);
            $stmt->execute();
        }catch (PDOException $ex){
            var_dump($ex->getMessage());
        }
        echo "บันทึกข้อมูลสำเร็จ";
    }

    function profile_update_assign_medicine(){
        global $conn;
        try{
            $sql = "UPDATE ht_patient_med SET
                    patient_id = ?
                    , med_id = ?
                    , dosage = ?
                    , start_date = ?
                    , end_date = ?
                    , snooze = ?
                    , breakfast = ?
                    , lunch = ?
                    , dinner = ?
                    , udate = NOW() 
                    WHERE p_med_id = ?";
            $row_index = $_REQUEST['row_index'];
            if(empty($row_index)){
                echo 'ไม่สามารถบันทึกข้อมูลได้ เพราะ row_index!';
                exit;
            }

            $patient_id = $_REQUEST['patient_id'.$row_index];
            $med_id = $_REQUEST['med_id'.$row_index];
            $start_date = $_REQUEST['start_date'.$row_index];
            $end_date = $_REQUEST['end_date'.$row_index];
            $snooze = $_REQUEST['snooze'.$row_index];
            $breakfast = $_REQUEST['breakfast'.$row_index];
            $lunch = $_REQUEST['lunch'.$row_index];
            $dinner = $_REQUEST['dinner'.$row_index];
            $dosage = $_REQUEST['dosage'.$row_index];
            $p_med_id = $_REQUEST['p_med_id'.$row_index];

            //echo '<pre>';
            //var_dump($p_meid_id, $patient_id, $med_id, $start_date, $end_date, $snooze, $breakfast, $lunch, $dinner, $dosage);

            if(empty($patient_id) or empty($med_id) or empty($start_date) or empty($end_date)
                or !isset($breakfast) or !isset($lunch) or !isset($dinner) or empty($p_med_id)){
                echo 'ไม่สามารถบันทึกข้อมูลได้ กรอกข้อมูลให้ครบถ้วน!!!!';
                exit;
            }
            list($d, $m, $y) = explode("-", $start_date);
            $start_date = "$y/$m/$d";
            list($d, $m, $y) = explode("-", $end_date);
            $end_date = "$y/$m/$d";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $patient_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $med_id, PDO::PARAM_INT);
            $stmt->bindParam(3, $dosage, PDO::PARAM_INT);
            $stmt->bindParam(4, $start_date, PDO::PARAM_STR);
            $stmt->bindParam(5, $end_date, PDO::PARAM_STR);
            $stmt->bindParam(6, $snooze, PDO::PARAM_INT);
            $stmt->bindParam(7, $breakfast, PDO::PARAM_INT);
            $stmt->bindParam(8, $lunch, PDO::PARAM_INT);
            $stmt->bindParam(9, $dinner, PDO::PARAM_INT);
            $stmt->bindParam(10, $p_med_id, PDO::PARAM_INT);
            //var_dump($sql);
            $stmt->execute();
        }catch (PDOException $ex){
            var_dump($ex->getMessage());
        }
        echo "บันทึกข้อมูลสำเร็จ";
    }

    function profile_assign_history_medicine(){
        global $conn;
        try{
            $sql = "UPDATE ht_patient_med SET  
                        history = 1
                        , udate = NOW() 
                    WHERE p_med_id = ?";
            $row_index = $_REQUEST['row_index'];
            if(empty($row_index)){
                echo 'ไม่สามารถบันทึกข้อมูลได้ เพราะ row_index!';
                exit;
            }
            $p_med_id = $_REQUEST['p_med_id'.$row_index];
            //echo '<pre>';
            //var_dump($p_meid_id);
            if(empty($p_med_id)){
                echo 'ไม่สามารถบันทึกข้อมูลได้!!!!';
                exit;
            }
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $p_med_id, PDO::PARAM_INT);
            //var_dump($sql);
            $stmt->execute();
        }catch (PDOException $ex){
            var_dump($ex->getMessage());
        }
        echo "บันทึกข้อมูลสำเร็จ";
    }
    function profile_not_take_medicine($id){
        global $conn;
        try {
            if(!empty($id)){
                if(is_numeric($id)){
                    $sql = "SELECT *, DATE_FORMAT(patient_bod,'%d-%m-%Y') AS bod 
                            FROM ht_patient WHERE (patient_id='$id') ";
                }else{
                    $sql = "SELECT *, DATE_FORMAT(patient_bod,'%d-%m-%Y') AS bod 
                            FROM ht_patient WHERE (patient_name LIKE '%$id%') ";
                }

            }else{
                $sql = "SELECT *, DATE_FORMAT(patient_bod,'%d-%m-%Y') AS bod 
                        FROM ht_patient";
            }
            //var_dump($sql);
            return $conn->query($sql);
        }catch(PDOException $ex){
            var_dump($ex->getMessage());
        }
        return null;
    }
?>





