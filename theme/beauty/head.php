<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>
<script>
$(document).ready(function(){
    var outLoginBtn = $('.login-btn');
    var outLogin = $('.popup-login');
    var outloginClose = $('.close-btn');
    outLoginBtn.click(function(){
        outLogin.fadeToggle();
    });
    outloginClose.click(function(){
        outLogin.fadeToggle();
    });
});
</script>
<!-- 상단 시작 { -->
<script src="<?php echo G5_THEME_URL ?>/js/script.js"></script>
<?php if (!defined("_INDEX_")) { ?>
<header class="header">
   <div class="header-innder">
    <div id="logo">
        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_THEME_URL ?>/img/logo-purple.svg" alt="<?php echo $config['cf_title']; ?>"></a>
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
                      <ul class="sub" id="<?php echo $row['me_id'] ?>">
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
<?php } ?>
<!-- 콘텐츠 시작 { -->
<div id="wrapper"<?php if(defined('_INDEX_')) { ?> class="index-bg" <?php } ?>>
    <?php if (!defined("_INDEX_")) { ?><div class="page-w"><?php } ?>
   
        <?php if (!defined("_INDEX_")|| !$bo_table == "goods_cat") { ?><h2 id="container_title"><span title="<?php echo get_text($g5['title']); ?>"><?php echo get_head_title($g5['title']); ?></span></h2><?php } ?>

