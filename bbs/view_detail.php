<?php
//if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');
include_once('./_head.sub.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');
//@include_once($board_skin_path.'/view.head.skin.php');

$wr_id = $_GET['wr_parent'];
$wr_subject = $_GET['wr_subject'];
$bo_table = $_GET['bo_table'];

$query = "select * from g5_write_$bo_table where wr_id = '$wr_id' and wr_subject = '$wr_subject'";
$row = sql_fetch($query);
$detail_img = $row['file'][0]['view'];
$detail_img_lk = $row['wr_link1'];
$detail_brand = $row['wr_brand'];
$detail_subject = $row['wr_subject'];
$detail_price = $row['wr_goods_price'];
$detail_vol = $row['wr_goods_vol'];
$detail_content = $row['wr_content'];
$detail_vor_per = $row['wr_goods_vol_per'];
$detail_vor_ca = $row['ca_name'];

echo $detail_img;

$query_bo = "select * from g5_board where bo_table = '$bo_table'";
$row_bo = sql_fetch($query_bo);
$bo_name = $row_bo['bo_subject'];
include_once($board_skin_path.'/view_detail.skin.php');


include_once('./_tail.sub.php');
?>