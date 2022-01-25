<?php
//if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');
include_once('./_head.sub.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');
$wr_subject = $_GET['wr_subject'];
$mb_id = $_GET['mb_id'];
$mb_nick = $_GET['mb_nick'];
$sql = "insert into g5_write_my_cosmetic
               set mb_id = '$mb_id',
                   wr_subject = '$wr_subject',
                   wr_content = '$wr_subject',
                   wr_name = '$mb_nick'";
sql_query($sql);
alert($wr_subject.'가 나의 화장대에 추가가 되었습니다.')

?>