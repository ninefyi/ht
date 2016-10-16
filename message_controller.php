<?php require_once 'config.php';
    header('Content-Type: text/html; charset=utf-8');

    function message_load($id){
        global $conn;
        try {
            if(!empty($id)){
                $sql = "SELECT m.*, p.patient_name
                        FROM ht_message AS m
                        RIGHT JOIN ht_patient AS p ON p.patient_id = m.patient_id
                        WHERE p.patient_id = '$id'
                        ORDER BY message_time DESC 
                        LIMIT 0,100 ";
                return $conn->query($sql);
            }
        }catch(PDOException $ex){
            var_dump($ex->getMessage());
        }
        return null;
    }

    function load_all_patient(){
        global $conn;
        $array_user = array();
        try{
            $sql = "SELECT ht_patient.*, (SELECT COUNT(*) FROM ht_message WHERE is_read=0 AND patient_id = ht_patient.patient_id) as cnt 
                    FROM ht_patient
                    ORDER BY ht_patient.patient_name";
            if($rs = $conn->query($sql)){
                foreach($rs as $row) {
                    $name = $row['patient_name'];
                    $id = $row['patient_id'];
                    $cnt = $row['cnt'];
                    $array_user[$id] = array("id" => $id, "name"=> $name, "newmsg"=>$cnt);
                }
            }
        }catch (PDOException $ex){
            var_dump($ex->getMessage());
        }
        return $array_user;
    }

?>





