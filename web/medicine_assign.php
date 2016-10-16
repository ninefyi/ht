<?php
	require_once 'config.php';

	require_once 'medicine_controller.php';

    $result_set = medicine_load('');
    $med_list = array();
    if($result_set){
        foreach($result_set as $row){
            $med_list[$row['med_id']] = $row['med_brand'];
        }
    }

    $result_set = null;
    $result_set = medicine_load_assign_by_patient($_REQUEST['id']);
    $med_patient_list = array();
    if($result_set){
        $i = 1;
        foreach($result_set as $row){
            $med_patient_list[$i] = $row;
            $i++;
        }
    }
    //echo '<pre>';
    //var_dump($med_patient_list);
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
			$(".datepicker").datepicker({'dateFormat':'dd-mm-yy', 'changeMonth':true, 'changeYear':true, 'yearRange':'-0:+1'});
		});
        function save_assign(row_index){
            var frm_name = '#frm' + row_index;
            var val = $('#p_med_id' + row_index).val();
            var status = "";
            if(val == ""){
                status = "save_assign";
            }else{
                status = "update_assign"
            }
            var param = $(frm_name).serialize() + "&op=" + status + "&row_index=" + row_index;
            //alert(param);
            $.post(url, param, function (data) {
                alert(data);
                window.location.href = 'medicine_assign.php?op=edit&id=' + <?=$_REQUEST['id']?>;
            });
        }
        function save_to_history(row_index){
            var p_med_id = '#p_med_id' + row_index;
            //alert(p_med_id);
            var param = "p_med_id" + row_index + "=" + $(p_med_id).val() + "&op=save_history&row_index=" + row_index;
            //alert(param);
            $.post(url, param, function (data) {
                alert(data);
                window.location.href = 'medicine_assign.php?op=edit&id=' + <?=$_REQUEST['id']?>;
            });
        }
	</script>
</head>
<body>
<div id="header" align="center" class="content"><br />
	<h1><?=$GLOBALS['title']?><br/>ข้อมูลผู้ป่วย</h1>
</div>
<div class="container">
	<table align="center" cellpadding="5" cellspacing="0">
		<?php display_profile_header(2, $_REQUEST['id']); ?>
		<tr>
			<td>
				<div>
                    <?php for($i=1;$i<3;$i++){
                        $med_patient_record = $med_patient_list[$i];
                        $button_value = "บันทึกข้อมูลใหม่";
                        if(isset($med_patient_record['patient_id'])){
                            $button_value = "บันทึกข้อมูลเดิม";
                        }
                    ?>
					<form id="frm<?=$i?>" name="frm<?=$i?>" onsubmit="return false;">
                      <input type="hidden" id="patient_id<?=$i?>" name="patient_id<?=$i?>" value="<?=$_REQUEST['id']?>" />
                      <input type="hidden" id="p_med_id<?=$i?>" name="p_med_id<?=$i?>" value="<?=$med_patient_record['p_med_id']?>" />
                      <table cellpadding="5" class="square" border="0" cellspacing="0" bgcolor="#ffebcd">
                        <tr>
                          <td width="45">ยา <?=$i?>:</td>
                          <td width="174">
                            <select name="med_id<?=$i?>" id="med_id<?=$i?>">
                                <option value="">-เลือกยา-</option>
                                <?php
                                    foreach ($med_list as $key => $value){
                                        echo '<option value="'.$key.'"';
                                        if($key == $med_patient_record['med_id']){
                                            echo ' selected="selected" ';
                                        }
                                        echo '>'.$value.'</option>';
                                    }
                                ?>
                            </select>
                          </td>
                          <td width="62">&nbsp;</td>
                          <td colspan="2">รับประทานครั้งละ (เม็ด)
                            <select name="dosage<?=$i?>" id="dosage<?=$i?>">
                                <?php
                                    foreach ($GLOBALS['amount_for_take'] as $key => $value){
                                        echo '<option value="'.$value.'"';
                                        if($value == $med_patient_record['dosage']){
                                            echo ' selected="selected" ';
                                        }
                                        echo '>'.$key.'</option>';
                                    }
                                ?>
                            </select>
                          </td>
                          <td width="173">เตือนทุกๆ
                              <select name="snooze<?=$i?>" id="snooze<?=$i?>">
                                  <?php
                                  foreach ($GLOBALS['time_for_reminder'] as $key => $value){
                                      echo '<option value="'.$key.'"';
                                      if($key == $med_patient_record['snooze']){
                                          echo ' selected="selected" ';
                                      }
                                      echo '>'.$value.'</option>';
                                  }
                                  ?>
                              </select>
                          </td>
                        </tr>
                        <tr>
                            <td colspan="3">วันเริ่มรับประทาน
                                <input type="text" name="start_date<?=$i?>" id="start_date<?=$i?>" size="10" class="datepicker" value="<?=$med_patient_record['sdate']?>" />
                            </td>
                            <td colspan="3">วันสิ้นสุดรับประทาน
                                <input type="text" name="end_date<?=$i?>" id="end_date<?=$i?>" size="10" class="datepicker" value="<?=$med_patient_record['edate']?>" />
                            </td>
                        </tr>
                        <tr>
                            <?php
                                foreach($GLOBALS['time_for_meal'] as $key => $value){
                                  echo '<td align="right">'.$value.'</td>';
                                    echo '<td>';
                                    foreach($GLOBALS['time_for_take'] as $key2 => $value2){
                                        echo '<input type="radio" name="'.$key.$i.'" value="'.$key2.'"';
                                        if($key2 == $med_patient_record[$key]){
                                            echo ' checked="checked" ';
                                        }
                                        echo '/>';
                                        echo $value2;
                                        echo '<br/>';
                                    }
                                    echo '</td>';
                                }
                            ?>
                        </tr>
                        <tr>
                            <td colspan="2">ผลข้างเคียงของยา</td>
                            <td colspan="2" valign="top"><?=$med_patient_record['med_affect']?>&nbsp;</td>
                            <td>
                                <button type="button" onclick="save_assign('<?=$i?>');"><?=$button_value?></button>&nbsp;</td>
                            </td>
                            <td>
                                <button type="button" onclick="save_to_history('<?=$i?>');">เก็บเข้าแฟ้มประวัติ</button>
                            </td>
                        </tr>
                    </table>
     	        </form><br/>
                <?php } ?>
                </div>
            </td>
        </tr>
</div>
</body>
</html>
