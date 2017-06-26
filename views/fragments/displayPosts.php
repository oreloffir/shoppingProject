    <div class="container-fluid max-width-1200-center">
    <?php
    $count = 0;
    if(!empty($model['posts'])) {
        $rows = array_chunk($model['posts'], 4);
        foreach ($rows as $row) {
            echo "<div class=\"row\">";
            foreach ($row as $post) { ?>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="post-mini">
                        <div class="post-mini-top"><a
                                    href="profile.php?id=<?php echo $post['publisherId']; ?>"><?php echo $post['displayName']; ?></a><span><?php echo $post['time']; ?></span>
                        </div>
                        <div class="post-mini-title"><a href="#" class="postDialog"
                                                        postId="<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a>
                        </div>
                        <div class="post-mini-main">
                            <div class="post-mini-img"><img
                                        src="./uploads/<?php echo $post['imagePath']; ?>"
                                        class="img-responsive postDialog" postId="<?php echo $post['id']; ?>"></div>
                            <div class="post-mini-img-des"><span><?php echo $post['description']; ?></span></div>
                        </div>
                    </div>
                </div>
    <?php
            }
            echo "</div>";
        }
    }?>
    </div>

    <div class="modal fade" id="displayPostModal" role="dialog" postid="">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="postDialogTitle">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <div>
                                    <div><a href="" id="postDialogDisplayName"></a></div>
                                    <div id="postDialogTimeAgo"></div>
                                    <div id="postDialogDescription"></div>
                                </div>
                                <div id="postDialogCommentsArea">
                                    <div class="center-title-underline">Comments</div>
                                    <div class="container-fluid" id="postDialogComments"></div>
                                    <?php if(!empty($model['currentUser'])){?>
                                        <div>
                                            <textarea class="form-control" rows="5" id="postDialogCommentsTA"></textarea>
                                        </div>
                                        <div><a href="#" class="btn btn-primary" id="addCommentBtn">Add Comment</a></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-4" id="postDialogSide">
                                <div id="postRankContainer">
                                    <div id="postRank" postrank="">
                                        <span class="ranking glyphicon glyphicon-star"></span>
                                        <span class="ranking glyphicon glyphicon-star"></span>
                                        <span class="ranking glyphicon glyphicon-star"></span>
                                        <span class="ranking glyphicon glyphicon-star"></span>
                                        <span class="ranking glyphicon glyphicon-star"></span>
                                    </div>
                                    <span class="ranking-count">based on <span id="postRankingAmount">0</span> users</span>
                                </div>
                                <img src="" class="img-responsive" id="postDialogImage">
                                <a href="#" class="btn btn-success" role="button" id="postDialogUrl">Buy!</a>
                                <code id="postDialogCouponCode"></code>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-2 col-xs-6">
                                <a class="btn btn-danger btn-gray" id ="favoriteBtn"><span class="glyphicon glyphicon-heart"></span></a>
                                <a class="btn btn-gray" id="editPostBtn" href=""><span class="glyphicon glyphicon-pencil"></span></a>
                            </div>
                            <div class="col-md-9 hidden-xs"></div>
                            <div class="col-md-1 col-xs-6"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                        </div>
                        <div class="row">
                            <div id="postDialogErrors" class="col-md-12"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        displayPost.init();
    </script>