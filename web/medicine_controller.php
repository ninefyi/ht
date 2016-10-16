<?php require_once 'config.php';
    header('Content-Type: text/html; charset=utf-8');

    $op = $_REQUEST['op'];
    if($op == "save"){
        medicine_create();
    }else if($op == "update"){
        medicine_update();
    }else if($op == "delete"){
        medicine_delete($_REQUEST['id']);
    }

    function medicine_create(){
        global $conn;
        try{
            $sql = "insert into ht_medicine(med_name, med_brand, med_charactor, med_dos, med_number, med_desc, med_image, med_affect) 
                    values(?, ?, ?, ?, ?, ?, ?, ?); ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $_REQUEST['med_name'], PDO::PARAM_STR, 100);
            $stmt->bindParam(2, $_REQUEST['med_brand'], PDO::PARAM_STR);
            $stmt->bindParam(3, $_REQUEST['med_charactor'], PDO::PARAM_STR, 100);
            $stmt->bindParam(4, $_REQUEST['med_dos'], PDO::PARAM_STR, 100);
            $stmt->bindParam(5, $_REQUEST['med_number'], PDO::PARAM_STR, 100);
            $stmt->bindParam(6, $_REQUEST['med_desc'], PDO::PARAM_STR);
            $stmt->bindParam(7, $_REQUEST['med_image'], PDO::PARAM_STR, 100);
            $stmt->bindParam(8, $_REQUEST['med_affect'], PDO::PARAM_STR);
            $stmt->execute();
            $med_id = $conn->lastInsertId();
            if(!empty($_FILES['med_image']) and !empty($med_id) and !empty($_FILES['med_image']['name'])){
                upload_image($_FILES['med_image'], $med_id);
            }
        }catch (PDOException $ex) {
            var_dump($ex->getMessage());
        }
        echo "<script>alert('บันทึกข้อมูลสำเร็จ');self.close();</script>";
    }
    function medicine_load($id){
        global $conn;
        try {
            if(!empty($id)){
                if(is_numeric($id)){
                    $sql = "SELECT * FROM ht_medicine WHERE med_id = '$id' ";
                }else{
                    $sql = "SELECT * FROM ht_medicine WHERE med_name LIKE '%$id%' ";
                }

            }else{
                $sql = "SELECT * FROM ht_medicine ORDER BY med_brand ";
            }
            return $conn->query($sql);
        }catch(PDOException $ex){
            var_dump($ex->getMessage());
        }
        return null;
    }
    function medicine_update(){
        global $conn;
        try{
            $sql = "UPDATE ht_medicine
                    SET med_name = ?
                      , med_brand = ?
                      , med_charactor = ?
                      , med_dos = ?
                      , med_number = ?
                      , med_desc = ?
                      , med_affect = ?
                    WHERE med_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $_REQUEST['med_name'], PDO::PARAM_STR, 100);
            $stmt->bindParam(2, $_REQUEST['med_brand'], PDO::PARAM_STR, 100);
            $stmt->bindParam(3, $_REQUEST['med_charactor'], PDO::PARAM_STR, 100);
            $stmt->bindParam(4, $_REQUEST['med_dos'], PDO::PARAM_STR, 100);
            $stmt->bindParam(5, $_REQUEST['med_number'], PDO::PARAM_STR, 100);
            $stmt->bindParam(6, $_REQUEST['med_desc'], PDO::PARAM_STR);
            $stmt->bindParam(7, $_REQUEST['med_affect'], PDO::PARAM_STR);
            $stmt->bindParam(8, $_REQUEST['med_id'], PDO::PARAM_INT);
            $stmt->execute();
            $med_id = $_REQUEST['med_id'];
            if(!empty($_FILES['med_image']) and !empty($med_id) and !empty($_FILES['med_image']['name'])){
                upload_image($_FILES['med_image'], $med_id);
            }
        }catch (PDOException $ex){
            var_dump($ex->getMessage());
        }
        echo "<script>alert('บันทึกข้อมูลสำเร็จ');self.close();</script>";
    }
    function medicine_delete($id){
        global $conn;
        try {
            $img = $_REQUEST['img'];
            if(!empty($img)){
                @unlink('upload/'.$img);
            }
            $sql = "DELETE FROM ht_medicine WHERE med_id='$id' ";
            $conn->exec($sql);
            echo '<script>window.location="medicine_show.php";</script>';
        }catch(PDOException $ex) {
            var_dump($ex->getMessage());
        }
    }
    function upload_image($img, $id){
        try{
            global $conn;
            $target_file = "upload/" . basename($img["name"]);
            $image_type = pathinfo($target_file, PATHINFO_EXTENSION);
            $image_name = $id.".".$image_type;
            $target_file = "upload/".$id.".".$image_type;
            if (move_uploaded_file($img["tmp_name"], $target_file)) {
                $sql = "UPDATE ht_medicine 
                        SET med_image=? 
                        WHERE med_id = ? ";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $image_name, PDO::PARAM_STR, 100);
                $stmt->bindParam(2, $id, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }catch (Exception $ex){
            var_dump($ex->getMessage());
        }
    }

    function medicine_load_assign_by_patient($patient_id){
        global $conn;
        try {
            if(!empty($patient_id)){
                $sql = "SELECT p.*
                          , DATE_FORMAT(start_date,'%d-%m-%Y') AS sdate 
                          , DATE_FORMAT(end_date,'%d-%m-%Y') AS edate
                          , m.med_affect
                        FROM ht_patient_med AS p
                          INNER JOIN ht_medicine AS m ON m.med_id = p.med_id
                        WHERE p.history = 0 AND p.patient_id = ? 
                        ORDER BY p_med_id LIMIT 2";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $patient_id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll();
            }
        }catch(PDOException $ex){
            var_dump($ex->getMessage());
        }
        return null;
    }
?>





