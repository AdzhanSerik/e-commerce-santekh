<?php 
//session_start();
?>

<div class="top-bar animate-dropdown">
    <div class="container">
        <div class="header-top-inner">
            <div class="cnt-account">
                <ul class="list-unstyled">
                    <?php if(strlen($_SESSION['login'])) { ?>
                        <li><a href="#"><i class="icon fa fa-user"></i>Добро пожаловать - <?php echo htmlentities($_SESSION['username']); ?></a></li>
                    <?php } ?>
                    <li><a href="my-account.php"><i class="icon fa fa-user"></i>Мой аккаунт</a></li>
                    <li><a href="my-wishlist.php"><i class="icon fa fa-heart"></i>Список желаний</a></li>
                    <li><a href="my-cart.php"><i class="icon fa fa-shopping-cart"></i>Моя корзина</a></li>
                    <?php if(strlen($_SESSION['login']) == 0) { ?>
                        <li><a href="login.php"><i class="icon fa fa-sign-in"></i>Логин</a></li>
                    <?php } else { ?>
                        <li><a href="logout.php"><i class="icon fa fa-sign-out"></i>Выйти</a></li>
                    <?php } ?>  
                </ul>
            </div><!-- /.cnt-account -->    
            <div class="clearfix"></div>
        </div><!-- /.header-top-inner -->
    </div><!-- /.container -->
</div><!-- /.header-top -->
