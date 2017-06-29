    <div class="container-fluid max-width-1200-center" id="postsDisplayContainer">
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
                        <div class="post-mini-title"><a href="#" class="postDialog" postId="<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></div>
                        <div class="post-mini-main">
                            <div class="post-mini-img"><img
                                        src="./uploads/<?php echo $post['imagePath']; ?>"
                                        class="img-responsive postDialog width-min-fluid" postId="<?php echo $post['id']; ?>"></div>
                            <div class="post-mini-img-des"><span><?php echo substr($post['description'],0,200); ?>..</span></div>
                            <div class="post-mini-img-price circle"><span><?php echo $post['price']; ?>$</span></div>
                        </div>
                    </div>
                </div>
    <?php
            }
            echo "</div>";

        }
    }?>
    </div>
    <?php
        echo "<div id=\"loadMoreInfo\" page-number=\"1\"";
            if(isset($model['postsOrder']))
                echo "posts-order=\"".$model['postsOrder']."\"";
            if(isset($model['pageType']))
                echo "page-type=\"".$model['pageType']."\"";
            if(isset($model['pageType']))
                echo "profile-id=\"".$model['profileId']."\"";
            if(isset($model['categoryId']))
                echo "category=\"".$model['categoryId']."\"";
            echo "></div>";

    require_once("./views/fragments/postModal.php");
?>
    <script>
        displayPost.init();
    </script>