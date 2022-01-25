<?php 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<div class="layer-popup-v">
    <h3>댓글</h3>
    <div class="list">
        <ul>
          <?php while($row = sql_fetch_array($rw_cnt)){?>
            <li>
               <div class="thumb">
                   <?php if(!get_member_profile_img($row['mb_id'])){ ?>
                 <img src="<?php echo G5_THEME_IMG_URL ;?>/no_profile.gif" alt="프로필이미지">
                 <?php } else {?>
                 <?php echo get_member_profile_img($row['mb_id'],600,600); ?>
                 <?php } ?>
               </div>
               <div class="content">
                   <h5><?php echo $row['wr_name'];?></h5>
                   <p><?php echo $row['wr_content'];?></p>
                    <h6><?php echo $row['wr_datetime'];?></h6>
                    <ul class="sub-rwv-2">
                        <?php 
                            $query_cmt_list2 = "select * from $write_table where wr_parent = '$wr_parent' and wr_is_comment = '3' and wr_comment = '$wr_comment' and wr_6 = '2' and wr_7 = '{$row['wr_7']}'";
                           $rw_cnt_2 = sql_query($query_cmt_list2);
                           while($row2 = sql_fetch_array($rw_cnt_2)){ ?>
                             <li>
                                 <div class="thumb">
                                     <?php if(!get_member_profile_img($row2['mb_id'])){ ?>
                                   <img src="<?php echo G5_THEME_IMG_URL ;?>/no_profile.gif" alt="프로필이미지">
                                   <?php } else {?>
                                   <?php echo get_member_profile_img($row2['mb_id'],600,600); ?>
                                   <?php } ?>
                                 </div>
                                  <div class="cont-2">
                                      <h5><?php echo $row2['wr_name'];?></h5>
                                      <p><?php echo $row2['wr_content'];?></p>
                                       <h6><?php echo $row2['wr_datetime'];?></h6>
                                  </div>
                             </li> 
                        <?php  }
                        ?>
                    </ul>
                    <div class="rv2-w-button rv2-button-<?php echo $wr_comment;?>-<?php echo $row['wr_7'];?>">댓글쓰기</div>
                    <div class="rv_comment_rm" id="rv-comment-<?php echo $wr_comment;?>-<?php echo $row['wr_7'];?>">
                        <form action="./view_comment_review_reply.php?bo_table=<?php echo $bo_table; ?>&wr_parent=<?php echo $wr_parent; ?>&comment_id=<?php echo $comment_id; ?>&wr_comment=<?php echo $wr_comment;?>" method="post">
                            <input type="hidden" name="w" value="rvc_2">
                            <input type="hidden" name="wr_7" value="<?php echo $row['wr_7'];?>">
                            <input type="hidden" name="mb_id" value="<?php echo $member['mb_id']; ?>">
                            <input type="hidden" name="mb_nick" value="<?php echo $member['mb_nick']; ?>">
                            <textarea name="wr_content" id="" cols="30" rows="10" placeholder="댓글을 남겨보세요."></textarea>
                            <button type="submit" id="btn_submit" accesskey="s" class="btn_submit btn">댓글</button>
                        </form>
                    </div>
                    <script>
                        $(document).ready(function(){
                            $('#rv-comment-<?php echo $wr_comment;?>-<?php echo $row['wr_7'];?>').hide();
                            $('.rv2-button-<?php echo $wr_comment;?>-<?php echo $row['wr_7'];?>').click(function(){
                                $('#rv-comment-<?php echo $wr_comment;?>-<?php echo $row['wr_7'];?>').show();
                            });
                        });
                   </script>
               </div>
            </li>
            <?php }?>
        </ul>
    </div>
    <div class="entry_rev_comment">
    <form name="rev_comment" action="./view_comment_review_reply.php?bo_table=<?php echo $bo_table; ?>&wr_parent=<?php echo $wr_parent; ?>&wr_id=<?php echo $comment_id; ?>&comment_id=<?php echo $comment_id; ?>&wr_comment=<?php echo $wr_comment;?>" method="post">
        <input type="hidden" name="w" value="rvc">
        <input type="hidden" name="mb_id" value="<?php echo $member['mb_id']; ?>">
        <input type="hidden" name="mb_nick" value="<?php echo $member['mb_nick']; ?>">
        <textarea name="wr_content" id="" cols="30" rows="10" placeholder="댓글을 남겨보세요."></textarea>
         <button type="submit" id="btn_submit" accesskey="s" class="btn_submit btn">댓글</button>
    </form>
    </div>
</div>