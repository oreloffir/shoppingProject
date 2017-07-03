<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/27/2017
 * Time: 8:49 PM
 */
?>
<div class="modal fade" id="displayPostModal" role="dialog" postid="">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="postDialogTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4 col-xs-12" id="postDialogSide">
                            <div id="postRankContainer">
                                <div id="postRank" postrank="">
                                    <span class="ranking glyphicon glyphicon-star"></span>
                                    <span class="ranking glyphicon glyphicon-star"></span>
                                    <span class="ranking glyphicon glyphicon-star"></span>
                                    <span class="ranking glyphicon glyphicon-star"></span>
                                    <span class="ranking glyphicon glyphicon-star"></span>
                                </div>
                                <span class="ranking-count"><?php echo lang('POST_DIALOG_BASED_ON'); ?> <span id="postRankingAmount">0</span> <?php echo lang('POST_DIALOG_USERS'); ?></span>
                            </div>
                            <div class="post-dialog-price circle"><span id="postDialogPrice"></span></div>
                            <img src="" class="img-responsive" id="postDialogImage">
                            <a href="#" class="btn btn-success" role="button" id="postDialogUrl"><?php echo lang('POST_DIALOG_BUY'); ?></a>
                            <code id="postDialogCouponCode"></code>
                        </div>

                        <div class="col-md-8 col-xs-12">
                            <div>
                                <div><a href="" id="postDialogDisplayName"></a></div>
                                <div id="postDialogTimeAgo"></div>
                                <div id="postDialogDescription"></div>
                            </div>
                            <div id="postDialogCommentsArea">
                                <div class="center-title-underline"><?php echo lang('POST_DIALOG_COMMENTS'); ?></div>
                                <div class="container-fluid" id="postDialogComments"></div>
                                    <div>
                                        <textarea class="form-control" rows="5" id="postDialogCommentsTA"></textarea>
                                    </div>
                                    <div><a href="#" class="btn btn-primary" id="addCommentBtn"><?php echo lang('POST_DIALOG_ADD_COMMENT'); ?></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-2 col-xs-12 post-dialog-fun-btns">
                            <a class="btn btn-danger btn-gray" id ="favoriteBtn"><span class="glyphicon glyphicon-heart"></span></a>
                            <a class="btn btn-gray" id="editPostBtn" href=""><span class="glyphicon glyphicon-pencil"></span></a>
                            <a class="btn btn-gray" id="reportPostBtn" href=""><span class="glyphicon glyphicon-flag"></span></a>
                        </div>
                        <div class="col-md-9 col-xs-12" id="reportPostDisplayBlock"></div>
                        <div class="col-md-1 col-xs-12"><button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('POST_DIALOG_CLOSE'); ?></button></div>
                    </div>
                    <div class="row">
                        <div id="postDialogErrors" class="col-md-12"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>