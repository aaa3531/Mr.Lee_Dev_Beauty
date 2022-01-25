<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
if(!$wr_comment) {  // 코멘일때는 저장하면 안됨.
	$sql = " update $write_table 
                 set wr_country = '$wr_country',
				 wr_facebook = '$wr_facebook',
				 wr_twitter = '$wr_twitter',
				 wr_youtube = '$wr_youtube',
				 wr_instagram = '$wr_instagram'
				 where wr_id = '$wr_id' " ; 
	sql_query($sql); 
} 
?>