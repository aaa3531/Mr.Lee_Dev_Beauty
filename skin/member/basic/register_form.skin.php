<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once("../lib/common.lib.php");
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php'); // 달력
if( ! $config['cf_social_login_use']) {     //소셜 로그인을 사용하지 않으면
    return;
}

$social_pop_once = false;

$self_url = G5_BBS_URL."/login.php";

//새창을 사용한다면
if( G5_SOCIAL_USE_POPUP ) {
    $self_url = G5_SOCIAL_LOGIN_URL.'/popup.php';
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원정보 입력/수정 시작 { -->

<div class="register form">
<script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
<?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
<script src="<?php echo G5_JS_URL ?>/certify.js?v=<?php echo G5_JS_VER; ?>"></script>
<?php } ?>

	<form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="url" value="<?php echo $urlencode ?>">
	<input type="hidden" name="agree" value="<?php echo $agree ?>">
	<input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
	<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
	<input type="hidden" name="cert_no" value="">
	<?php if (isset($member['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php }  ?>
	<?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면  ?>
	<input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
	<input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
	<?php }  ?>
	
	<div id="register_form" class="form_01">   
        <h3>회원가입</h3>
	    <div id="reg1" class="register_form_inner">
	        <ul>
	            <li>

	                <input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?> class="frm_input full_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="100" placeholder="이메일을 입력해주세요.">
	                <span id="msg_mb_id"></span>
	            </li>
	            <?php if ($req_nick) {  ?>
	            <li>

	                
                    <input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
                    <input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>" id="reg_mb_nick" required class="frm_input required nospace full_input" size="10" maxlength="20" placeholder="닉네임">
                    <span id="msg_mb_nick"></span>	                
	            </li>
	            <?php }  ?>
	            <li class="full_input left_input margin_input">
<!--	                <label for="reg_mb_password">비밀번호<strong class="sound_only">필수</strong></label>-->
	                <input type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?> class="frm_input full_input <?php echo $required ?>" minlength="3" maxlength="20" placeholder="비밀번호">
				</li>
	            <li class="full_input left_input">
<!--	                <label for="reg_mb_password_re">비밀번호 확인<strong class="sound_only">필수</strong></label>-->
	                <input type="password" name="mb_password_re" id="reg_mb_password_re" <?php echo $required ?> class="frm_input full_input <?php echo $required ?>" minlength="3" maxlength="20" placeholder="비밀번호 확인">
	            </li>
	            <p>비밀번호는 영문 , 숫자 ,특수문자 조합 8자 이상으로 해주십시오.</p>
	        </ul>
            <p>버튼을 누르시면 <span id="term_popup">이용약관</span>,<span id="priv_popup">개인정보취급방침</span>에 동의한것으로 간주됩니다.</p>
	        <div class="button-ver btn_confirm">
	         <button type="submit" id="btn_submit" class="btn_submit" accesskey="s"><?php echo $w==''?'동의하고 가입하기':'정보수정'; ?></button>    
	        </div>
	        <p>이미 가입하셨나요? <span class="login-btn">로그인</span></p>
	        <span>or</span>
	         <div id="sns_login" class="login-sns sns-wrap-32 sns-wrap-over">
    <h3>소셜계정으로 로그인</h3>
    <div class="sns-wrap">
        <?php if( social_service_check('naver') ) {     //네이버 로그인을 사용한다면 ?>
        <a href="<?php echo $self_url;?>?provider=naver&amp;url=<?php echo $urlencode;?>">
            <img src="<?php echo G5_THEME_URL ?>/img/lg-naver.svg" alt="">
        </a>
        <?php }     //end if ?>
        <?php if( social_service_check('kakao') ) {     //카카오 로그인을 사용한다면 ?>
        <a href="<?php echo $self_url;?>?provider=kakao&amp;url=<?php echo $urlencode;?>">
            <img src="<?php echo G5_THEME_URL ?>/img/lg-kakao.svg" alt="">
        </a>
        <?php }     //end if ?>
        <?php if( social_service_check('facebook') ) {     //페이스북 로그인을 사용한다면 ?>
        <a href="<?php echo $self_url;?>?provider=facebook&amp;url=<?php echo $urlencode;?>">
            <img src="<?php echo G5_THEME_URL ?>/img/lg-facebook.svg" alt="">
        </a>
        <?php }     //end if ?>
        <?php if( social_service_check('google') ) {     //구글 로그인을 사용한다면 ?>
        <a href="<?php echo $self_url;?>?provider=google&amp;url=<?php echo $urlencode;?>">
            <img src="<?php echo G5_THEME_URL ?>/img/lg-google.svg" alt="">
        </a>
        <?php }     //end if ?>
        <?php if( social_service_check('twitter') ) {     //트위터 로그인을 사용한다면 ?>
        <a href="<?php echo $self_url;?>?provider=twitter&amp;url=<?php echo $urlencode;?>">
            <img src="<?php echo G5_THEME_URL ?>/img/lg-twitter.svg" alt="">
        </a>
        <?php }     //end if ?>
        <?php if( social_service_check('payco') ) {     //페이코 로그인을 사용한다면 ?>
        <a href="<?php echo $self_url;?>?provider=payco&amp;url=<?php echo $urlencode;?>">
            <img src="" alt="">
        </a>
        <?php }     //end if ?>

        <?php if( G5_SOCIAL_USE_POPUP && !$social_pop_once ){
        $social_pop_once = true;
        ?>
        <script>
            jQuery(function($){
                $(".sns-wrap").on("click", "a.social_link", function(e){
                    e.preventDefault();

                    var pop_url = $(this).attr("href");
                    var newWin = window.open(
                        pop_url, 
                        "social_sing_on", 
                        "location=0,status=0,scrollbars=1,width=600,height=500"
                    );

                    if(!newWin || newWin.closed || typeof newWin.closed=='undefined')
                         alert('브라우저에서 팝업이 차단되어 있습니다. 팝업 활성화 후 다시 시도해 주세요.');

                    return false;
                });
            });
        </script>
        <?php } ?>

    </div>
</div>
	    </div>
	    
	
<!--
	    <div id="reg2" class="tbl_frm01 tbl_wrap register_form_inner">
	        <h2>개인정보 입력</h2>
	        <ul>
	            
	
	            <?php if ($config['cf_use_homepage']) {  ?>
	            <li>
	                <label for="reg_mb_homepage">홈페이지<?php if ($config['cf_req_homepage']){ ?><strong class="sound_only">필수</strong><?php } ?></label>
	                <input type="text" name="mb_homepage" value="<?php echo get_text($member['mb_homepage']) ?>" id="reg_mb_homepage" <?php echo $config['cf_req_homepage']?"required":""; ?> class="frm_input full_input <?php echo $config['cf_req_homepage']?"required":""; ?>" size="70" maxlength="255" placeholder="홈페이지">
	            </li>
	            <?php }  ?>
	
	            <li>
	            <?php if ($config['cf_use_tel']) {  ?>
	            
	                <label for="reg_mb_tel">전화번호<?php if ($config['cf_req_tel']) { ?><strong class="sound_only">필수</strong><?php } ?></label>
	                <input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel" <?php echo $config['cf_req_tel']?"required":""; ?> class="frm_input full_input <?php echo $config['cf_req_tel']?"required":""; ?>" maxlength="20" placeholder="전화번호">
	            <?php }  ?>
				</li>
				<li>
	            <?php if ($config['cf_use_hp'] || $config['cf_cert_hp']) {  ?>
	                <label for="reg_mb_hp">휴대폰번호<?php if ($config['cf_req_hp']) { ?><strong class="sound_only">필수</strong><?php } ?></label>
	                
	                <input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" <?php echo ($config['cf_req_hp'])?"required":""; ?> class="frm_input full_input <?php echo ($config['cf_req_hp'])?"required":""; ?>" maxlength="20" placeholder="휴대폰번호">
	                <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
	                <input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
	                <?php } ?>
	            <?php }  ?>
	            </li>
	
	            <?php if ($config['cf_use_addr']) { ?>
	            <li>
	            	<label>주소</label>
					<?php if ($config['cf_req_addr']) { ?><strong class="sound_only">필수</strong><?php }  ?>
	                <label for="reg_mb_zip" class="sound_only">우편번호<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
	                <input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input twopart_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6"  placeholder="우편번호">
	                <button type="button" class="btn_frmline" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button><br>
	                <input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input frm_address full_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="50"  placeholder="기본주소">
	                <label for="reg_mb_addr1" class="sound_only">기본주소<?php echo $config['cf_req_addr']?'<strong> 필수</strong>':''; ?></label><br>
	                <input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="frm_input frm_address full_input" size="50" placeholder="상세주소">
	                <label for="reg_mb_addr2" class="sound_only">상세주소</label>
	                <br>
	                <input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="frm_input frm_address full_input" size="50" readonly="readonly" placeholder="참고항목">
	                <label for="reg_mb_addr3" class="sound_only">참고항목</label>
	                <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">
	            </li>
	            <?php }  ?>
	        </ul>
	        <div class="button-ver">    
	            <div id="next2">다음으로</div>
	            <div id="prev2">이전으로</div>
            </div>
	    </div>
-->
	
<!--
	    <div id="reg3" class="tbl_frm01 tbl_wrap register_form_inner">
	        <h2>추가정보 입력</h2>
	        <ul>
	            <?php if ($config['cf_use_signature']) {  ?>
	            <li>
	                <label for="reg_mb_signature">서명<?php if ($config['cf_req_signature']){ ?><strong class="sound_only">필수</strong><?php } ?></label>
	                <textarea name="mb_signature" id="reg_mb_signature" <?php echo $config['cf_req_signature']?"required":""; ?> class="<?php echo $config['cf_req_signature']?"required":""; ?>"   placeholder="서명"><?php echo $member['mb_signature'] ?></textarea>
	            </li>
	            <?php }  ?>
	             <li>
	                <label for="mb_1">성별 선택<strong class="sound_only">필수</strong></label>
	                <input type="radio" name="mb_1" value="1"<?php echo ($mb['mb_1'] == "남성") ? " checked" : "";?>> 남성 
                    <input type="radio" name="mb_1" value="2"<?php echo ($mb['mb_1'] == "여성") ? " checked" : "";?>> 여성
	            </li>
	            <li>
	                <label for="mb_2">연령 선택<strong class="sound_only">필수</strong></label>
	                <select name="mb_2" id="mb_2">
	                    <?php for($i=1920; $i<=2020; $i++) { ?>
                        <option value="<?php echo $i?>" <?php if($write['mb_2']==$i) {?> selected <?php }?>><?php echo $i ?></option>
                        <?php }?>
	                </select>
	            </li>
	            <li>
	                <label for="mb_3">피부 타입 선택<strong class="sound_only">필수</strong></label>
	                <input type="radio" name="mb_3" value="1"<?php echo ($mb['mb_3'] == "지성") ? " checked" : "";?>> 지성 
                    <input type="radio" name="mb_3" value="2"<?php echo ($mb['mb_3'] == "중성") ? " checked" : "";?>> 중성
                    <input type="radio" name="mb_3" value="3"<?php echo ($mb['mb_3'] == "건성") ? " checked" : "";?>> 건성
                    <input type="radio" name="mb_3" value="4"<?php echo ($mb['mb_3'] == "복합성") ? " checked" : "";?>> 복합성
	            </li>
	            <li class="chk_box">
	                <label for="mb_4">피부 고민<strong class="sound_only">필수</strong></label>
	                
	                <input type="checkbox" name="mb_4" value="1"<?php echo ($mb['mb_4'] == "없음") ? " checked" : "";?>> 없음 
	                <input type="checkbox" name="mb_4" value="2"<?php echo ($mb['mb_4'] == "기미/잡티") ? " checked" : "";?>> 기미/잡티 
	                <input type="checkbox" name="mb_4" value="3"<?php echo ($mb['mb_4'] == "여드름") ? " checked" : "";?>> 여드름 
	                <input type="checkbox" name="mb_4" value="4"<?php echo ($mb['mb_4'] == "아토피") ? " checked" : "";?>> 아토피 
	                <input type="checkbox" name="mb_4" value="5"<?php echo ($mb['mb_4'] == "민감성") ? " checked" : "";?>> 민감성 
	                <input type="checkbox" name="mb_4" value="6"<?php echo ($mb['mb_4'] == "주름/노화") ? " checked" : "";?>> 주름노화
	            </li>
	            <hr>
	            <li>
	                <label for="mb_5">사용중인 화장품을 알려주세요</label>
	                <input type="text" name="mb_5" value="<?php echo get_text($member['mb_5']) ?>" id="mb_5" <?php echo $config['mb_5']?"required":""; ?> class="frm_input full_input <?php echo $config['mb_5']?"required":""; ?>" size="70" maxlength="255" placeholder="제품명을입력해주세요">
	            </li>
	            <?php if ($config['cf_use_profile']) {  ?>
	            <li>
	                <label for="reg_mb_profile">자기소개</label>
	                <textarea name="mb_profile" id="reg_mb_profile" <?php echo $config['cf_req_profile']?"required":""; ?> class="<?php echo $config['cf_req_profile']?"required":""; ?>" placeholder="자기소개"><?php echo $member['mb_profile'] ?></textarea>
	            </li>
	            <?php }  ?>
	
	            <?php if ($config['cf_use_member_icon'] && $member['mb_level'] >= $config['cf_icon_level']) {  ?>
	            <li>
	                <label for="reg_mb_icon" class="frm_label">
	                	회원아이콘
	                	<button type="button" class="tooltip_icon"><i class="fa fa-question-circle-o" aria-hidden="true"></i><span class="sound_only">설명보기</span></button>
	                	<span class="tooltip">이미지 크기는 가로 <?php echo $config['cf_member_icon_width'] ?>픽셀, 세로 <?php echo $config['cf_member_icon_height'] ?>픽셀 이하로 해주세요.<br>
gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_icon_size']) ?>바이트 이하만 등록됩니다.</span>
	                </label>
	                <input type="file" name="mb_icon" id="reg_mb_icon">
	
	                <?php if ($w == 'u' && file_exists($mb_icon_path)) {  ?>
	                <img src="<?php echo $mb_icon_url ?>" alt="회원아이콘">
	                <input type="checkbox" name="del_mb_icon" value="1" id="del_mb_icon">
	                <label for="del_mb_icon">삭제</label>
	                <?php }  ?>
	            
	            </li>
	            <?php }  ?>
	
	            <?php if ($member['mb_level'] >= $config['cf_icon_level'] && $config['cf_member_img_size'] && $config['cf_member_img_width'] && $config['cf_member_img_height']) {  ?>
	            <li class="reg_mb_img_file">
	                <label for="reg_mb_img" class="frm_label">
	                	회원이미지
	                	<button type="button" class="tooltip_icon"><i class="fa fa-question-circle-o" aria-hidden="true"></i><span class="sound_only">설명보기</span></button>
	                	<span class="tooltip">이미지 크기는 가로 <?php echo $config['cf_member_img_width'] ?>픽셀, 세로 <?php echo $config['cf_member_img_height'] ?>픽셀 이하로 해주세요.<br>
	                    gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_img_size']) ?>바이트 이하만 등록됩니다.</span>
	                </label>
	                <input type="file" name="mb_img" id="reg_mb_img">
	
	                <?php if ($w == 'u' && file_exists($mb_img_path)) {  ?>
	                <img src="<?php echo $mb_img_url ?>" alt="회원이미지">
	                <input type="checkbox" name="del_mb_img" value="1" id="del_mb_img">
	                <label for="del_mb_img">삭제</label>
	                <?php }  ?>
	            
	            </li>
	            <?php } ?>

	            <li class="chk_box">
		        	<input type="checkbox" name="mb_mailling" value="1" id="reg_mb_mailling" <?php echo ($w=='' || $member['mb_mailling'])?'checked':''; ?> class="selec_chk">
		            <label for="reg_mb_mailling">
		            	<span></span>
		            	<b class="sound_only">메일링서비스</b>
		            </label>
		            <span class="chk_li">정보 메일을 받겠습니다.</span>
		        </li>
	
				<?php if ($config['cf_use_hp']) { ?>
		        <li class="chk_box">
		            <input type="checkbox" name="mb_sms" value="1" id="reg_mb_sms" <?php echo ($w=='' || $member['mb_sms'])?'checked':''; ?> class="selec_chk">
		        	<label for="reg_mb_sms">
		            	<span></span>
		            	<b class="sound_only">SMS 수신여부</b>
		            </label>        
		            <span class="chk_li">휴대폰 문자메세지를 받겠습니다.</span>
		        </li>
		        <?php } ?>
	
		        <?php if (isset($member['mb_open_date']) && $member['mb_open_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_open_modify'] * 86400)) || empty($member['mb_open_date'])) { // 정보공개 수정일이 지났다면 수정가능 ?>
		        <li class="chk_box">
		            <input type="checkbox" name="mb_open" value="1" id="reg_mb_open" <?php echo ($w=='' || $member['mb_open'])?'checked':''; ?> class="selec_chk">
		      		<label for="reg_mb_open">
		      			<span></span>
		      			<b class="sound_only">정보공개</b>
		      		</label>      
		            <span class="chk_li">다른분들이 나의 정보를 볼 수 있도록 합니다.</span>
		            <button type="button" class="tooltip_icon"><i class="fa fa-question-circle-o" aria-hidden="true"></i><span class="sound_only">설명보기</span></button>
		            <span class="tooltip">
		                정보공개를 바꾸시면 앞으로 <?php echo (int)$config['cf_open_modify'] ?>일 이내에는 변경이 안됩니다.
		            </span>
		            <input type="hidden" name="mb_open_default" value="<?php echo $member['mb_open'] ?>"> 
		        </li>		        
		        <?php } else { ?>
	            <li>
	                정보공개
	                <input type="hidden" name="mb_open" value="<?php echo $member['mb_open'] ?>">
	                <button type="button" class="tooltip_icon"><i class="fa fa-question-circle-o" aria-hidden="true"></i><span class="sound_only">설명보기</span></button>
	                <span class="tooltip">
	                    정보공개는 수정후 <?php echo (int)$config['cf_open_modify'] ?>일 이내, <?php echo date("Y년 m월 j일", isset($member['mb_open_date']) ? strtotime("{$member['mb_open_date']} 00:00:00")+$config['cf_open_modify']*86400:G5_SERVER_TIME+$config['cf_open_modify']*86400); ?> 까지는 변경이 안됩니다.<br>
	                    이렇게 하는 이유는 잦은 정보공개 수정으로 인하여 쪽지를 보낸 후 받지 않는 경우를 막기 위해서 입니다.
	                </span>
	                
	            </li>
	            <?php }  ?>
	
	            <?php
	            //회원정보 수정인 경우 소셜 계정 출력
	            if( $w == 'u' && function_exists('social_member_provider_manage') ){
	                social_member_provider_manage();
	            }
	            ?>
	            
	            <?php if ($w == "" && $config['cf_use_recommend']) {  ?>
	            <li>
	                <label for="reg_mb_recommend" class="sound_only">추천인아이디</label>
	                <input type="text" name="mb_recommend" id="reg_mb_recommend" class="frm_input" placeholder="추천인아이디">
	            </li>
	            <?php }  ?>
	
	            <li class="is_captcha_use">
	                자동등록방지
	                <?php // echo captcha_html(); ?>
	            </li>
	        </ul>
	        
	    </div>
-->
	</div>
	
	</form>
</div>
<div id="terms_popup" class="popup-term">
    <div class="popup-close"></div>
    <div class="popup-inner">
        <h3>이용약관</h3>
        <?php
        $query = "select * from g5_content where co_id = 'provision'";
        $row = sql_fetch($query);
        echo $row['co_content'];
        ?>
    </div>
</div>
<div id="private_popup" class="popup-term">
    <div class="popup-close"></div>
    <div class="popup-inner">
        <h3>개인정보처리방침</h3>
        <?php
        $query2 = "select * from g5_content where co_id = 'privacy'";
         $row2 = sql_fetch($query2);
        echo $row2['co_content'];
        ?>
    </div>
</div>
<!--
<div class="popup-login">
           <div class="close-btn">
                <img src="<?php echo G5_THEME_URL ?>/img/mobile-close.svg" alt="">
            </div>
            <?php echo outlogin("basic"); // 외부 로그인  ?>
        </div>
-->
<script>
$(document).ready(function(){
    var reg2 = $('#reg2');
    var reg3 = $('#reg3');
    reg2.hide();
    reg3.hide();
    
    var termP = $('#term_popup');
    var privP = $('#priv_popup');
    var termPopup = $('#terms_popup');
    var privPopup = $('#private_popup');
    var popClose = $('.popup-close');
    termP.click(function(){
        termPopup.show();
    });
    privP.click(function(){
        privPopup.show();
    });
    popClose.click(function(){
        termPopup.hide();
        privPopup.hide();
    });
});
</script>
<script>
$(document).ready(function(){
    var outLoginBtn = $('.login-btn');
    var outLogin = $('.popup-login');
    var outloginClose = $('.close-btn');
    outLoginBtn.click(function(){
        outLogin.show();
    });
    outloginClose.click(function(){
        outLogin.hide();
    });
});
</script>
<script>
$(document).ready(function(){
    var mbid_val = $('#reg_mb_id').val();
    if(mbid_val.match(/^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/)){
        $('#reg_mb_id').css({border: "2px solid #33CC00 !important"});
    }
});
</script>
<script>
$(function() {
    $("#reg_zip_find").css("display", "inline-block");

    <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
    // 아이핀인증
    $("#win_ipin_cert").click(function() {
        if(!cert_confirm())
            return false;

        var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php";
        certify_win_open('kcb-ipin', url);
        return;
    });

    <?php } ?>
    <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
    // 휴대폰인증
    $("#win_hp_cert").click(function() {
        if(!cert_confirm())
            return false;

        <?php
        switch($config['cf_cert_hp']) {
            case 'kcb':
                $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                $cert_type = 'kcb-hp';
                break;
            case 'kcp':
                $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                $cert_type = 'kcp-hp';
                break;
            case 'lg':
                $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                $cert_type = 'lg-hp';
                break;
            default:
                echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
                echo 'return false;';
                break;
        }
        ?>

        certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
        return;
    });
    <?php } ?>
});

// submit 최종 폼체크
function fregisterform_submit(f)
{
    // 회원아이디 검사
    if (f.w.value == "") {
        var msg = reg_mb_id_check();
        if (msg) {
            alert(msg);
            f.mb_id.select();
            return false;
        }
    }

    if (f.w.value == "") {
        if (f.mb_password.value.length < 8) {
            alert("비밀번호를 8글자 이상 입력하십시오.");
            f.mb_password.focus();
            return false;
        }
    }

    if(f.mb_password.value != f.mb_password_re.value)
    {
        alert("입력하신 비밀번호와 비밀번호확인이 일치하지 않습니다");
        return false;
    }

    if(f.mb_password.value.length<8)
    {
        alert("비밀번호는 문자, 숫자, 특수문자의 조합으로 8 이상으로 입력해주세요.");
        return false;
    }
    if(!f.mb_password.value.match(/([a-zA-Z0-9].*[!,@,#,$,%,^,&,*,?,_,~])|([!,@,#,$,%,^,&,*,?,_,~].*[a-zA-Z0-9])/))
    {
        alert("비밀번호는 문자, 숫자, 특수문자의 조합으로 8 이상으로 입력해주세요.");
        return false;      
    }

//    // 이름 검사
//    if (f.w.value=="") {
//        if (f.mb_name.value.length < 1) {
//            alert("이름을 입력하십시오.");
//            f.mb_name.focus();
//            return false;
//        }
//
//        /*
//        var pattern = /([^가-힣\x20])/i;
//        if (pattern.test(f.mb_name.value)) {
//            alert("이름은 한글로 입력하십시오.");
//            f.mb_name.select();
//            return false;
//        }
//        */
//    }
//
//    <?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
//    // 본인확인 체크
//    if(f.cert_no.value=="") {
//        alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
//        return false;
//    }
//    <?php } ?>

    // 닉네임 검사
    if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
        var msg = reg_mb_nick_check();
        if (msg) {
            alert(msg);
            f.reg_mb_nick.select();
            return false;
        }
    }

//    // E-mail 검사
//    if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
//        var msg = reg_mb_email_check();
//        if (msg) {
//            alert(msg);
//            f.reg_mb_email.select();
//            return false;
//        }
//    }

    <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
    // 휴대폰번호 체크
    var msg = reg_mb_hp_check();
    if (msg) {
        alert(msg);
        f.reg_mb_hp.select();
        return false;
    }
    <?php } ?>

    if (typeof f.mb_icon != "undefined") {
        if (f.mb_icon.value) {
            if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                alert("회원아이콘이 이미지 파일이 아닙니다.");
                f.mb_icon.focus();
                return false;
            }
        }
    }

    if (typeof f.mb_img != "undefined") {
        if (f.mb_img.value) {
            if (!f.mb_img.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                alert("회원이미지가 이미지 파일이 아닙니다.");
                f.mb_img.focus();
                return false;
            }
        }
    }

    if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
        if (f.mb_id.value == f.mb_recommend.value) {
            alert("본인을 추천할 수 없습니다.");
            f.mb_recommend.focus();
            return false;
        }

        var msg = reg_mb_recommend_check();
        if (msg) {
            alert(msg);
            f.mb_recommend.select();
            return false;
        }
    }

    <?php echo chk_captcha_js();  ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

jQuery(function($){
	//tooltip
    $(document).on("click", ".tooltip_icon", function(e){
        $(this).next(".tooltip").fadeIn(400).css("display","inline-block");
    }).on("mouseout", ".tooltip_icon", function(e){
        $(this).next(".tooltip").fadeOut();
    });
});

</script>

<!-- } 회원정보 입력/수정 끝 -->