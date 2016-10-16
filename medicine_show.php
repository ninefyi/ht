<?php require_once "config.php";
    require_once "medicine_controller.php";

    $medicines = medicine_load($_GET['medicine_name']);

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?=$GLOBALS['title']?><br/>ข้อมูลยา</title>
    <link rel="stylesheet" type="text/css" href="web.css">
    <script language="javascript" src="jquery-3.1.0.slim.min.js"></script>
    <script language="javascript">
        function search_medicine(){
            var medicine_name = $('#medicine_name').val();
            window.location.href = "medicine_show.php?medicine_name=" + medicine_name;
        }
        function delete_medicine(id, img){
            if(confirm("Are you sure to delete?")){
                window.location.href = 'medicine_controller.php?op=delete&id=' + id + '&img=' + img;
            }
        }
    </script>
</head>
<body>
<div id="header" align="center" class="content"><br />
    <h1><?=$GLOBALS['title']?><br/>ข้อมูลยา</h1>
</div>
<div class="container">
    <table align="center" cellpadding="5" cellspacing="0">
        <?php display_header(2); ?>
        <tr>
            <td>
                ค้นหาชื่อยา <input type="text" id="medicine_name" name="medicine_name" value="<?=$_GET['medicine_name']?>" />
                <button type="button" onclick="search_medicine();">ค้นหา</button>&nbsp;
                <button type="button" onclick="window.location='medicine_page.php?op=create';">เพิ่มข้อมูลยา</button>
            </td>
        </tr>
        <tr><td>
                <table align="center" cellpadding="5" cellspacing="0">
                    <tr bgcolor="#c0c0c0">
                        <td>No</td>
                        <td>ยี่ห้อ</td>
                        <td>ชื่อยา</td>
                        <td>ลบข้อมูล</td>
                    </tr>
                    <?php
                    $no = 1;
                    $found = 0;
                    if(isset($medicines)){
                        foreach($medicines as $row){
                            echo '<tr>';
                            echo '<td>'.($no++).'</td>';
                            echo '<td>'.$row['med_brand'].'</td>';
                            echo '<td><a href="medicine_page.php?op=edit&id='.$row['med_id'].'">'.$row['med_name'].'</a></td>';
                            echo '<td><a href="javascript:delete_medicine(\''.$row['med_id'].'\',\''.$row['med_image'].'\');">ลบข้อมูล</a></td>';
                            echo '</tr>';
                            $found = 1;
                        }
                    }
                    if($found == 0) {
                        echo '<th colspan="5">ไม่พบข้อมูลยา</th>';
                    }

                    ?>

                </table>
            </td></tr>
    </table>
</div>
</body>
</html>
