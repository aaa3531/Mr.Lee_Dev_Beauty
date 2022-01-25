<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


include_once(G5_THEME_PATH.'/head.php');
?>
<!-- 마이페이지 시작 { -->
<div id="myreview-pg" class="page-w">
    <h3>화장대</h3>
    <!-- 회원정보 개요 시작 { -->

    <script>
        $(document).ready(function(){
            $('#hwa-more').click(function(){
                 $('.hwa-more-bg').toggleClass('view');
            });
        });
    </script>
    <div class="my-cosmetic">
        <h5>내가 사용하고 있는 제품으로 화장대를 구성해보세요.</h5>
        <div class="icon-more" id="hwa-more">
            <img src="<?php echo G5_THEME_IMG_URL; ?>/icon-morebtn.svg" alt="">
        </div>
        <div class="hwa-more-bg">
            <ul>
                <li><a href="#">제품추가하기</a></li>
                <li><a href="#">전체삭제하기</a></li>
            </ul>
        </div>
        <ul>
        <?php 
            
            $sql = "select * from g5_my_cosmetics where mb_id = '{$member['mb_id']}'";
            $result = sql_query($sql);
            while($row = sql_fetch_array($result)){
                $bo = "select * from g5_board";
                $re_bo = sql_fetch($bo);
                $my_cosme = $row['cosmetic_name'];
                $tmp_write_table = $g5['write_prefix'] .$re_bo['bo_table']; 
                $sql2 = "select * from {$tmp_write_table} where wr_subject = '$my_cosme'";
                echo $sql2;
                $result_my = sql_query($sql2);
                while($row2= sql_fetch_array($result_my)){?>
                <li class="hwa">
                              <div class="thumb">
                                  <img src="<?php echo $row2['wr_link1']; ?>" alt="">
                              </div>
                              <div class="cont">
                              <h3><?php echo $row2['wr_brand']; ?></h3>
                              <h4><?php echo $row2['wr_subject']; ?></h4>
                                   <a href="<?php echo G5_URL;?>/bbs/board.php?bo_table=<?php echo $re_bo['bo_table']; ?>&wr_id=<?php echo $row2['wr_id']; ?>">평가하기</a>
                              </div>
                      </li>
            <?php    }
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
<div class="layer-popup">
    야
</div>
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>