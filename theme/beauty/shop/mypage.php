<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$g5['title'] = '마이페이지';
include_once("../lib/common.lib.php");
include_once('./_head.php');
include_once('./_common.php');
//include_once(G5_LIB_PATH.'/register.lib.php');
//include_once(G5_LIB_PATH.'/thumbnail.lib.php');
//include_once(G5_LIB_PATH.'/mailer.lib.php');

// 쿠폰
$cp_count = 0;
$sql = " select cp_id
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."' ";
$res = sql_query($sql);

for($k=0; $cp=sql_fetch_array($res); $k++) {
    if(!is_used_coupon($member['mb_id'], $cp['cp_id']))
        $cp_count++;
}

// 회원사진 경로
$mb_img_path = G5_DATA_PATH.'/member_image/'.substr($member['mb_id'],0,6).'/'.$member['mb_id'].'.gif';
$mb_img_url = G5_DATA_URL.'/member_image/'.substr($member['mb_id'],0,6).'/'.$member['mb_id'].'.gif';
$mbimg_dir = G5_DATA_PATH.'/member_image/'.substr($mb_id,0,6);

if( $config['cf_member_img_size'] && $config['cf_member_img_width'] && $config['cf_member_img_height'] ){
    $mb_tmp_dir = G5_DATA_PATH.'/member_image/';
    $mb_dir = $mb_tmp_dir.substr($mb_id,0,6);
    if( !is_dir($mb_tmp_dir) ){
        @mkdir($mb_tmp_dir, G5_DIR_PERMISSION);
        @chmod($mb_tmp_dir, G5_DIR_PERMISSION);
    }

    // 아이콘 삭제
    if (isset($_POST['del_mb_img'])) {
        @unlink($mb_dir.'/'.$mb_icon_img);
    }

    // 회원 프로필 이미지 업로드
    $mb_img = '';
    $image_regex = "/(\.(gif|jpe?g|png))$/i";
    $mb_icon_img = get_mb_icon_name($mb_id).'.gif';

    if (isset($_FILES['mb_img']) && is_uploaded_file($_FILES['mb_img']['tmp_name'])) {

        $msg = $msg ? $msg."\\r\\n" : '';

        if (preg_match($image_regex, $_FILES['mb_img']['name'])) {
            // 아이콘 용량이 설정값보다 이하만 업로드 가능
            if ($_FILES['mb_img']['size'] <= $config['cf_member_img_size']) {
                @mkdir($mb_dir, G5_DIR_PERMISSION);
                @chmod($mb_dir, G5_DIR_PERMISSION);
                $dest_path = $mb_dir.'/'.$mb_icon_img;
                move_uploaded_file($_FILES['mb_img']['tmp_name'], $dest_path);
                chmod($dest_path, G5_FILE_PERMISSION);
                if (file_exists($dest_path)) {
                    $size = @getimagesize($dest_path);
                    if (!($size[2] === 1 || $size[2] === 2 || $size[2] === 3)) { // gif jpg png 파일이 아니면 올라간 이미지를 삭제한다.
                        @unlink($dest_path);
                    } else if ($size[0] > $config['cf_member_img_width'] || $size[1] > $config['cf_member_img_height']) {
                        $thumb = null;
                        if($size[2] === 2 || $size[2] === 3) {
                            //jpg 또는 png 파일 적용
                            $thumb = thumbnail($mb_icon_img, $mb_dir, $mb_dir, $config['cf_member_img_width'], $config['cf_member_img_height'], true, true);
                            if($thumb) {
                                @unlink($dest_path);
                                rename($mb_dir.'/'.$thumb, $dest_path);
                            }
                        }
                        if( !$thumb ){
                            // 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
                            @unlink($dest_path);
                        }
                    }
                    //=================================================================\
                }
            } else {
                $msg .= '회원이미지을 '.number_format($config['cf_member_img_size']).'바이트 이하로 업로드 해주십시오.';
            }

        } else {
            $msg .= $_FILES['mb_img']['name'].'은(는) gif/jpg 파일이 아닙니다.';
        }
    }
}
?>
<?php 
    $count1 = sql_fetch("select count(*) as cnt from g5_write_product_baby where  mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_1 = $count1['cnt'];

  $count2 = sql_fetch("select count(*) as cnt from g5_write_product_bath where  mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_2 = $count2['cnt'];
    
     $count3 = sql_fetch("select count(*) as cnt from g5_write_product_beautytool where  mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_3 = $count3['cnt'];
    
     $count4 = sql_fetch("select count(*) as cnt from g5_write_product_cleansing  where  mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_4 = $count4['cnt'];
    
     $count5 = sql_fetch("select count(*) as cnt from g5_write_product_contouring  where  mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_5 = $count5['cnt'];
    
     $count6 = sql_fetch("select count(*) as cnt from g5_write_product_device where mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_6 = $count6['cnt'];
    
     $count7 = sql_fetch("select count(*) as cnt from g5_write_product_eyemakeup mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_7 = $count7['cnt'];
    
     $count8 = sql_fetch("select count(*) as cnt from g5_write_product_facemakeup where mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_8 = $count8['cnt'];
    
     $count9 = sql_fetch("select count(*) as cnt from g5_write_product_fragnance where mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_9 = $count9['cnt'];
    
     $count10 = sql_fetch("select count(*) as cnt from g5_write_product_hair where  mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_10 = $count10['cnt'];
    
     $count11 = sql_fetch("select count(*) as cnt from g5_write_product_innerbeauty where mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_11 = $count11['cnt'];
    
     $count12 = sql_fetch("select count(*) as cnt from g5_write_product_lipmakeup where mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_12 = $count12['cnt'];
    
     $count13 = sql_fetch("select count(*) as cnt from g5_write_product_living where mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_13 = $count13['cnt'];
    
     $count14 = sql_fetch("select count(*) as cnt from g5_write_product_mans where mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_14 = $count14['cnt'];
    
     $count15 = sql_fetch("select count(*) as cnt from g5_write_product_mask where mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_15 = $count15['cnt'];

    $count16 = sql_fetch("select count(*) as cnt from g5_write_product_nail where mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_16 = $count16['cnt'];

    $count17 = sql_fetch("select count(*) as cnt from g5_write_product_skincare where mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_17 = $count17['cnt'];

    $count18 = sql_fetch("select count(*) as cnt from g5_write_product_suncare where mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
    $cnt_18 = $count18['cnt'];
    $total_count = $cnt_1 +$cnt_2 +$cnt_3 +$cnt_4 +$cnt_5 +$cnt_6 +$cnt_7 +$cnt_8 +$cnt_9 +$cnt_10 +$cnt_11 +$cnt_12 +$cnt_13 +$cnt_14 +$cnt_15 +$cnt_16 +$cnt_17 +$cnt_18; 
    
    sql_query("update g5_member set mb_9 = '$total_count' where mb_id = '{$member['mb_id']}'");
?>
<script>
    $(document).ready(function(){
        var mymenuBtn = $('.mymenu-button');
        var myMenuBg = $('.my-menu');
        var myEditBtn = $('.myedit');
        var myEditMenu = $('.edit-skin');
        var myEditClost =$('.close-btn');
        myEditMenu.hide();
        mymenuBtn.click(function(){
            myMenuBg.addClass('view');     
        });
        myMenuBg.mouseleave(function(){
            myMenuBg.removeClass('view');            
        });
        myEditBtn.click(function(){
            myEditMenu.show();
        });
        myEditClost.click(function(){
            myEditMenu.hide();
        });
    });
</script>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script> 
<!-- 마이페이지 시작 { -->
<div class="my-menu">
            <h4>내 설정</h4>
            <ul class="my-list">
                <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">비밀번호 변경</a></li>
                <li><a href="">관심없어요 관리</a></li>
            </ul>
            <h4>알림설정</h4>
            <ul class="my-list">
                <li><a href="">내알림</a></li>
                <li><a href="">공지/이벤트 알림</a></li>
            </ul>
            <h4>고객센터</h4>
            <ul class="my-list">
               <li><a href="<?php echo G5_BBS_URL ?>/faq.php">FAQ</a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/qalist.php">1:1문의</a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=notice">공지사항</a></li>
            </ul>
            <ul class="logout">
                <li><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" onclick="return member_leave();">회원탈퇴</a></li>
            </ul>
        </div>
<div id="mypage" class="page-w">
    <!-- 회원정보 개요 시작 { -->
    <section class="my-info">
        <div class="mymenu-button">
            <img src="<?php echo G5_THEME_IMG_URL ;?>/mymenu-setting.svg" alt="">
        </div>
        
        <div class="thumb">
             <?php if(!get_member_profile_img($member['mb_id'])){ ?>
             <strong class="my_ov_name"><img src="<?php echo G5_THEME_IMG_URL ;?>/no_profile.gif" alt="프로필이미지"><br></strong>
              <?php } else {?>
            <strong class="my_ov_name"><?php echo get_member_profile_img($member['mb_id'],600,600); ?></strong>
              <?php } ?>
        </div>
        <div class="info-sec">
            <h4><?php echo $member['mb_nick']; ?></h4>
            <h5><?php if($member['mb_1'] ==1){ 
                       echo '남성';
                          } else {
                       echo '여성';
                              } ?> / <?php echo $member['mb_2']; ?>년생 / <?php if ($member['mb_3'] ==1){
                echo '지성';
                  }else if($member['mb_3'] ==2){
                echo '중성';
                  }else if($member['mb_3'] ==3){
                echo '건성';
                 }?> /  <?php if ($member['mb_4'] ==1){
                echo '없음';
                  }else if($member['mb_4'] ==2){
                echo '기미/잡티';
                  }else if($member['mb_4'] ==3){
                echo '여드름';
                 }else if($member['mb_4'] ==4){
                echo '아토피';
                 }else if($member['mb_4'] ==5){
                echo '민감성';
                 }else if($member['mb_4'] ==6){
                echo '주름/노화';
                  }?></h5>
            <div class="my-level"><a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" class="win_memo"><span class="sound_only">새로운 </span>메시지
	                <strong><?php echo $memo_not_read ?></strong>
	            </a> /  <a href="<?php echo G5_BBS_URL ?>/scrap.php" target="_blank" class="win_scrap">
	            	북마크
	            	<strong class="scrap">0</strong>
	            </a>
	            <a href="<?php echo G5_BBS_URL ?>/point.php" target="_blank" class="win_point">활동지수
					<strong><?php echo number_format($member['mb_point']); ?> P</strong>
	            </a> 
	            </div>
	            <div class="myedit">내 정보수정</div>
        </div>
    </section>
    <?php 
//    $query = "select * from g5_board";
//    $result = sql_query($query);
//    while($row = sql_fetch_array($result)){
//        $tmp_write_table = $g5['write_prefix'] .$row['bo_table']; 
//        $count = sql_fetch("select count(*) as cnt from {$tmp_write_table} where  mb_id = '{$member['mb_id']}' and wr_is_comment ='1'"); 
//         $cnt_1 = $count['cnt'];
//    }
//    $total_count = $cnt_1; 
    ?>
    
    
    <?php
     $count_scr = sql_fetch("select count(*) as cnt from g5_scrap where mb_id = '{$member['mb_id']}'");
     $total_scr = $count_scr['cnt'];
    ?>
    <div class="my-info-2">
        <ul>
            <li>
            <a href="<?php echo G5_URL; ?>/myreview.php">
            <img src="<?php echo G5_THEME_IMG_URL; ?>/reviewbtn.svg" alt="">
            <p>작성한 리뷰</p>
            <h6><?php echo $member['mb_9'] ?> 개</h6>
            </a></li>
            <li><a href="<?php echo G5_URL; ?>/bbs/scrap.php">
            <img src="<?php echo G5_THEME_IMG_URL; ?>/wantbtn.svg" alt="">
            <p>써보고 싶어요</p>
            <h6><?php echo $total_scr; ?> 개</h6></a></li>
            <li><a href="#">
            <img src="<?php echo G5_THEME_IMG_URL; ?>/morehelpbtn.svg" alt="">
            <p>도움된 리뷰</p></a></li>
        </ul>
        <ul class="bs-2">
            <li><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=my_cosmetic"><img src="<?php echo G5_THEME_IMG_URL; ?>/icon-hwajang.svg" alt=""><span>화장대</span></a></li>
            <li><a href="#"><img src="<?php echo G5_THEME_IMG_URL; ?>/icon-recommend.svg" alt=""><span>추천제품</span></a></li>
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

<div class="edit-skin">
    <h3>내정보 수정</h3>
    <div class="close-btn"></div>
    <form id="editskinform" name="editskinform" method="post" action="<?php echo G5_THEME_URL;?>/shop/mypage_update.php" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="url" value="<?php echo $urlencode ?>">
	<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
	<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
	<div id="reg3" class="tbl_frm01 tbl_wrap register_form_inner">
             <ul>
                
                 
	            <li class="reg_mb_img_file">
	               <div class="thumb">
             <?php if(!get_member_profile_img($member['mb_id'])){ ?>
             <strong class="my_ov_name"><img src="<?php echo G5_THEME_IMG_URL ;?>/no_profile.gif" alt="프로필이미지"><br></strong>
              <?php } else {?>
            <strong class="my_ov_name"><?php echo get_member_profile_img($member['mb_id'],600,600); ?></strong>
              <?php } ?>
                </div>
                 <?php if ($member['mb_level'] >= $config['cf_icon_level'] && $config['cf_member_img_size'] && $config['cf_member_img_width'] && $config['cf_member_img_height']) {  ?>
<!-- 
	                <label for="reg_mb_img" class="frm_label">
	                	회원이미지 크기는 가로 <?php echo $config['cf_member_img_width'] ?>픽셀, 세로 <?php echo $config['cf_member_img_height'] ?>픽셀 이하로 해주세요.<br>
	                    gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_img_size']) ?>바이트 이하만 등록됩니다.
	                </label>
-->
	                <input type="file" name="mb_img" id="reg_mb_img">
	
	                <?php if ($w == 'u' && file_exists($mb_img_path)) {  ?>
	                <img src="<?php echo $mb_img_url ?>" alt="회원이미지">
	                <input type="checkbox" name="del_mb_img" value="1" id="del_mb_img">
	                <label for="del_mb_img">삭제</label>
	                <?php }  ?>
	            <?php } ?>
	            </li>
	            
               <li>
                   <div class="t"><label for="mb_nick">닉네임<strong class="sound_only">필수</strong></label></div>
                   <div class="c">
                   <input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
                    <input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>" id="reg_mb_nick" class="frm_input required nospace full_input" size="10" maxlength="20" placeholder="닉네임">
                    <span class="form-control-clear glyphicon glyphicon-remove form-control-feedback hidden"></span>
                    <span id="msg_mb_nick"></span>
                    </div> 
                    
                    <script>
                   $(document).ready(function(){
                      $('#reg_mb_nick').on('input change', function() {
                        var $this = $(this);
                        var visible = Boolean($this.val());
                        $('.form-control-clear').toggleClass('hidden', !visible);
                      }).trigger('propertychange');
                      
                      $('.form-control-clear').on('click', function() {
                        $('#reg_mb_nick').val('').trigger('change').focus();
                        $(this).toggleClass('hidden', true);
                      });
                   });
                   </script>                
	            </li>
                <li>
	                <div class="t"><label for="mb_1">성별<strong class="sound_only">필수</strong></label></div>
	                <div class="c"> 
                    <input type="radio" id="mb-1-1" name="mb_1" value="1"<?php if($member['mb_1'] == "1") { echo "checked"; } ?>><label for="mb-1-1">남성</label>
                    <input type="radio" id="mb-1-2" name="mb_1" value="2"<?php if($member['mb_1'] == "2") { echo "checked"; } ?>><label for="mb-1-2">여성</label></div>         
	            </li>
	            <li>
                    <div class="t"><label for="mb_2">연령<strong class="sound_only">필수</strong></label></div>
	                <div class="c">
                    <select name="mb_2" id="mb_2">
	                    <?php for($i=1920; $i<=2020; $i++) { ?>
                        <option value="<?php echo $i?>" <?php if($member['mb_2']==$i) {?> selected <?php }?>><?php echo $i ?></option>
                        <?php }?>
	                </select><span> 년생</span>
	                </div>
	            </li>
	            <li>
                    <div class="t"><label for="mb_3">피부타입<strong class="sound_only">필수</strong></label></div>
	                 <div class="c">
                     <input type="radio" name="mb_3" id="mb-3-1" value="1"<?php if($member['mb_3'] == "1") { echo "checked"; } ?>> <label for="mb-3-1">지성</label>
                         <input type="radio" name="mb_3" id="mb-3-2" value="2"<?php if($member['mb_3'] == "2") { echo "checked"; } ?>> <label for="mb-3-2">중성</label>
                         <input type="radio" name="mb_3" id="mb-3-3" value="3"<?php if($member['mb_3'] == "3") { echo "checked"; } ?>> <label for="mb-3-3">건성</label>
                         <input type="radio" name="mb_3" id="mb-3-4" value="4"<?php if($member['mb_3'] == "4") { echo "checked"; } ?>> <label for="mb-3-4">복합성</label></div>
	            </li>
	            <?php $array = explode('|', $member['mb_4']); ?>
	            <li class="chk_box">
                    <div class="t"><label for="mb_4">피부 고민<strong class="sound_only">필수</strong></label></div>
	                 <div class="c">
	                     <input type="checkbox" id="chk-1" name="mb_4[]" value="1"<?php if(in_array('1', $array)) { echo "checked"; }?>> <label for="chk-1">없음</label>
	                     <input type="checkbox" id="chk-2" name="mb_4[]" value="2"<?php if(in_array('2', $array)) { echo "checked"; } ?>> <label for="chk-2">기미/잡티</label>
                         <input type="checkbox" id="chk-3" name="mb_4[]" value="3"<?php if(in_array('3', $array)){ echo "checked"; } ?>> <label for="chk-3">여드름</label>
                         <input type="checkbox" id="chk-4" name="mb_4[]" value="4"<?php if(in_array('4', $array)) { echo "checked"; } ?>><label for="chk-4">아토피</label>
                         <input type="checkbox" id="chk-5" name="mb_4[]" value="5"<?php if(in_array('5', $array)){ echo "checked"; } ?>> <label for="chk-5">민감성</label>
                         <input type="checkbox" id="chk-6" name="mb_4[]" value="6"<?php if(in_array('6', $array)) { echo "checked"; } ?>> <label for="chk-6">주름노화</label>
                         <p>중복선택 가능</p></div>
                         
	            </li>
	            <hr>
	            <h5>배송정보</h5>
	            <p>이벤트 상품 배송시 사용됩니다. 정확히 입력해주세요.</p>
	            <li>
	                <div class="t">이름</div>
	                <div class="c"><input type="text" name="mb_name" value="<?php echo isset($member['mb_name'])?get_text($member['mb_name']):''; ?>" id="reg_mb_name" class="frm_input nospace full_input" size="10" maxlength="20" placeholder="이름을 입력해주세요"></div>
	            </li>
	            <li>
	                <div class="t">연락처</div>
	                <div class="c"><input type="text" name="mb_tel" value="<?php echo isset($member['mb_tel'])?get_text($member['mb_tel']):''; ?>" id="reg_mb_tel" class="frm_input nospace full_input" size="10" maxlength="20" placeholder="연락처를 입력해주세요."></div>
	            </li>
	            <li>
	            	<div class="t">주소</div>
	            	<div class="c">
					<?php if ($config['cf_req_addr']) { ?><strong class="sound_only">필수</strong><?php }  ?>
	                <label for="reg_mb_zip" class="sound_only">우편번호<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
	                <input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input twopart_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6"  placeholder="우편번호">
	                <button type="button" class="btn_frmline" onclick="win_zip('editskinform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button><br>
	                <input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input frm_address full_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="50"  placeholder="기본주소">
	                <label for="reg_mb_addr1" class="sound_only">기본주소<?php echo $config['cf_req_addr']?'<strong> 필수</strong>':''; ?></label><br>
	                <input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="frm_input frm_address full_input" size="50" placeholder="상세주소">
	                <label for="reg_mb_addr2" class="sound_only">상세주소</label>
	                <br>
	                <input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="frm_input frm_address full_input" size="50" readonly="readonly" placeholder="참고항목">
	                <label for="reg_mb_addr3" class="sound_only">참고항목</label>
	                <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">
	                </div>
	            </li>
             </ul>
             <script>
//                    $(document).ready(function(){
//                        var count =1;
//                        $('.btnAdd').click (function () {                                        
//                             $('.mb_5_c').append (                        
//                                 '<input type="text" name="mb_5_v" class="input" placeholder="제품을 입력해주세요"> <input type="button" class="btnRemove remove_btn" value=""><br>'               
//                             ); // end append
//                              count++;
//                              console.log(count);
//                             $('.btnRemove').on('click', function () { 
//                                 $(this).prev().remove (); // remove the textbox
//                                 $(this).next ().remove (); // remove the <br>
//                                 $(this).remove (); // remove the button
//                                 count--; 
//                                 console.log(count);
//                             });
//                        }); // end click          
//                        setInterval(function(){
//                             var result='';
//	                        $('input[name=mb_5_v]').map(function(){
//	                        	result +=$(this).val()+'|';
//	                        });
//                            $('input[type=hidden][name=mb_5]').val(result);
//                        },1000);
//                        
//                    });
                    </script>
                    
             <script>
                        $(document).ready(function(){
                            $('#chk-1').click(function(){
                                var chk = $(this).is(':checked');
                                if(chk){
                                    $('#chk-2').prop('checked',false);
                                    $('#chk-3').prop('checked',false);
                                    $('#chk-4').prop('checked',false);
                                    $('#chk-5').prop('checked',false);
                                    $('#chk-6').prop('checked',false);
                                }
                            });
                            $('#chk-2').click(function(){
                                var chk = $(this).is(':checked');
                                if(chk){
                                    $('#chk-1').prop('checked',false);
                                }
                            });
                            $('#chk-3').click(function(){
                                var chk = $(this).is(':checked');
                                if(chk){
                                    $('#chk-1').prop('checked',false);
                                }
                            });
                            $('#chk-4').click(function(){
                                var chk = $(this).is(':checked');
                                if(chk){
                                    $('#chk-1').prop('checked',false);
                                }
                            });
                            $('#chk-5').click(function(){
                                var chk = $(this).is(':checked');
                                if(chk){
                                    $('#chk-1').prop('checked',false);
                                }
                            });
                            $('#chk-6').click(function(){
                                var chk = $(this).is(':checked');
                                if(chk){
                                    $('#chk-1').prop('checked',false);
                                }
                            });
                            
                        });
                    </script>
             
            <button type="submit" id="btn_submit" class="btn_submit" accesskey="s">수정 완료</button>
    </div> 
<!--    <input type="button" id="btn_submit" class="btn_submit" accesskey="s" value="수정 완료" onclick="funct2()">  -->
    </form>
    
</div>
<script>
$(function() {
    $(".win_coupon").click(function() {
        var new_win = window.open($(this).attr("href"), "win_coupon", "left=100,top=100,width=700, height=600, scrollbars=1");
        new_win.focus();
        return false;
    });
});

function member_leave()
{
    return confirm('정말 회원에서 탈퇴 하시겠습니까?')
}

function out_cd_check(fld, out_cd)
{
    if (out_cd == 'no'){
        alert("옵션이 있는 상품입니다.\n\n상품을 클릭하여 상품페이지에서 옵션을 선택한 후 주문하십시오.");
        fld.checked = false;
        return;
    }

    if (out_cd == 'tel_inq'){
        alert("이 상품은 전화로 문의해 주십시오.\n\n장바구니에 담아 구입하실 수 없습니다.");
        fld.checked = false;
        return;
    }
}

function fwishlist_check(f, act)
{
    var k = 0;
    var length = f.elements.length;

    for(i=0; i<length; i++) {
        if (f.elements[i].checked) {
            k++;
        }
    }

    if(k == 0)
    {
        alert("상품을 하나 이상 체크 하십시오");
        return false;
    }

    if (act == "direct_buy")
    {
        f.sw_direct.value = 1;
    }
    else
    {
        f.sw_direct.value = 0;
    }

    return true;
}
</script>
<!-- } 마이페이지 끝 -->
<!--
<script>
function funct2(){
    document.editskinform.submit();
    alert('수정이 완료되었습니다.');
    history.go(0);
}
</script>
-->
<?php
include_once("./_tail.php");
?>