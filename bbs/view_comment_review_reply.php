<?php
//if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');
include_once('./_head.sub.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');


//echo $wr_cm_id = $_GET['comment_id'];
//echo $bo_table = $_GET['bo_table'];
//echo $wr_parent = $_GET['wr_parent'];
//
//echo "select * from $write_table where wr_parent = '$wr_parent' and wr_id ='$wr_cm_id' and wr_is_comment = '1'";
//$rev_cmt = sql_fetch($query);
global $wr_id;
$mb_id = $_POST['mb_id'];
$mb_nick = $_POST['mb_nick'];
$w = $_POST['w'];

if($w =='rvc'){
//$wr = get_write($write_table, $wr_id);
//$query = "select max(wr_6) as max_count from $write_table where wr_parent = '$wr_parent' and wr_is_comment = 2 and wr_comment = '$wr_comment'";
//$row = sql_fetch($query);
//$row['max_count'] += 1;
//$reply_review = 1;    

//echo $wr_cm_id = $_GET['comment_id'];
$bo_table = $_GET['bo_table'];
$wr_parent = $_GET['wr_parent'];
$wr_comment = $_GET['wr_comment'];
$comment_id = $_GET['comment_id'];
$entry_cmt = "insert into $write_table 
                 set wr_num = '-$wr_id',
                     wr_content = '$wr_content',
                     mb_id = '$mb_id',
                     wr_name = '$mb_nick',
                     wr_is_comment = '2',
                     wr_datetime = '".G5_TIME_YMDHIS."',
                     wr_comment = '$wr_comment',
                     wr_parent = '$wr_parent',
                     wr_4 = '$comment_id',
                     wr_5 = '$wr_id',
                     wr_6 = '1'";
sql_query($entry_cmt);
$wr_id = sql_insert_id();
//sql_query("update $write_table set wr_parent = '$wr_parent' where wr_id = '$wr_id' ");
$cnt = "select count(*) as cnt from $write_table where wr_parent = '$wr_parent' and wr_comment = '$wr_comment' and wr_6 = '1'";
$rw = sql_fetch($cnt);
$wr_s7 = $rw['cnt'];
//$wr_s7;
sql_query("update $write_table set wr_7 = '$wr_s7' where wr_parent = '$wr_parent' and wr_comment = '$wr_comment' and wr_6 = '1' and wr_id = '$wr_id'");


 goto_url(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr_parent);

}else if($w == 'rvc_2'){
//$query = "select max(wr_6) as max_count from $write_table where wr_parent = '$wr_parent' and wr_is_comment = 2 and wr_comment = '$wr_comment'";
//$row = sql_fetch($query);
//$row['max_count'] += 1;
//$reply_review = $row['max_count'];    
//echo $wr_cm_id = $_GET['comment_id'];
$bo_table = $_GET['bo_table'];
$wr_parent = $_GET['wr_parent'];
$wr_comment = $_GET['wr_comment'];
$comment_id = $_GET['comment_id'];
$wr_7 = $_POST['wr_7'];
//echo "insert into $write_table 
//                 set wr_num = '-$wr_id',
//                     wr_content = '$wr_content',
//                     mb_id = '$mb_id',
//                     wr_name = '$mb_nick',
//                     wr_is_comment = '3',
//                     wr_datetime = '".G5_TIME_YMDHIS."',
//                     wr_comment = '$wr_comment',
//                     wr_parent = '$wr_parent',
//                     wr_4 = '$comment_id',
//                     wr_5 = '$wr_id',
//                     wr_6 = '2',
//                     wr_7 = '$wr_7',
//                     wr_8 = '1',
//                     wr_9 = '$reply_review'";
//  
$entry_cmt = "insert into $write_table 
                 set wr_num = '-$wr_id',
                     wr_content = '$wr_content',
                     mb_id = '$mb_id',
                     wr_name = '$mb_nick',
                     wr_is_comment = '3',
                     wr_datetime = '".G5_TIME_YMDHIS."',
                     wr_comment = '$wr_comment',
                     wr_parent = '$wr_parent',
                     wr_4 = '$comment_id',
                     wr_5 = '$wr_id',
                     wr_6 = '2',
                     wr_7 = '$wr_7',
                     wr_8 = '1'";
sql_query($entry_cmt);
$wr_id = sql_insert_id();  
$cnt = "select count(*) as cnt from $write_table where wr_parent = '$wr_parent' and wr_comment = '$wr_comment' and wr_6 = '2' and wr_7 = '$wr_7' and wr_8 = '1'";
$rw = sql_fetch($cnt);
$wr_s9 = $rw['cnt'];
sql_query("update $write_table set wr_9 = '$wr_s9' where wr_parent = '$wr_parent' and wr_comment = '$wr_comment' and wr_6 = '2' and wr_7 = '$wr_7' and wr_8='1' and wr_id = '$wr_id'");
//sql_query(" update $write_table set wr_parent = '$wr_parent' where wr_id = '$wr_id' ");
goto_url(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr_parent);    
}else{
    $wr_parent = $_GET['wr_parent'];
    $wr_comment = $_GET['wr_comment'];
    $query_cmt_list = "select * from $write_table where wr_parent = '$wr_parent' and wr_is_comment = '2' and wr_comment = '$wr_comment'";
    
    $rw_cnt = sql_query($query_cmt_list);
}

@include_once($board_skin_path.'/view_comment_review_reply.skin.php');
include_once('./_tail.sub.php');
?>