<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

add_javascript('<script src="'.G5_JS_URL.'/owlcarousel/owl.carousel.min.js"></script>', 10);
add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/owlcarousel/owl.carousel.css">', 0);
?>
<script>
$(document).ready(function(){
    var outLoginBtn = $('.login-btn');
    var outLogin = $('.popup-login');
    outLoginBtn.click(function(){
        outLogin.fadeToggle();
    })
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
            <li><a href="<?php echo G5_BBS_URL ?>/register.php">회원가입</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/login.php">로그인</a></li>
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
                      <ul class="sub">
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
<?php } ?>
<script>
jQuery(function ($){
	$(".btn_member_mn").on("click", function() {
        $(".member_mn").toggle();
        $(".btn_member_mn").toggleClass("btn_member_mn_on");
    });
    
    var active_class = "btn_sm_on",
        side_btn_el = "#quick .btn_sm",
        quick_container = ".qk_con";

    $(document).on("click", side_btn_el, function(e){
        e.preventDefault();

        var $this = $(this);
        
        if (!$this.hasClass(active_class)) {
            $(side_btn_el).removeClass(active_class);
            $this.addClass(active_class);
        }

        if( $this.hasClass("btn_sm_cl1") ){
            $(".side_mn_wr1").show();
        } else if( $this.hasClass("btn_sm_cl2") ){
            $(".side_mn_wr2").show();
        } else if( $this.hasClass("btn_sm_cl3") ){
            $(".side_mn_wr3").show();
        } else if( $this.hasClass("btn_sm_cl4") ){
            $(".side_mn_wr4").show();
        }
    }).on("click", ".con_close", function(e){
        $(quick_container).hide();
        $(side_btn_el).removeClass(active_class);
    });

    $(document).mouseup(function (e){
        var container = $(quick_container),
            mn_container = $(".shop_login");
        if( container.has(e.target).length === 0){
            container.hide();
            $(side_btn_el).removeClass(active_class);
        }
        if( mn_container.has(e.target).length === 0){
            $(".member_mn").hide();
            $(".btn_member_mn").removeClass("btn_member_mn_on");
        }
    });

    $("#top_btn").on("click", function() {
        $("html, body").animate({scrollTop:0}, '500');
        return false;
    });
});
</script>
<?php
    $wrapper_class = array();
    if( defined('G5_IS_COMMUNITY_PAGE') && G5_IS_COMMUNITY_PAGE ){
        $wrapper_class[] = 'is_community';
    }
?>
<!-- 전체 콘텐츠 시작 { -->
<div id="wrapper" class="<?php echo implode(' ', $wrapper_class); ?> bh_wrap">
    <!-- #container 시작 { -->
    <div class="page-w">

        <?php if(defined('_INDEX_')) { ?>
        <div id="aside">
            <?php include_once(G5_SHOP_SKIN_PATH.'/boxcategory.skin.php'); // 상품분류 ?>
            <?php if($default['de_type4_list_use']) { ?>
            <!-- 인기상품 시작 { -->
            <section id="side_pd">
                <h2><a href="<?php echo shop_type_url('4'); ?>">인기상품</a></h2>
                <?php
                $list = new item_list();
                $list->set_type(4);
                $list->set_view('it_id', false);
                $list->set_view('it_name', true);
                $list->set_view('it_basic', false);
                $list->set_view('it_cust_price', false);
                $list->set_view('it_price', true);
                $list->set_view('it_icon', false);
                $list->set_view('sns', false);
                $list->set_view('star', true);
                echo $list->run();
                ?>
            </section>
            <!-- } 인기상품 끝 -->
            <?php } ?>
            
            <?php echo display_banner('왼쪽', 'boxbanner.skin.php'); ?>
            <?php echo poll('theme/shop_basic'); // 설문조사 ?>
        </div>
        <?php } // end if ?>
        <?php
            $content_class = array('shop-content');
            if( isset($it_id) && isset($it) && isset($it['it_id']) && $it_id === $it['it_id']){
                $content_class[] = 'is_item';
            }
            if( defined('IS_SHOP_SEARCH') && IS_SHOP_SEARCH ){
                $content_class[] = 'is_search';
            }
            if( defined('_INDEX_') && _INDEX_ ){
                $content_class[] = 'is_index';
            }
        ?>
        <!-- .shop-content 시작 { -->
        <div class="<?php echo implode(' ', $content_class); ?>">
<!--            <?php if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><div id="wrapper_title"><?php echo $g5['title'] ?></div><?php } ?>-->
            <!-- 글자크기 조정 display:none 되어 있음 시작 { -->
<!--
            <div id="text_size">
                <button class="no_text_resize" onclick="font_resize('container', 'decrease');">작게</button>
                <button class="no_text_resize" onclick="font_default('container');">기본</button>
                <button class="no_text_resize" onclick="font_resize('container', 'increase');">크게</button>
            </div>
-->
            <!-- } 글자크기 조정 display:none 되어 있음 끝 -->