<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (isset($_POST['submit'])) {
    if (!empty($_SESSION['cart'])) {
        foreach ($_POST['quantity'] as $key => $val) {
            if ($val == 0) {
                unset($_SESSION['cart'][$key]);
            } else {
                $_SESSION['cart'][$key]['quantity'] = $val;
            }
        }
        echo "<script>alert('Ваша корзина была обновлена');</script>";
    }
}
// Код для удаления товара из корзины
if (isset($_POST['remove_code'])) {

    if (!empty($_SESSION['cart'])) {
        foreach ($_POST['remove_code'] as $key) {

            unset($_SESSION['cart'][$key]);
        }
        echo "<script>alert('Ваша корзина была обновлена');</script>";
    }
}
// Код для добавления товара в таблицу заказов


if (isset($_POST['ordersubmit'])) {

    if (strlen($_SESSION['login']) == 0) {
        header('location:login.php');
    } else {

        $quantity = $_POST['quantity'];
        $pdd = $_SESSION['pid'];
        $value = array_combine($pdd, $quantity);


        foreach ($value as $qty => $val34) {



            mysqli_query($con, "insert into orders(userId,productId,quantity) values('" . $_SESSION['id'] . "','$qty','$val34')");
            header('location:payment-method.php');
        }
    }
}

// Код для обновления адреса выставления счета
if (isset($_POST['update'])) {
    $baddress = $_POST['billingaddress'];
    $bstate = $_POST['bilingstate'];
    $bcity = $_POST['billingcity'];
    $bpincode = $_POST['billingpincode'];
    $query = mysqli_query($con, "update users set billingAddress='$baddress',billingState='$bstate',billingCity='$bcity',billingPincode='$bpincode' where id='" . $_SESSION['id'] . "'");
    if ($query) {
        echo "<script>alert('Адрес выставления счета был обновлен');</script>";
    }
}


// Код для обновления адреса доставки
if (isset($_POST['shipupdate'])) {
    $saddress = $_POST['shippingaddress'];
    $sstate = $_POST['shippingstate'];
    $scity = $_POST['shippingcity'];
    $spincode = $_POST['shippingpincode'];
    $query = mysqli_query($con, "update users set shippingAddress='$saddress',shippingState='$sstate',shippingCity='$scity',shippingPincode='$spincode' where id='" . $_SESSION['id'] . "'");
    if ($query) {
        echo "<script>alert('Адрес доставки был обновлен');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <!-- Мета -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">

    <title>Моя Корзина</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/green.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css">
    <!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
    <link href="assets/css/lightbox.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/rateit.css">
    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

    <!-- Только для демонстрационных целей. Должно быть удалено на продакшене -->
    <link rel="stylesheet" href="assets/css/config.css">

    <link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
    <link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
    <link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
    <link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
    <link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
    <!-- Только для демонстрационных целей. Должно быть удалено на продакшене : КОНЕЦ -->


    <!-- Иконки/глифы -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Шрифты -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>

    <!-- Иконка -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Поддержка элементов HTML5 и медиазапросов для IE8 : HTML5 shim и Respond.js -->
    <!--[if lt IE 9]>
			<script src="assets/js/html5shiv.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->

</head>

<body class="cnt-home">



    <!-- ============================================== ШАПКА ============================================== -->
    <header class="header-style-1">
        <?php include('includes/top-header.php'); ?>
        <?php include('includes/main-header.php'); ?>
        <?php include('includes/menu-bar.php'); ?>
    </header>
    <!-- ============================================== ШАПКА : КОНЕЦ ============================================== -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="#">Главная</a></li>
                    <li class='active'>Корзина</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row inner-bottom-sm">
                <div class="shopping-cart">
                    <div class="col-md-12 col-sm-12 shopping-cart-table ">
                        <div class="table-responsive">
                            <form name="cart" method="post">
                                <?php
                                if (!empty($_SESSION['cart'])) {
                                ?>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="cart-romove item">Удалить</th>
                                                <th class="cart-description item">Изображение</th>
                                                <th class="cart-product-name item">Название продукта</th>

                                                <th class="cart-qty item">Количество</th>
                                                <th class="cart-sub-total item">Цена за единицу</th>
                                                <th class="cart-sub-total item">Стоимость доставки</th>
                                                <th class="cart-total last-item">Итоговая сумма</th>
                                            </tr>
                                        </thead><!-- /thead -->
                                        <tfoot>
                                            <tr>
                                                <td colspan="7">
                                                    <div class="shopping-cart-btn">
                                                        <span class="">
                                                            <a href="index.php" class="btn btn-upper btn-primary outer-left-xs">Продолжить покупки</a>
                                                            <input type="submit" name="submit" value="Обновить корзину" class="btn btn-upper btn-primary pull-right outer-right-xs">
                                                        </span>
                                                    </div><!-- /.shopping-cart-btn -->
                                                </td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            $pdtid = array();
                                            $sql = "SELECT * FROM products WHERE id IN(";
                                            foreach ($_SESSION['cart'] as $id => $value) {
                                                $sql .= $id . ",";
                                            }
                                            $sql = substr($sql, 0, -1) . ") ORDER BY id ASC";
                                            $query = mysqli_query($con, $sql);
                                            $totalprice = 0;
                                            $totalqunty = 0;
                                            if (!empty($query)) {
                                                while ($row = mysqli_fetch_array($query)) {
                                                    $quantity = $_SESSION['cart'][$row['id']]['quantity'];
                                                    $subtotal = $_SESSION['cart'][$row['id']]['quantity'] * $row['productPrice'] + $row['shippingCharge'];
                                                    $totalprice += $subtotal;
                                                    $_SESSION['qnty'] = $totalqunty += $quantity;

                                                    array_push($pdtid, $row['id']);
                                                    //print_r($_SESSION['pid'])=$pdtid;exit;
                                            ?>

                                                    <tr>
                                                        <td class="romove-item"><input type="checkbox" name="remove_code[]" value="<?php echo htmlentities($row['id']); ?>" /></td>
                                                        <td class="cart-image">
                                                            <a class="entry-thumbnail" href="detail.html">
                                                                <img src="admin/productimages/<?php echo $row['id']; ?>/<?php echo $row['productImage1']; ?>" width="114" height="150" alt="" style='object-fit:cover'>
                                                            </a>
                                                        </td>
                                                        <td class="cart-product-name-info">
                                                            <h4 class='cart-product-description'><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo $row['productName']; ?></a></h4>
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <div class="rating rateit-small"></div>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <?php $rt = mysqli_query($con, "select * from productreviews where productId='" . $row['id'] . "'");
                                                                    $num = mysqli_num_rows($rt); {
                                                                    ?>
                                                                        <div class="reviews">
                                                                            (<?php echo htmlentities($num); ?> Отзывы)
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div><!-- /.row -->

                                                        </td>
                                                        <td class="cart-product-quantity">
                                                            <div class="quant-input">
                                                                <div class="arrows">
                                                                    <div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
                                                                    <div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
                                                                </div>
                                                                <input type="text" value="<?php echo $_SESSION['cart'][$row['id']]['quantity']; ?>" name="quantity[<?php echo $row['id']; ?>]">
                                                            </div>
                                                        </td>
                                                        <td class="cart-product-sub-total"><span class="cart-sub-total-price"><?php echo "₸" . "" . $row['productPrice']; ?>.00</span></td>
                                                        <td class="cart-product-sub-total"><span class="cart-sub-total-price"><?php echo "₸" . "" . $row['shippingCharge']; ?>.00</span></td>

                                                        <td class="cart-product-grand-total"><span class="cart-grand-total-price"><?php echo "₸" . "" . ($subtotal); ?>.00</span></td>
                                                    </tr>

                                            <?php }
                                            }
                                            $_SESSION['pid'] = $pdtid;
                                            ?>
                                        </tbody><!-- /tbody -->
                                    </table><!-- /table -->
                        </div>
                    </div><!-- /.shopping-cart-table -->

                    <div class="col-md-4 col-sm-12 estimate-ship-tax">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <span class="estimate-title">Адрес выставления счета</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <?php $qry = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
                                            while ($rt = mysqli_fetch_array($qry)) {
                                            ?>

                                                <div class="form-group">
                                                    <label class="info-title" for="Billing Address">Адрес выставления счета<span>*</span></label>
                                                    <textarea class="form-control unicase-form-control text-input" name="billingaddress" required="required"><?php echo $rt['billingAddress']; ?></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label class="info-title" for="Billing State ">Область выставления счета<span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" id="bilingstate" name="bilingstate" value="<?php echo $rt['billingState']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="Billing City">Город выставления счета<span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" id="billingcity" name="billingcity" value="<?php echo $rt['billingCity']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="Billing Pincode">Индекс выставления счета<span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" id="billingpincode" name="billingpincode" value="<?php echo $rt['billingPincode']; ?>" required>
                                                </div>
                                                <button type="submit" name="update" class="btn-upper btn btn-primary checkout-page-button">Обновить</button>
                                            <?php } ?>
                                        </div>

                                    </td>
                                </tr>
                            </tbody><!-- /tbody -->
                        </table><!-- /table -->
                    </div>

                    <div class="col-md-4 col-sm-12 estimate-ship-tax">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <span class="estimate-title">Адрес доставки</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <?php $qry = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
                                            while ($rt = mysqli_fetch_array($qry)) {
                                            ?>

                                                <div class="form-group">
                                                    <label class="info-title" for="Shipping Address">Адрес доставки<span>*</span></label>
                                                    <textarea class="form-control unicase-form-control text-input" name="shippingaddress" required="required"><?php echo $rt['shippingAddress']; ?></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label class="info-title" for="Billing State ">Область доставки<span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" id="shippingstate" name="shippingstate" value="<?php echo $rt['shippingState']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="Billing City">Город доставки<span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" id="shippingcity" name="shippingcity" value="<?php echo $rt['shippingCity']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="Billing Pincode">Почтовый индекс<span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" id="shippingpincode" name="shippingpincode" value="<?php echo $rt['shippingPincode']; ?>" required>
                                                </div>
                                                <button type="submit" name="shipupdate" class="btn-upper btn btn-primary checkout-page-button">Обновить</button>
                                            <?php } ?>
                                        </div>

                                    </td>
                                </tr>
                            </tbody><!-- /tbody -->
                        </table><!-- /table -->
                    </div>
                    <div class="col-md-4 col-sm-12 cart-shopping-total">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>

                                        <div class="cart-grand-total">
                                            Итого<span class="inner-left-md"><?php echo $_SESSION['tp'] = "$totalprice"; ?>₸</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead><!-- /thead -->
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="cart-checkout-btn pull-right">
                                            <button type="submit" name="ordersubmit" class="btn btn-primary">ПЕРЕЙТИ К ОПЛАТЕ</button>

                                        </div>
                                    </td>
                                </tr>
                            </tbody><!-- /tbody -->
                        </table><!-- /table -->
                    <?php } else {
                                    echo "Ваша корзина пуста";
                                } ?>
                    </div>
                </div>
                </form>
            </div><!-- /.shopping-cart -->
        </div> <!-- /.row -->

    </div><!-- /.container -->
    </div><!-- /.body-content -->
    <?php include('includes/footer.php'); ?>
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
</body>

</html>