<?php
include_once('./_common.php');
include_once('./_head.sub.php');
$bo_table = $_GET['bo_table'];
$wr_parent = $_GET['wr_parent'];
$comment_id = $_GET['comment_id'];
$w = $_GET['w'];
switch($w){
    case 'de' :
        $sql =  "select count(*) as cnt from $write_table where wr_4 = '$comment_id'" ;
         $row = sql_fetch($sql);
         $total_count = $row['cnt'];
         
         if($total_count > 0){
             alert('댓글이 달린 리뷰는 삭제하실 수 없습니다.');
         }else{
             $query = "delete from $write_table where wr_id = '$comment_id'and wr_parent = '$wr_parent' and wr_is_comment = '1'";
             sql_query($query);
             goto_url(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr_parent);
         }
}

include_once(G5_PATH.'/tail.sub.php');
include_once('./_tail.sub.php');
?>
