<?php
    require_once 'config.php';
    require_once 'medicine_controller.php';

$op = $_REQUEST['op'];
if($op == "create"){
    $op = "save";
}else if($op == "edit"){
    $medicine = medicine_load($_REQUEST['id']);
    if($medicine){
        foreach($medicine as $row){
            //var_dump($row);
            $med_id = $row['med_id'];
            $med_brand = $row['med_brand'];
            $med_name = $row['med_name'];
            $med_charactor = $row['med_charactor'];
            $med_affect = $row['med_affect'];
            $med_dos = $row['med_dos'];
            $med_number = $row['med_number'];
            $med_desc = $row['med_desc'];
            $med_image = $row['med_image'];
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
        function sendData(f){
            f.target = '_blank';
            return true;
        }
    </script>
</head>
<body>
<div id="header" align="center" class="content"><br />
    <h1><?=$GLOBALS['title']?><br/>ข้อมูลยา</h1>
</div>
<div class="container">
    <table align="center" cellpadding="5" cellspacing="0">
        <?php display_medicine_header(); ?>
        <tr><td>
                <div>
                    <form id="frm" name="frm" method="post" onsubmit="return sendData(this);" enctype="multipart/form-data" action="medicine_controller.php">
                        <input type="hidden" id="med_id" name="med_id" value="<?=$med_id?>" />
                        <input type="hidden" id="med_old_image" name="med_old_image" value="<?=$med_image?>" />
                        <input type="hidden" id="op" name="op" value="<?=$op?>" />
                        <table cellpadding="5" cellspacing="0">
                            <tr>
                                <th align="left">ชื่อทางการค้า:</th>
                                <td><input type="text" name="med_brand" id="med_brand" size="50" value="<?=$med_brand;?>"></td>
                            </tr>
                            <tr>
                                <th align="left">ชื่อยา:</th>
                                <td><input type="text" name="med_name" id="med_name" size="50" value="<?=$med_name;?>"></td>
                            </tr>
                            <tr>
                                <th valign="top" align="left">คุณสมบัติ:</th>
                                <td><textarea name="med_charactor" id="med_charactor" cols="30" rows="3"><?=$med_charactor?></textarea></td>
                            </tr>
                            <tr>
                                <th valign="top" align="left">ผลข้างเคียง:</th>
                                <td><textarea name="med_affect" id="med_affect" cols="30" rows="3"><?=$med_affect?></textarea></td>
                            </tr>
                            <tr>
                                <th valign="top" align="left">รูปภาพยา:</th>
                                <td>
                                    <input type="file" id="med_image" name="med_image" /><br/>
                                <?php
                                    if($med_image != ""){
                                        $fullpath = 'upload/'.$med_image;
                                        if(file_exists($fullpath)){
                                            echo '<img src="'.$fullpath.'" height="50" width="50" onclick="window.open(\''.$fullpath.'\');"/>';
                                        }
                                    }
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <th align="center" colspan="2">
                                    <button id="btnSave">บันทึกข้อมูล</button>
                                </th>
                            </tr>
                        </table>

                    </form>
                </div></td></tr></table>
</div>
</body>
</html>

