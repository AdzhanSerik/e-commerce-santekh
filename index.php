<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (isset($_GET['action']) && $_GET['action'] == "add") {
    $id = intval($_GET['id']);
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $sql_p = "SELECT * FROM products WHERE id={$id}";
        $query_p = mysqli_query($con, $sql_p);
        if (mysqli_num_rows($query_p) != 0) {
            $row_p = mysqli_fetch_array($query_p);
            $_SESSION['cart'][$row_p['id']] = array("quantity" => 1, "price" => $row_p['productPrice']);
        } else {
            $message = "Неверный ID продукта";
        }
    }
    echo "<script>alert('Продукт был добавлен в корзину')</script>";
    echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>";
}
function getExchangeRate()
{
    $url = "https://api.exchangerate-api.com/v4/latest/USD"; // Используем API для получения курса валют
    $json = file_get_contents($url);
    $data = json_decode($json, true);

    return $data['rates']['KZT']; // Возвращаем курс доллара к тенге
}

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">

    <title>ОПТО МАРКЕТ</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Customizable CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/green.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css">
    <!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
    <link href="assets/css/lightbox.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/rateit.css">
    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

    <!-- Demo Purpose Only. Should be removed in production -->
    <link rel="stylesheet" href="assets/css/config.css">

    <link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
    <link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
    <link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
    <link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
    <link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

</head>

<body class="cnt-home">

    <!-- ============================================== HEADER ============================================== -->
    <header class="header-style-1">
        <?php include('includes/top-header.php'); ?>
        <?php include('includes/main-header.php'); ?>
        <?php include('includes/menu-bar.php'); ?>
    </header>

    <!-- ============================================== HEADER : END ============================================== -->
    <div class="body-content outer-top-xs" id="top-banner-and-menu">
        <div class="container">
            <div class="furniture-container homepage-container">
                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-3 sidebar">
                        <!-- ================================== TOP NAVIGATION ================================== -->
                        <?php include('includes/side-menu.php'); ?>
                        <!-- ================================== TOP NAVIGATION : END ================================== -->
                    </div><!-- /.sidemenu-holder -->

                    <div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
                        <!-- ========================================== SECTION – HERO ========================================= -->

                        <div id="hero" class="homepage-slider3">
                            <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
                                <div class="full-width-slider">
                                    <div class="item" style="background-image: url(https://bigfoto.name/uploads/posts/2021-12/thumbs/1638516771_61-bigfoto-name-p-tema-santekhnika-v-interere-65.jpg);">
                                        <!-- /.container-fluid -->
                                    </div><!-- /.item -->
                                </div><!-- /.full-width-slider -->

                                <div class="full-width-slider">
                                    <div class="item full-width-slider" style="background-image: url(https://img.freepik.com/free-photo/small-bathroom-with-modern-style-ai-generated_23-2150694878.jpg?size=626&ext=jpg&ga=GA1.1.2008272138.1722729600&semt=ais_hybrid);">
                                    </div><!-- /.item -->
                                </div><!-- /.full-width-slider -->

                            </div><!-- /.owl-carousel -->
                        </div>

                        <!-- ========================================= SECTION – HERO : END ========================================= -->
                        <!-- ============================================== INFO BOXES ============================================== -->
                        <div class="info-boxes wow fadeInUp">
                            <div class="info-boxes-inner">
                                <div class="row d-flex">
                                    <div class="col-md-6 col-sm-4 col-lg-4 d-flex">
                                        <div class="info-box flex-fill">
                                            <div class="row">
                                                <div class="col-xs-2">
                                                    <i class="icon fa fa-dollar"></i>
                                                </div>
                                                <div class="col-xs-10">
                                                    <h4 class="info-box-heading green">Выгодность</h4>
                                                </div>
                                            </div>
                                            <h6 class="text">Лучшее качество по доступной цене.</h6>
                                        </div>
                                    </div><!-- .col -->

                                    <div class="hidden-md col-sm-4 col-lg-4 d-flex">
                                        <div class="info-box flex-fill">
                                            <div class="row">
                                                <div class="col-xs-2">
                                                    <i class="icon fa fa-truck"></i>
                                                </div>
                                                <div class="col-xs-10">
                                                    <h4 class="info-box-heading orange">Доставка</h4>
                                                </div>
                                            </div>
                                            <h6 class="text">Бесплатная доставка при заказе на сумму более 600.000</h6>
                                        </div>
                                    </div><!-- .col -->

                                    <div class="col-md-6 col-sm-4 col-lg-4 d-flex">
                                        <div class="info-box flex-fill">
                                            <div class="row">
                                                <div class="col-xs-2">
                                                    <i class="icon fa fa-gift"></i>
                                                </div>
                                                <div class="col-xs-10">
                                                    <h4 class="info-box-heading red">Распродажа</h4>
                                                </div>
                                            </div>
                                            <h6 class="text">Некоторые товары со скидкой до 10%</h6>
                                        </div>
                                    </div><!-- .col -->
                                </div><!-- /.row -->
                            </div><!-- /.info-boxes-inner -->
                        </div><!-- /.info-boxes -->
                        <!-- ============================================== INFO BOXES : END ============================================== -->
                    </div><!-- /.homebanner-holder -->

                </div><!-- /.row -->

                <!-- ============================================== SCROLL TABS ============================================== -->
                <div id="product-tabs-slider" class="scroll-tabs inner-bottom-vs  wow fadeInUp" style="margin-top: 25px">
                    <div class="more-info-tab clearfix">
                        <h3 class="new-product-title pull-left">Рекомендуемые продукты</h3>
                    </div>

                    <div class="tab-content outer-top-xs">
                        <div class="tab-pane in active" id="all">
                            <div class="product-slider">
                                <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="4">
                                    <?php
                                    $exchangeRate = getExchangeRate(); // Получаем курс доллара к тенге

                                    $ret = mysqli_query($con, "select * from products");
                                    while ($row = mysqli_fetch_array($ret)) {
                                        $priceInTenge = $row['productPrice'] * $exchangeRate; // Конвертируем цену в тенге
                                    ?>
                                        <div class="item item-carousel">
                                            <div class="products">
                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image">
                                                            <a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>">
                                                                <img src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" width="250vw" height="250vh" alt="" style='object-fit:cover'>
                                                            </a>
                                                        </div><!-- /.image -->
                                                    </div><!-- /.product-image -->

                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['productName']); ?></a></h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price">
                                                            <span class="price"><?php echo number_format($priceInTenge, 2); ?> ₸.</span>
                                                        </div><!-- /.product-price -->
                                                    </div><!-- /.product-info -->

                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <a href="index.php?action=add&id=<?php echo $row['id']; ?>" class="btn btn-primary icon" data-toggle="tooltip" data-placement="top" title="Добавить в корзину">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </a>
                                                                    <a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>" class="btn btn-primary">Просмотреть</a>
                                                                </li>
                                                            </ul>
                                                        </div><!-- /.action -->
                                                    </div><!-- /.cart -->
                                                </div><!-- /.product -->
                                            </div><!-- /.products -->
                                        </div><!-- /.item -->
                                    <?php } ?>

                                </div><!-- /.owl-carousel -->
                            </div><!-- /.product-slider -->
                        </div><!-- /.tab-pane -->

                        <div class="tab-pane" id="Смесители">
                            <div class="product-slider">
                                <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="4">
                                    <?php
                                    $ret = mysqli_query($con, "select * from products where category='Смесители'");
                                    while ($row = mysqli_fetch_array($ret)) {
                                        # code...
                                    ?>
                                        <div class="item item-carousel">
                                            <div class="products">

                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image">
                                                            <a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>">
                                                                <img src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" style='object-fit:cover' width='100px' height='100px' alt=""></a>
                                                        </div><!-- /.image -->


                                                    </div><!-- /.product-image -->


                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['productName']); ?></a></h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price">
                                                            <span class="price"><?php echo htmlentities($row['productPrice']); ?> ₸.</span>
                                                        </div><!-- /.product-price -->

                                                    </div><!-- /.product-info -->

                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <a href="index.php?action=add&id=<?php echo $row['id']; ?>" class="btn btn-primary icon" data-toggle="tooltip" data-placement="top" title="Добавить в корзину">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </a>
                                                                    <a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>" class="btn btn-primary">Просмотреть</a>
                                                                </li>
                                                            </ul>
                                                        </div><!-- /.action -->
                                                    </div><!-- /.cart -->
                                                </div><!-- /.product -->

                                            </div><!-- /.products -->
                                        </div><!-- /.item -->
                                    <?php } ?>
                                </div><!-- /.owl-carousel -->
                            </div><!-- /.product-slider -->
                        </div><!-- /.tab-pane -->

                        <div class="tab-pane" id="furniture">
                            <div class="product-slider">
                                <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="4">
                                    <?php
                                    $ret = mysqli_query($con, "select * from products where category='Furniture'");
                                    while ($row = mysqli_fetch_array($ret)) {
                                        # code...
                                    ?>
                                        <div class="item item-carousel">
                                            <div class="products">

                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image">
                                                            <a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>">
                                                                <img src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" width="100" height="100" alt=""></a>
                                                        </div><!-- /.image -->


                                                    </div><!-- /.product-image -->


                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['productName']); ?></a></h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price">
                                                            <span class="price"><?php echo htmlentities($row['productPrice']); ?> ₸.</span>
                                                        </div><!-- /.product-price -->

                                                    </div><!-- /.product-info -->

                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <a href="index.php?action=add&id=<?php echo $row['id']; ?>" class="btn btn-primary icon" data-toggle="tooltip" data-placement="top" title="Добавить в корзину">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </a>
                                                                    <a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>" class="btn btn-primary">Просмотреть</a>
                                                                </li>
                                                            </ul>
                                                        </div><!-- /.action -->
                                                    </div><!-- /.cart -->
                                                </div><!-- /.product -->

                                            </div><!-- /.products -->
                                        </div><!-- /.item -->
                                    <?php } ?>
                                </div><!-- /.owl-carousel -->
                            </div><!-- /.product-slider -->
                        </div><!-- /.tab-pane -->

                    </div><!-- /.tab-content -->
                </div><!-- /.scroll-tabs -->
            </div><!-- /.furniture-container -->
        </div><!-- /.container -->
    </div><!-- /.body-content -->

    <!-- ============================================== FOOTER ============================================== -->
    <footer id="footer" class="footer color-bg">
        <?php include('includes/footer.php'); ?>
    </footer>
    <!-- ============================================== FOOTER : END ============================================== -->

    <!-- JavaScripts -->
    <script src="assets/js/jquery-1.11.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.colorbox-min.js"></script>
    <script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
    <script src="assets/js/echo.min.js"></script>
    <script src="assets/js/jquery.easing-1.3.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/jquery.countTo.js"></script>
    <script src="assets/js/jquery.parallax-1.1.3.min.js"></script>
    <script src="assets/js/jquery.prettyPhoto.min.js"></script>
    <script src="assets/js/jquery.customSelect.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/rateit.min.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>

    <script src="assets/js/scripts.js"></script>

</body>

</html>