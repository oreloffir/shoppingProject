
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
                <li class="active"><a href="index.php">Home</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories <span class="caret"></span> </a>
                    <ul class="dropdown-menu">
                        <?php foreach($model['categories'] as $category){?>
                        <li><a href="index.php?category=<?php echo $category['id'];?>"><?php echo $category['category']; ?></a></li>
                        <?php }?>
                    </ul>
                </li>
                <?php
                    if(!empty($model['currentUser'])) {
                ?>
                    <li id="navbarFavorites"><a href="favorites.php">Favorites</a></li>
                <?php
                    }
                ?>
                <li><a href="#">Page 3</a></li>
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

            <div class="modal fade" id="popUpWindow">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Header -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="display-4">Login:</h3>

                        </div>

                        <!-- Body -->
                        <div class="modal-header">
                            <form role="form" id="login_form">
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email" name="email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password" name="password">
                                </div>

                                <div class="modal-header">
                                    <button class="btn btn-primary" name="submit" id="submit_action">Login</button>
                                </div>
                            </form>
                        </div>
                        <div id="loginErrors">
                            <!-- Footer (Buttton) -->
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        loginController.init();

    </script>
</nav>