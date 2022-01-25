<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
    return;
}

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
?>
        </div>  <!-- } .shop-content 끝 -->
	</div>      <!-- } #container 끝 -->
</div>
<!-- } 전체 콘텐츠 끝 -->

<!-- 하단 시작 { -->
<div id="ft">

    <div id="ft_wr">
        
        <div id="ft_company" class="ft_cnt">
	        <div class="ft_info">
	            <ul>
	                <li><p>ParksBeauty</p><p><b>DH Beauty</b></p></li>
	                <li><p>대표</p><p><b>DH</b></p></li>
<!--
	                <li><p>카카오톡/텔레그램</p><p><b>@iddmglobal</b></p></li>
	                <li><p>서버호스팅</p><p><b>Cafe24</b></p></li>
-->
	                <li><p>사업자등록번호</p><p><b>501-31-99941</b></p></li>
	                <li><p>통신판매업 신고번호</p><p><b>2019-서울마포-2048 호</b></p></li>
	                <li><p>이메일</p><p><b>iddmglobal@gmail.com</b></p></li>
	            </ul>
                
			</div>
            <div id="ssl"></div>
	    </div>
       <div id="ft_link" class="ft_cnt">
            <a href="<?php echo get_pretty_url('content', 'company'); ?>">사이트 소개</a>
            <a href="<?php echo get_pretty_url('content', 'provision'); ?>">이용약관</a>
            <a href="<?php echo get_pretty_url('content', 'privacy'); ?>">개인정보처리방침</a>
            <a href="<?php echo get_pretty_url('content', 'email_refuse'); ?>">이메일 무단수집거부</a>
            <a href="#">책임의 한계와 법적고지</a>
<!--            <a href="<?php echo get_device_change_url(); ?>">모바일버전</a>-->
        </div>
        <?php
        //공지사항
        // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
        // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
        // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
       // echo latest('theme/notice', 'notice', 4, 13);
        ?>
        
		<?php //echo visit('theme/basic'); // 접속자집계, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정 ?>
	</div>      
        <!-- <div id="ft_catch"><img src="<?php echo G5_IMG_URL; ?>/ft_logo.png" alt="<?php echo G5_VERSION ?>"></div> -->
<!--        <div id="ssl-copy"><h5>본 사이트는 SSL 보안인증이 완료된 사이트임을 증명합니다</h5></div>-->
        <div id="ft_copy">Copyright &copy; 2021. <b>ParksBeauty.</b> All rights reserved.</div>
    
    
    <button type="button" id="top_btn">
    	<i class="fa fa-arrow-up" aria-hidden="true"></i><span class="sound_only">상단으로</span>
    </button>
    <script>
    $(function() {
        $("#top_btn").on("click", function() {
            $("html, body").animate({scrollTop:0}, '500');
            return false;
        });
    });
    </script>
</div>

<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>
<!-- } 하단 끝 -->

<?php
include_once(G5_THEME_PATH.'/tail.sub.php');
?>
