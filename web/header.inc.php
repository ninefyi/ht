<?php
    function display_header($disable = 1){
        $hide1 = "";
        $hide2 = "";
        $hide3 = "";
        $hide4 = "";
        echo '<tr><td valign="top"><div>';
        if($disable == 0){
            $hide4 = ' disabled="disabled" ';
        }else if($disable == 1){
            $hide1 = ' disabled="disabled" ';
        }else if($disable == 2){
            $hide2 = ' disabled="disabled" ';
        }
        echo '<button type="button" onclick="window.location=\'profile_page.php\';"'.$hide1.'>ข้อมูลผู้ป่วย</button> ';
        echo '<button type="button" onclick="window.location=\'medicine_show.php\';"'.$hide2.'>ข้อมูลยา</button> ';
        #echo '<button type="button" onclick="window.location=\'medicine_history.php\';"'.$hide3.'>ประวัติการรับประทานยา</button> ';
        echo '</div></td><td rowspan="2" valign="top"><div align="right" style="vertical-align: top;">';
        echo '<button type="button" onclick="window.location=\'main_page.php\';"'.$hide4.'>หน้าหลัก</button><br/><br/>';
        echo '<button type="button" onclick="window.location=\'login.php\';">ออกจากระบบ</button><br/><br/>';
        if($disable != 2){
            #echo '<button type="button" onclick="window.location=\'chat.php\';">คุยกับผู้ป่วย</button><br/>';
        }
        echo '</div></td></tr>';

    }
    function display_profile_header($disable = 1, $id = 0){
        $hide1 = "";
        $hide2 = "";
        $hide3 = "";
        $hide4 = "";
        $url_param = "";
        echo '<tr><td valign="top"><div>';
        if($disable == 0){
            $hide4 = ' disabled="disabled" ';
        }else if($disable == 1){
            $hide1 = ' disabled="disabled" ';
        }else if($disable == 2){
            $hide2 = ' disabled="disabled" ';
        }
        if($id > 0){
            $url_param = '?op=edit&id='.$id;
        }else {
            $hide1 = $hide2 = $hide3 = ' disabled="disabled" ';
        }
        echo '<button type="button" onclick="window.location=\'profile_detail.php'.$url_param.'\';" '.$hide1.'>ข้อมูลทั่วไป</button> ';
        echo '<button type="button" onclick="window.location=\'medicine_assign.php'.$url_param.'\';"'.$hide2.'>ยาที่รับประทาน</button> ';
        echo '<button type="button" onclick="window.location=\'medicine_history.php'.$url_param.'\';"'.$hide3.'>ประวัติการรับประทานยา</button> ';
        echo '</div></td><td rowspan="2" valign="top"><div align="right" style="vertical-align: top;">';
        echo '<button type="button" onclick="window.location=\'profile_page.php\';"'.$hide4.'>กลับสู่เมนูหลัก</button><br/><br/>';
        echo '<button type="button" onclick="window.location=\'login.php\';">ออกจากระบบ</button><br/><br/>';
        #echo '<button type="button" onclick="window.location=\'chat.php\';">คุยกับผู้ป่วย</button><br/>';
        echo '</div></td></tr>';

    }
    function display_medicine_header(){
        echo '<tr><td valign="top"><div>';
        echo '</div></td><td rowspan="2" valign="top"><div align="right" style="vertical-align: top;">';
        echo '<button type="button" onclick="window.location=\'medicine_show.php\';">กลับสู่เมนูหลัก</button><br/><br/>';
        echo '<button type="button" onclick="window.location=\'login.php\';">ออกจากระบบ</button><br/><br/>';
        echo '</div></td></tr>';

    }
    function genUser(){
        return date("ymdHis");
    }
?>