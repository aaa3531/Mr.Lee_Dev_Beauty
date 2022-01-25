<?php
include_once('./_common.php');

$delete_token = get_session('ss_delete_token');
set_session('ss_delete_token', '');

$w = $_GET['w'];
$bo_table = $_GET['bo_table'];
$wr_id = $_GET['wr_id'];
$mb_id = $_GET['mb_id'];
if($w =='dd'){
    //echo " delete from g5_write_$bo_table where wr_id = '$wr_id' and mb_id = '$mb_id' ";
    sql_query(" delete from g5_write_$bo_table where wr_id = '$wr_id' and mb_id = '$mb_id' ");
    goto_url(G5_BBS_URL.'/board.php?bo_table='.$bo_table);
}else if($w == 'all'){
    sql_query(" delete from g5_write_$bo_table where mb_id = '$mb_id' ");
    goto_url(G5_BBS_URL.'/board.php?bo_table='.$bo_table);
}
?>