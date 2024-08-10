<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Проверка, авторизован ли пользователь
if(strlen($_SESSION['login'])==0) {   
    header('location:login.php');
} else {
    // Код для удаления товара из списка желаемого
    $wid = intval($_GET['del']);
    if(isset($_GET['del'])) {
        $query = mysqli_query($con, "DELETE FROM wishlist WHERE id='$wid'");
    }

    // Код для добавления товара в корзину
    if(isset($_GET['action']) && $_GET['action'] == "add") {
        $id = intval($_GET['id']);
        $query = mysqli_query($con, "DELETE FROM wishlist WHERE productId='$id'");
        if(isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $sql_p = "SELECT * FROM products WHERE id={$id}";
            $query_p = mysqli_query($con, $sql_p);
            if(mysqli_num_rows($query_p) != 0) {
                $row_p = mysqli_fetch_array($query_p);
                $_SESSION['cart'][$row_p['id']] = array("quantity" => 1, "price" => $row_p['productPrice']);    
                header('location:my-wishlist.php');
            } else {
                $message = "ID продукта некорректен";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">

    <title>Мой список желаемого</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!-- Пользовательский CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/green.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css">
    <!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
    <link href="assets/css/lightbox.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/rateit.css">
    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

    <!-- Для демонстрационных целей. Удалить в производственной версии -->
    <link rel="stylesheet" href="assets/css/config.css">

    <link href="assets/css/green.css" rel="alternate stylesheet" title="Зеленый цвет">
    <link href="assets/css/blue.css" rel="alternate stylesheet" title="Синий цвет">
    <link href="assets/css/red.css" rel="alternate stylesheet" title="Красный цвет">
    <link href="assets/css/orange.css" rel="alternate stylesheet" title="Оранжевый цвет">
    <link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Темно-зеленый цвет">
    <!-- Для демонстрационных целей. Удалить в производственной версии : КОНЕЦ -->

    <!-- Иконки/Глифы -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Шрифты --> 
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="assets/images/favicon.ico">
</head>
<body class="cnt-home">
<header class="header-style-1">

    <!-- ============================================== ТОП МЕНЮ ============================================== -->
    <?php include('includes/top-header.php');?>
    <!-- ============================================== ТОП МЕНЮ : КОНЕЦ ============================================== -->
    <?php include('includes/main-header.php');?>
    <!-- ============================================== НАВИГАЦИОННАЯ ПАНЕЛЬ ============================================== -->
    <?php include('includes/menu-bar.php');?>
    <!-- ============================================== НАВИГАЦИОННАЯ ПАНЕЛЬ : КОНЕЦ ============================================== -->

</header>

<!-- ============================================== ШАПКА : КОНЕЦ ============================================== -->
<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="home.html">Главная</a></li>
                <li class='active'>Список желаемого</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content outer-top-bd">
    <div class="container">
        <div class="my-wishlist-page inner-bottom-sm">
            <div class="row">
                <div class="col-md-12 my-wishlist">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="4">Мой список желаемого</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$ret = mysqli_query($con, "SELECT products.productName AS pname, products.productImage1 AS pimage, products.productPrice AS pprice, wishlist.productId AS pid, wishlist.id AS wid 
    FROM wishlist 
    JOIN products ON products.id = wishlist.productId 
    WHERE wishlist.userId = '".$_SESSION['id']."'");
$num = mysqli_num_rows($ret);
if($num > 0) {
    while ($row = mysqli_fetch_array($ret)) {
?>
                                <tr>
                                    <td class="col-md-2">
                                        <img src="admin/productimages/<?php echo htmlentities($row['pid']);?>/<?php echo htmlentities($row['pimage']);?>" alt="<?php echo htmlentities($row['pname']);?>" width="60" height="100">
                                    </td>
                                    <td class="col-md-6">
                                        <div class="product-name">
                                            <a href="product-details.php?pid=<?php echo htmlentities($pd = $row['pid']);?>"><?php echo htmlentities($row['pname']);?></a>
                                        </div>
<?php 
$rt = mysqli_query($con, "SELECT * FROM productreviews WHERE productId='$pd'");
$num = mysqli_num_rows($rt);
if($num > 0) {
?>
                                        <div class="rating">
                                            <i class="fa fa-star rate"></i>
                                            <i class="fa fa-star rate"></i>
                                            <i class="fa fa-star rate"></i>
                                            <i class="fa fa-star rate"></i>
                                            <i class="fa fa-star non-rate"></i>
                                            <span class="review">( <?php echo htmlentities($num);?> Отзывы )</span>
                                        </div>
<?php } ?>
                                        <div class="price">₸. 
                                            <?php echo htmlentities($row['pprice']);?>.00
                                            <span>$900.00</span>
                                        </div>
                                    </td>
                                    <td class="col-md-2">
                                        <a href="my-wishlist.php?page=product&action=add&id=<?php echo $row['pid']; ?>" class="btn-upper btn btn-primary">Добавить в корзину</a>
                                    </td>
                                    <td class="col-md-2 close-btn">
                                        <a href="my-wishlist.php?del=<?php echo htmlentities($row['wid']);?>" onClick="return confirm('Вы уверены, что хотите удалить?')" class=""><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
<?php 
    } 
} else {
?>
                                <tr>
                                    <td style="font-size: 18px; font-weight:bold ">Ваш список желаемого пуст</td>
                                </tr>
<?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.sigin-in-->
            <?php include('includes/brands-slider.php');?>
        </div>
    </div>
<?php include('includes/footer.php');?>

<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/echo.min.js"></script>
<script src="assets/js/jquery.easing-1.3.min.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/jquery.rateit.min.js"></script>
<script type="text/javascript" src="assets/js/lightbox.min.js"></script>
<script src="assets/js/bootstrap-select.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/scripts.js"></script>

<!-- Для демонстрационных целей – можно удалить в производственной версии -->
<script src="switchstylesheet/switchstylesheet.js"></script>
<script>
    $(document).ready(function(){ 
        $(".changecolor").switchstylesheet({ seperator: "color" });
        $('.show-theme-options').click(function(){
            $(this).parent().toggleClass('open');
            return false;
        });
    });

    $(window).bind("load", function() {
       $('.show-theme-options').delay(2000).trigger('click');
    });
</script>
</body>
</html>
<?php } ?>
