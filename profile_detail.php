<?php
    require_once 'config.php';

    require_once 'profile_controller.php';

    $op = $_REQUEST['op'];
    if($op == "create"){
        $patient_user = genUser();
        $op = "save";
    }else if($op == "edit"){
        $patient = profile_load($_REQUEST['id']);
        if($patient){
            foreach($patient as $row){
                //var_dump($row);
                $patient_id = $row['patient_id'];
                $patient_name = $row['patient_name'];
                $patient_user = $row['patient_user'];
                $patient_pwd = $row['patient_pwd'];
                $patient_bod = $row['bod'];
                $patient_weight = $row['patient_weight'];
                $patient_height = $row['patient_height'];
                $patient_phone = $row['patient_phone'];
                $patient_allergy = $row['patient_allergy'];
                $patient_breakfast = $row['patient_breakfast'];
                $patient_lunch = $row['patient_lunch'];
                $patient_dinner = $row['patient_dinner'];
                if(!empty($patient_breakfast)){
                    $len = strlen($patient_breakfast);
                    if($len == 3){
                        $breakfast_hh = substr($patient_breakfast,0,1);
                        $breakfast_mm = substr($patient_breakfast,2,2);
                    }else if($len == 4){
                        $breakfast_hh = substr($patient_breakfast,0,2);
                        $breakfast_mm = substr($patient_breakfast,2,2);
                    }
                }
                if(!empty($patient_lunch)){
                    $len = strlen($patient_lunch);
                    if($len == 3){
                        $lunch_hh = substr($patient_lunch,0,1);
                        $lunch_mm = substr($patient_lunch,2,2);
                    }else if($len == 4){
                        $lunch_hh = substr($patient_lunch,0,2);
                        $lunch_mm = substr($patient_lunch,2,2);
                    }
                }
                if(!empty($patient_dinner)){
                    $len = strlen($patient_dinner);
                    if($len == 3){
                        $dinner_hh = substr($patient_dinner,0,1);
                        $dinner_mm = substr($patient_dinner,2,2);
                    }else if($len == 4){
                        $dinner_hh = substr($patient_dinner,0,2);
                        $dinner_mm = substr($patient_dinner,2,2);
                    }
                }
            }
        }
        $op = "update";
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?=$GLOBALS['title']?></title>
    <link rel="stylesheet" type="text/css" href="web.css">
    <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.theme.css">
    <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.css">
    <script language="javascript" src="jquery-3.1.0.slim.min.js"></script>
    <script language="javascript" src="jquery-ui/external/jquery/jquery.js"></script>
    <script language="javascript" src="jquery-ui/jquery-ui.js"></script>

    <script language="javascript">
        var url = "profile_controller.php";
        $(document).ready(function(){
            $("#patient_bod").datepicker({'dateFormat':'dd-mm-yy', 'changeMonth':true, 'changeYear':true, 'yearRange':'-90:+0'});
            $('#btnSave').click(function () {
                var param = $('#frm').serialize();
                $.post(url, param, function (data) {
                    alert(data);
                });
            })
        });
    </script>
</head>
<body>
<div id="header" align="center" class="content"><br />
    <h1><?=$GLOBALS['title']?><br/>ข้อมูลผู้ป่วย</h1>
</div>
<div class="container">
    <table align="center" cellpadding="5" cellspacing="0">
        <?php display_profile_header(1, $_REQUEST['id']); ?>
        <tr><td>
    <div>
        <form id="frm" name="frm" onsubmit="return false;">
            <input type="hidden" id="patient_id" name="patient_id" value="<?=$patient_id?>" />
            <input type="hidden" id="op" name="op" value="<?=$op?>" />
            <table cellpadding="5" cellspacing="0" bgcolor="#ffebcd">
                <tr>
                    <th align="left">ชื่อ-นามสกุล:</th>
                    <td><input type="text" name="patient_name" id="patient_name" size="50" value="<?=$patient_name;?>"></td>
                </tr>
                <tr>
                    <th align="left">ชื่อผู้ใช้:</th>
                    <td><input type="text" name="patient_user" id="patient_user" value="<?=$patient_user;?>"></td>
                </tr>
                <tr>
                    <th align="left">รหัสผ่าน:</th>
                    <td><input type="password" name="patient_pwd" id="patient_pwd" value="<?=$patient_pwd;?>"></td>
                </tr>
                <tr>
                    <th align="left">เบอร์ติดต่อ:</th>
                    <td><input type="text" name="patient_phone" id="patient_phone" value="<?=$patient_phone;?>"></td>
                </tr>
                <tr>
                    <th align="left">วันเดือนปีเกิด:</th>
                    <td><input type="text" name="patient_bod" id="patient_bod" value="<?=$patient_bod;?>"></td>
                </tr>
                <tr>
                    <th align="left">ส่วนสูง (cm):</th>
                    <td><input type="text" name="patient_height" id="patient_height" value="<?=$patient_height;?>"></td>
                </tr>
                <tr>
                    <th align="left">น้ำหนัก (kg):</th>
                    <td><input type="text" name="patient_weight" id="patient_weight" value="<?=$patient_weight;?>"></td>
                </tr>
                <tr>
                    <th valign="top" align="left">ประวัติการแพ้ยา:</th>
                    <td><textarea name="patient_allergy" id="patient_allergy" cols="30" rows="3"><?=$patient_allergy;?></textarea></td>
                </tr>
                <tr>
                    <th align="left">เวลารับประทานยาเช้า:</th>
                    <td>
                        <input type="text" name="patient_breakfast_hh" id="patient_breakfast_hh" size="2" value="<?=$breakfast_hh?>"> :
                        <input type="text" name="patient_breakfast_mm" id="patient_breakfast_mm" size="2" value="<?=$breakfast_mm?>"> (hh:mm)
                    </td>
                </tr>
                <tr>
                    <th align="left">เวลารับประทานยากลางวัน:</th>
                    <td>
                        <input type="text" name="patient_lunch_hh" id="patient_lunch_hh" size="2" value="<?=$lunch_hh?>"> :
                        <input type="text" name="patient_lunch_mm" id="patient_lunch_mm" size="2" value="<?=$lunch_mm?>"> (hh:mm)
                    </td>
                </tr>
                <tr>
                    <th align="left">เวลารับประทานยาเย็น</th>
                    <td>
                        <input type="text" name="patient_dinner_hh" id="patient_dinner_hh" size="2" value="<?=$dinner_hh?>"> :
                        <input type="text" name="patient_dinner_mm" id="patient_dinner_mm" size="2" value="<?=$dinner_mm?>"> (hh:mm)
                    </td>
                </tr>
                <tr>
                    <th align="left" colspan="2">
                        <button id="btnSave">บันทึกข้อมูล</button>
                    </th>
                </tr>
            </table>

        </form>
    </div></td></tr></table>
</div>
</body>
</html>

