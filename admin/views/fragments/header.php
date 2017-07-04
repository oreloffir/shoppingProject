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
                <li class="active"><a href="../index.php">HomeAdmin</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories <span class="caret"></span> </a>
                    <ul class="dropdown-menu">
                        <?php foreach($model['categories'] as $category){?>
                            <li><a href="../index.php?category=<?php echo $category['id'];?>"><?php echo $category['category']; ?></a></li>
                        <?php }?>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav" id="addionalUserNavBar">
                <?php
                if(!empty($model['currentUser'])) { ?>
                    <li><a href="../favorites.php" id="navbarFavorites">Favorites</a></li>
                <?php } ?>
                <?php
                if($model[ADMIN]) { ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Admin <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li><a href="./adminEditPost.php">Edit post</a></li>
                            <li><a href="./adminUsers.php">Users</a></li>
                            <li><a href="./adminReports.php">Reports</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
            <ul class="nav navbar-nav navbar-right" id="userNavBar">
                <?php
                if(!empty($model['currentUser'])){?>
                    <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> <?php echo $model['currentUser']['displayName']; ?></a></li>
                    <li><a href="#" id="logoutBtn">Logout <span class="glyphicon glyphicon-log-out"></span></a></li>
                <?php }else{
                    ?>
                    <li><a href="./views/sign_up_view.php">Sign up <span class="glyphicon glyphicon-user"></span></a></li>
                    <li><a href="#" data-toggle="modal" data-target="#popUpWindow">Login <span class="glyphicon glyphicon-log-in"></span></a></li>
                <?php }?>
            </ul>

        </div>
    </div>

    <?php require_once ("../views/fragments/loginModal.php"); ?>

    <script>
        loginController.ajaxPrefix = "../";
    </script>
</nav>