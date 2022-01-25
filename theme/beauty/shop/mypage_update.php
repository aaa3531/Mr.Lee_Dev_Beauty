<?php 
//   if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

   include_once("../lib/common.lib.php");
   include_once('./_head.php');
   include_once('./_common.php');
   include_once(G5_LIB_PATH.'/register.lib.php');
   include_once(G5_LIB_PATH.'/thumbnail.lib.php');
   include_once(G5_LIB_PATH.'/mailer.lib.php');

   $mb_nick = trim($_POST['mb_nick']);
   $mb_name = trim($_POST['mb_name']);
   $mb_tel = trim($_POST['mb_tel']);
   $mb_1 = trim($_POST['mb_1']);
   $mb_2 = trim($_POST['mb_2']);
   $mb_3 = trim($_POST['mb_3']);
   $mb_4 = implode( '|', $_POST['mb_4']);
   $mb_zip1        = isset($_POST['mb_zip'])           ? substr(trim($_POST['mb_zip']), 0, 3) : "";
   $mb_zip2        = isset($_POST['mb_zip'])           ? substr(trim($_POST['mb_zip']), 3)    : "";
   $mb_addr1       = isset($_POST['mb_addr1'])         ? trim($_POST['mb_addr1'])       : "";
   $mb_addr2       = isset($_POST['mb_addr2'])         ? trim($_POST['mb_addr2'])       : "";
   $mb_addr3       = isset($_POST['mb_addr3'])         ? trim($_POST['mb_addr3'])       : "";
   $mb_addr_jibeon = isset($_POST['mb_addr_jibeon'])   ? trim($_POST['mb_addr_jibeon']) : "";
   $sql = " update {$g5['member_table']}
                set mb_nick = '{$mb_nick}',
                    mb_name = '{$mb_name}',
                    mb_tel = '{$mb_tel}',
                    mb_zip1 = '{$mb_zip1}',
                    mb_zip2 = '{$mb_zip2}',
                    mb_addr1 = '{$mb_addr1}',
                    mb_addr2 = '{$mb_addr2}',
                    mb_addr3 = '{$mb_addr3}',
                    mb_addr_jibeon = '{$mb_addr_jibeon}',
                    mb_1 = '{$mb_1}',
                    mb_2 = '{$mb_2}',
                    mb_3 = '{$mb_3}',
                    mb_4 = '{$mb_4}'
              where mb_id = '{$member['mb_id']}' ";
   $result = sql_query($sql);
   alert("수정완료");
?>