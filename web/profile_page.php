<?php require_once "config.php";

    require_once 'profile_controller.php';
    $profiles = profile_load($_GET['patient_name']);

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?=$GLOBALS['title']?></title>
    <link rel="stylesheet" type="text/css" href="web.css">
    <script language="javascript" src="jquery-3.1.0.slim.min.js"></script>
    <script language="javascript">
        function search_patient(){
            var patient_name = $('#patient_name').val();
            window.location.href = "profile_page.php?patient_name=" + patient_name;
        }
        function delete_patient(id){
            if(confirm("Are you sure to delete?")) {
                window.location.href = "profile_controller.php?op=delete&id=" + id;
            }
        }
    </script>
</head>
<body>
<div id="header" align="center" class="content"><br />
    <h1><?=$GLOBALS['title']?><br/>ข้อมูลผู้ป่วย</h1>
</div>
<div class="container">
<table align="center" cellpadding="5" cellspacing="0">
    <?php display_header(1); ?>
    <tr>
        <td>
            ค้นหาชื่อผู้ป่วย <input type="text" id="patient_name" name="patient_name" value="<?=$_GET['patient_name']?>" />
                <button type="button" onclick="search_patient();">ค้นหา</button>&nbsp;
                <button type="button" onclick="window.location='profile_detail.php?op=create';">เพิ่มข้อมูลผู้ป่วย</button>
        </td>
    </tr>
    <tr><td>
            <table align="center" cellpadding="5" cellspacing="0">
                <tr bgcolor="#c0c0c0">
                    <td width="100">รหัสผู้ป่วย</td>
                    <td width="133">ชื่อ-นามสกุล</td>
                    <td width="131">เบอร์โทร</td>
                    <td width="137">ประวัติผู้ป่วย</td>
                    <td width="90">สนทนา</td>
                    <td width="90">ลบข้อมูล</td>
                </tr>
                <?php
                    if(isset($profiles)){
                        foreach($profiles as $row){
                            echo '<tr>';
                            echo '<td>'.$row['patient_user'].'</td>';
                            echo '<td>'.$row['patient_name'].'</td>';
                            echo '<td>'.$row['patient_phone'].'</td>';
                            echo '<td><a href="profile_detail.php?op=edit&id='.$row['patient_id'].'">ดูข้อมูล</a></td>';
                            echo '<td><a href="chat.php?id='.$row['patient_id'].'">ส่งข้อความ</a></td>';
                            echo '<td><a href="javascript:delete_patient(\''.$row['patient_id'].'\');">ลบข้อมูล</a></td>';
                            echo '</tr>';
                        }
                    }

                ?>

            </table>
        </td></tr>
</table>
</div>
</body>
</html>
