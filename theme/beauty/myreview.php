<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


include_once(G5_THEME_PATH.'/head.php');
?>
<!-- 마이페이지 시작 { -->
<div id="myreview-pg" class="page-w">
<!--    <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">정보수정</a>-->
    <h3>내가쓴 리뷰</h3>
    <!-- 회원정보 개요 시작 { -->
    
    <?php 
//    $query = "select * from g5_board";
//    $result = sql_query($query);
//    while($row = sql_fetch_array($result)){
//        $tmp_write_table = $g5['write_prefix'] .$row['bo_table']; 
//        $count = sql_fetch("select count(*) as cnt from {$tmp_write_table} where  mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
//         $cnt_1 = $count['cnt'];
//    }
//    
    
    
   
    ?>
    
    <div class="my-info-3">
        <h3>총 작성한 리뷰 <?php echo $member['mb_9'] ?>개</h3>
        <ul>
        <?php
        $sql = "select bo_table from {$g5['board_table']}";
        $result = sql_query($sql);
        while ($row = sql_fetch_array($result)){ 
           $sql2 = "select * from g5_write_{$row['bo_table']} where mb_id = '{$member['mb_id']}' and wr_is_comment = '1'";
           $result2 = sql_query($sql2);
            while ($row_s = sql_fetch_array($result2)){ ?>
               <li>
                   <a href="<?php echo G5_URL ?>/bbs/view_my_review.php?bo_table=<?php echo $row['bo_table'] ?>&wr_parent=<?php echo $row_s['wr_parent']; ?>&wr_id=<?php echo $row_s['wr_id']; ?>&wr_comment=1">
                   
                   <h4><?php echo $row_s['wr_subject']; ?></h4>
                   <h3>별점 : <?php echo $row_s['wr_1']; ?> / 5점</h3>
                   <h5><?php echo $row_s['wr_datetime']; ?></h5>
                   <p><?php echo $row_s['wr_content']; ?></p>
                   </a>
               </li>
                
         <?php   }
             } ?>
        </ul>
    </div>
    <section id="smb_my_ov">
        
<!--
        <div class="smb_me">
	        <strong class="my_ov_name"><img src="<?php echo G5_THEME_IMG_URL ;?>/no_profile.gif" alt="프로필이미지"><br><?php echo $member['mb_name']; ?></strong><br>
	        <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" class="smb_info">정보수정</a>
	        <a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a>
        </div>
-->
<!--
        <dl class="op_area">
            <dt>연락처</dt>
            <dd><?php echo ($member['mb_tel'] ? $member['mb_tel'] : '미등록'); ?></dd>
            <dt>E-Mail</dt>
            <dd><?php echo ($member['mb_email'] ? $member['mb_email'] : '미등록'); ?></dd>
            <dt>최종접속일시</dt>
            <dd><?php echo $member['mb_today_login']; ?></dd>
            <dt>회원가입일시</dt>
            <dd><?php echo $member['mb_datetime']; ?></dd>
            <dt id="smb_my_ovaddt">주소</dt>
            <dd id="smb_my_ovaddd"><?php echo sprintf("(%s%s)", $member['mb_zip1'], $member['mb_zip2']).' '.print_address($member['mb_addr1'], $member['mb_addr2'], $member['mb_addr3'], $member['mb_addr_jibeon']); ?></dd>
        </dl>
-->
        
       
    </section>
    <!-- } 회원정보 개요 끝 -->

</div>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>