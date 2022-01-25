<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');
?>
<!-- search autocomplete -->
<script src="<?php echo TTO_PLUGIN_URL ?>/autocomplete/jquery.ajaxQueue.js"></script>
<script src="<?php echo TTO_PLUGIN_URL ?>/autocomplete/jquery.autocomplete.js"></script>
<link rel="stylesheet" href="<?php echo TTO_PLUGIN_URL.'/autocomplete/jquery.autocomplete.css' ?>">
<!-- search autocomplete -->
<script>
$().ready(function($) {
function log(event, data, formatted) {
$("<li>").html( !data ? "No match!" : "선택결과: " + formatted).appendTo("#result");
}
$("#sch_stx").autocomplete('<?php echo TTO_PLUGIN_URL ?>/autocomplete/searchdb.php', {
width: 337, // 검색결과 가로너비
selectFirst: false,
// multiple: true,
// multipleSeparator: " ",
// delimiter: /(,|;)\s*/, // regex or character
max: 15,
scroll: false,
autoFill: false,
formatResult: function(row) {
return row[0].replace(/(<.+?>;)/gi, ''); // 이미지 제외 - 전역
}
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
<header class="index-header">
   <div class="header-innder">
    <div id="logo">
        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_THEME_URL ?>/img/logo.svg" alt="<?php echo $config['cf_title']; ?>"></a>
    </div>
        <nav class="nav-login">
            <?php if ($is_member) {  ?>
            <a class="mypg-btn" href="<?php echo G5_SHOP_URL ?>/mypage.php">
                <?php if(!get_member_profile_img($member['mb_id'])){ ?>
                <img src="<?php echo G5_THEME_URL ?>/img/mypage.svg" alt="">
                <?php } else {?>
                <?php echo get_member_profile_img($member['mb_id'],100,100); ?>
                <?php } ?>
            </a>
            <?php }?>
            <ul>        
            <?php if ($is_member) {  ?>
            <li><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
            <?php if ($is_admin) {  ?>
            <li class="tnb_admin"><a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">관리자</a></li>
            <?php }  ?>
            <?php } else {  ?>
            <li><span class="login-btn">로그인</span></li>
            <li><a href="<?php echo G5_BBS_URL ?>/register.php">회원가입</a></li>
            <?php }  ?>

        </ul>
        </nav>
         
        <div id="main-menu-btn">
        </div>
        <div class="main-nav">
            <div class="close-menu">
                
            </div>
            <ul>
                <?php 
                  $sql = " SELECT * FROM {$g5['menu_table']} WHERE me_use = '1' AND LENGTH(me_code) = '2' ORDER BY me_order";
                  $result = sql_query($sql);
                  for($i=0; $i< $row=sql_fetch_array($result); $i++) { ?>
                      <li><a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da"><?php echo $row['me_name'] ?></a>
                      <ul class="sub" id="me-<?php echo $row['me_id'] ?>">
                      <?php 
                         $sql2 = " SELECT * FROM  {$g5['menu_table']} WHERE me_use = '1' AND LENGTH(me_code) = '4' AND SUBSTRING(me_code, 1, 2) = '{$row['me_code']}' ORDER BY me_order";
                         $result2 = sql_query($sql2);
                         for ($k=0; $k < $row2=sql_fetch_array($result2); $k++) { ?>
                            <li><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><?php echo $row2['me_name'] ?></a>
                            <ul class="sub-2">
                            <?php 
                              $sql3 = " SELECT * FROM  {$g5['menu_table']} WHERE me_use = '1' AND LENGTH(me_code) = '6' AND SUBSTRING(me_code, 1, 4) = '{$row2['me_code']}' ORDER BY me_order"; 
                             $result3 = sql_query($sql3);
                             for ($j=0; $j< $row3=sql_fetch_array($result3); $j++) { ?>
                             <li><a href="<?php echo $row3['me_link']; ?>" target="_<?php echo $row3['me_target']; ?>" class="gnb_3da"><?php echo $row3['me_name'] ?></a>
                             <?php  } ?>
                             </ul>
                            </li>
                         <?php  } ?>
                         </ul>
                    </li>     
                <?php  } ?>
            </ul>
        </div>
    </div>
</header>
<div class="popup-login">
           <div class="close-btn">
                <img src="<?php echo G5_THEME_URL ?>/img/mobile-close.svg" alt="">
            </div>
            <?php echo outlogin("basic"); // 외부 로그인  ?>
        </div>
<div id="index-content">
    <h3>뷰티와 관련된 모든걸 한눈에 !<br>
    이젠 <b>Park's Beauty</b>에서</h3>
    <img src="<?php echo G5_THEME_URL ?>/img/index-bg-2.png" alt="">
</div>
<div class="main-search">
            <fieldset id="hd_sch">
                <legend>사이트 내 전체검색</legend>
                <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
                <input type="hidden" name="sfl" value="wr_subject||wr_content">
                <input type="hidden" name="sop" value="and">
                <label for="sch_stx" class="sound_only">검색어 필수</label>
                <input class="main-search" type="text" autocomplete="off" name="stx" id="sch_stx" maxlength="20" placeholder="제품,브랜드,성분,용어등을 검색해보세요">
                <button type="submit" id="sch_submit" value="검색"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
                </form>
                
                <script>
                function fsearchbox_submit(f)
                {
                    if (f.stx.value.length < 2) {
                        alert("검색어는 두글자 이상 입력하십시오.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                    var cnt = 0;
                    for (var i=0; i<f.stx.value.length; i++) {
                        if (f.stx.value.charAt(i) == ' ')
                            cnt++;
                    }

                    if (cnt > 1) {
                        alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    return true;
                }
                </script>

            </fieldset>
                
            
        </div>
              <div class="recent-search">
                   <div class="left-sec">
                    <h5>최근 검색어</h5>
                    <?php echo popular('theme/basic',5,7); // 인기검색어, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정  ?>
                 </div>
                <div class="right-sec">
                   <h5>트렌드 검색</h5>
                   <?php echo popular('theme/basic',5,7); ?>
               </div>
                </div>
               
                <script>
                $(document).ready(function(){
                    var main_search = $('.main-search');
                    var recent_search = $('.recent-search');                   
                    main_search.focus(function(){
                        recent_search.addClass('show');
                    });
                    recent_search.mouseleave(function(){
                        recent_search.removeClass('show');
                    })
                });
                </script>
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>