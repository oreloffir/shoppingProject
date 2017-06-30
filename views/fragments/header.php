<nav class="navbar navbar-inverse max-width-1200-center">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="./index.php"><?php echo lang('HEADER_HOME'); ?></a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo lang('HEADER_CATEGORIES'); ?> <span class="caret"></span> </a>
                    <ul class="dropdown-menu">
                        <?php foreach($model['categories'] as $category){?>
                            <li><a href="index.php?category=<?php echo $category['id'];?>"><?php echo $category['category']; ?></a></li>
                        <?php }?>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav" id="addionalUserNavBar">
                <?php
                if(!empty($model['currentUser'])) { ?>
                    <li><a href="favorites.php" id="navbarFavorites"><?php echo lang('HEADER_FAVORITES'); ?></a></li>
                    <li><a href="addPost.php" id="navbarAddPost" class="btn btn-primary"><?php echo lang('HEADER_ADD_POST'); ?></a></li>
                <?php } ?>
                <?php
                if($model[ADMIN]) { ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo lang('HEADER_ADMIN'); ?> <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li><a href="./admin/adminEditPost.php"><?php echo lang('HEADER_ADMIN_EDIT_POST'); ?></a></li>
                            <li><a href="./admin/adminUsers.php"><?php echo lang('HEADER_ADMIN_USERS'); ?></a></li>
                            <li><a href="./admin/adminReports.php"><?php echo lang('HEADER_ADMIN_REPORTS'); ?></a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
            <ul class="nav navbar-nav navbar-right" id="userNavBar">
                <?php
                if(!empty($model['currentUser'])){?>
                    <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> <?php echo $model['currentUser']['displayName']; ?></a></li>
                    <li><a href="#" id="logoutBtn"><?php echo lang('HEADER_LOGOUT'); ?> <span class="glyphicon glyphicon-log-out"></span></a></li>
                <?php }else{
                    ?>
                    <li><a href="./views/sign_up_view.php"><?php echo lang('HEADER_SIGN_UP'); ?><span class="glyphicon glyphicon-user"></span></a></li>
                    <li><a href="#" data-toggle="modal" data-target="#popUpWindow"><?php echo lang('HEADER_LOGIN'); ?> <span class="glyphicon glyphicon-log-in"></span></a></li>
                <?php }?>
            </ul>

        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="popUpWindow">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="display-4"><?php echo lang('HEADER_LOGIN'); ?></h3>

                </div>
                <!-- Body -->
                <div class="modal-header">
                    <form role="form" id="login_form">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="<?php echo lang('HEADER_EMAIL'); ?>" name="email" id="emailField" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="<?php echo lang('HEADER_PASSWORD'); ?>" name="password" id="passwordField" required>
                        </div>

                        <div class="modal-header">
                            <button class="btn btn-primary" name="submit" id="submit_action"><?php echo lang('HEADER_LOGIN'); ?></button>
                        </div>
                    </form>
                </div>
                <div id="loginErrors">
                    <!-- Footer (Buttton) -->
                </div>
            </div>
        </div>
    </div>

    <script>
        loginController.init();
    </script>
</nav>