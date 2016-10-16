<?php
    require_once 'message_controller.php';
    $id = $_GET['id'];
    if(!empty($id)){
        $all_msg = message_load($id);
    }
    $patients = load_all_patient();
    $fullname = $patients[$id]['name'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>ระบบเตือนรับประทานยาผู้ป่วยความดันโลหิตสู</title>
    <link rel="stylesheet" type="text/css" href="web.css">
    <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.theme.css">
    <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.css">
    <script language="javascript" src="jquery-ui/external/jquery/jquery.js"></script>
    <script src="https://cdn.netpie.io/microgear.js"></script>
    <script>
        const APPID     = "Hypertension";
        const APPKEY    = "hCOs4P1PsSaANgY";
        const APPSECRET = "Ztt2nX3O2CwobnKszSv1B5vqg";
        const Alias = "nurse";

        var microgear = Microgear.create({
            key: APPKEY,
            secret: APPSECRET,
            alias : Alias
        });

        microgear.on('message',function(topic, msg) {
            console.log(topic + '=' +msg);
            var original = $('#msg').html();
            original+='<p align="left">' + msg + '</p>';
            $('#msg').html(original);

        });

        //microgear.on('connected', function() {
            //document.getElementById("data").innerHTML = "Now I am connected with netpie...";
            //setInterval(function() {
                //microgear.chat(Alias,"Hello from myself at "+Date.now());
            //},5000);
        //});

        microgear.on('present', function(event) {
            console.log(event);
        });

        microgear.on('absent', function(event) {
            console.log(event);
        });

        $(document).ready(function () {
            microgear.connect(APPID);
            <?php foreach($patients as $patient){
                $pid = $patient['id'];
                echo 'microgear.subscribe("/patient'.$pid.'");'."\n";
            }?>
            $('#patient_id').val('<?=$id?>');
            $('#btn_send').click(function () {
                var msg = $('#txt_msg').val();
            })
        });

    </script>
    </head>
<body>
<div id="header" align="center" class="content"><br />
    <h1><?=$GLOBALS['title']?><br/>ข้อมูลผู้ป่วย</h1>
</div>
<div class="container">
    <table align="center" cellpadding="5" cellspacing="0" border="0">
        <?php display_profile_header(2, $_REQUEST['id']); ?>
        <tr><td>บทสนทนากับผู้ป่วยชื่อ <?=$fullname?></td></tr>
        <tr>
            <td>
                <div id="msg" style="height:200px;width:450px;border:solid 2px black;overflow:scroll;overflow-x:hidden;overflow-y:scroll;">
                    <p align="left">xxx</p>
                    <p align="right">yyy</p>
                </div>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <input type="hidden" id="patient_id" name="patient_id" />
                <input type="text" id="txt_msg" name="txt_msg" size="50" style="border:1px solid black;" />
                <button id="btn_send" name="btn_send">ส่งข้อความ</button>
            </td>
            <td>
                <div id="user_message">
                    <?php
                        foreach($patients as $patient){
                            $id = $patient['id'];
                            $name = $patient['name'];
                            if($patient['cnt'] != ""){
                                $cnt = $patient['cnt'];
                                $name = "$name ข้อความใหม่($cnt)";
                            }
                            echo '<div id="patient'.$id.'" name="patient'.$id.'">'.$name.'</div>';
                        }
                    ?>
                </div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>

