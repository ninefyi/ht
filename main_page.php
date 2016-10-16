<?php ob_start();

    require_once "config.php";

    $array_patient = array();
    $array_patient[] = array("2558060002", "สมชาย", "รักษ์ดี", "7");
    $array_patient[] = array("2558060003", "พรีพงษ์", "เกรียงไกร", "6");
    $array_patient[] = array("2558060008", "สมศรี", "ดวงดี", "4");
    $array_patient[] = array("2558060010", "พรชัย", "เกษตรชัย", "1");

    $array_column = array("no.", "รหัสผู้ป่วย", "ชื่อ-นามสกุล", "ลืมรับประทานยาทั้งหมดกี่ครั้ง", "ประวัติผู้ป่วย", "สนทนา");

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>ระบบเตือนรับประทานยาผู้ป่วยความดันโลหิตสูง</title>
    <link rel="stylesheet" type="text/css" href="web.css">
</head>
<body>
<div id="header" align="center" class="content"><br />
  <h1>ระบบเตือนรับประทานยาผู้ป่วยความดันโลหิตสูง<br/>หน้าหลัก</h1>
</div>
<div class="container">
<table border="0" cellpadding="5" align="center" align="center">
    <?php display_header(0); ?>
    <tr>
        <td>
            <table border="0" align="center" cellpadding="5" style="border:1px solid black">
                <tr>
                    <td colspan="6">ผู้ป่วยที่ไม่ได้รับประทานยา</td>
                </tr>
                <?php
                    echo '<tr>';
                    foreach($array_column as $value){
                        echo '<td>'.$value.'</td>';
                    }
                    echo '</tr>';
                    $no = 1;
                    foreach($array_patient as $patient){
                        echo '<tr>';
                        echo '<td>'.($no++).'</td>';
                        echo '<td>'.$patient[0].'</td>';
                        echo '<td>'.$patient[1].' '.$patient[2].'</td>';
                        echo '<td>'.$patient[3].'</td>';
                        echo '<td><a href="profile_detail.php?id=">เปิดดู</a></td>';
                        echo '<td><a href="chat.php?id=">ส่งข้อความ</a></td>';
                        echo '</tr>';
                    }
                ?>
            </table></td>
    </tr>
</table>
</div>
</body>
</html>
<?php ob_end_flush(); ?>
