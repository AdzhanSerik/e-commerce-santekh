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
			echo "<script>alert('Товар добавлен в корзину')</script>";
			echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>";
		} else {
			$message = "Неверный идентификатор товара";
		}
	}
}

$pid = intval($_GET['pid']);
if (isset($_GET['pid']) && $_GET['action'] == "wishlist") {
	if (strlen($_SESSION['login']) == 0) {
		header('location:login.php');
	} else {
		mysqli_query($con, "INSERT INTO wishlist(userId,productId) VALUES('" . $_SESSION['id'] . "','$pid')");
		echo "<script>alert('Товар добавлен в избранное');</script>";
		header('location:my-wishlist.php');
	}
}

if (isset($_POST['submit'])) {
	$qty = $_POST['quality'];
	$price = $_POST['price'];
	$value = $_POST['value'];
	$name = $_POST['name'];
	$summary = $_POST['summary'];
	$review = $_POST['review'];
	mysqli_query($con, "INSERT INTO productreviews(productId,quality,price,value,name,summary,review) VALUES('$pid','$qty','$price','$value','$name','$summary','$review')");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keywords" content="MediaCenter, Template, eCommerce">
	<meta name="robots" content="all">
	<title>Детали товара</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/green.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<link rel="stylesheet" href="assets/css/owl.transitions.css">
	<link href="assets/css/lightbox.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/animate.min.css">
	<link rel="stylesheet" href="assets/css/rateit.css">
	<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="assets/css/config.css">

	<link href="assets/css/green.css" rel="alternate stylesheet" title="Зеленый цвет">
	<link href="assets/css/blue.css" rel="alternate stylesheet" title="Синий цвет">
	<link href="assets/css/red.css" rel="alternate stylesheet" title="Красный цвет">
	<link href="assets/css/orange.css" rel="alternate stylesheet" title="Оранжевый цвет">
	<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Темно-зеленый цвет">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">

	<!-- Шрифты -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="assets/images/favicon.ico">
</head>

<body class="cnt-home">

	<header class="header-style-1">

		<!-- ============================================== TOP MENU ============================================== -->
		<?php include('includes/top-header.php'); ?>
		<!-- ============================================== TOP MENU : END ============================================== -->
		<?php include('includes/main-header.php'); ?>
		<!-- ============================================== NAVBAR ============================================== -->
		<?php include('includes/menu-bar.php'); ?>
		<!-- ============================================== NAVBAR : END ============================================== -->

	</header>

	<!-- ============================================== HEADER : END ============================================== -->
	<div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-inner">
				<?php
				$ret = mysqli_query($con, "SELECT category.categoryName AS catname, subCategory.subcategory AS subcatname, products.productName AS pname FROM products JOIN category ON category.id=products.category JOIN subcategory ON subcategory.id=products.subCategory WHERE products.id='$pid'");
				while ($rw = mysqli_fetch_array($ret)) {
				?>

					<ul class="list-inline list-unstyled">
						<li><a href="index.php">Главная</a></li>
						<li><?php echo htmlentities($rw['catname']); ?></a></li>
						<li style='display:inline'><?php echo htmlentities($rw['subcatname']); ?></li>
						<li style='display:inline' class='active'><?php echo htmlentities($rw['pname']); ?></li>
					</ul>
				<?php } ?>
			</div><!-- /.breadcrumb-inner -->
		</div><!-- /.container -->
	</div><!-- /.breadcrumb -->

	<div class="body-content outer-top-xs">
		<div class='container'>
			<div class='row single-product outer-bottom-sm '>
				<div class='col-md-3 sidebar'>
					<div class="sidebar-module-container">

						<!-- ============================================== CATEGORY ============================================== -->
						<div class="sidebar-widget outer-bottom-xs wow fadeInUp">
							<h3 class="section-title">Категория</h3>
							<div class="sidebar-widget-body m-t-10">
								<div class="accordion">
									<?php
									$sql = mysqli_query($con, "SELECT id, categoryName FROM category");
									while ($row = mysqli_fetch_array($sql)) {
									?>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a href="category.php?cid=<?php echo $row['id']; ?>" class="accordion-toggle collapsed">
													<?php echo $row['categoryName']; ?>
												</a>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<!-- ============================================== CATEGORY : END ============================================== -->
						<!-- ============================================== HOT DEALS ============================================== -->

						<!-- ============================================== HOT DEALS : END ============================================== -->
					</div>
				</div><!-- /.sidebar -->

				<?php
				$ret = mysqli_query($con, "SELECT * FROM products WHERE id='$pid'");
				while ($row = mysqli_fetch_array($ret)) {
				?>
					<div class='col-md-9'>
						<div class="row wow fadeInUp">
							<div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
								<div class="product-item-holder size-big single-product-gallery small-gallery">
									<div id="owl-single-product">
										<div class="single-product-gallery-item" id="slide1">
											<a data-lightbox="image-1" data-title="<?php echo htmlentities($row['productName']); ?>" href="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>">
												<img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" width="370" height="350" />
											</a>
										</div>
										<div class="single-product-gallery-item" id="slide1">
											<a data-lightbox="image-1" data-title="<?php echo htmlentities($row['productName']); ?>" href="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>">
												<img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" width="370" height="350" />
											</a>
										</div><!-- /.single-product-gallery-item -->
										<div class="single-product-gallery-item" id="slide2">
											<a data-lightbox="image-1" data-title="Gallery" href="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage2']); ?>">
												<img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage2']); ?>" />
											</a>
										</div><!-- /.single-product-gallery-item -->
										<div class="single-product-gallery-item" id="slide3">
											<a data-lightbox="image-1" data-title="Gallery" href="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage3']); ?>">
												<img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage3']); ?>" />
											</a>
										</div>
									</div><!-- /.single-product-slider -->
									<div class="single-product-gallery-thumbs gallery-thumbs">
										<div id="owl-single-product-thumbnails">
											<div class="item">
												<a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="1" href="#slide1">
													<img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" />
												</a>
											</div>
											<div class="item">
												<a class="horizontal-thumb" data-target="#owl-single-product" data-slide="2" href="#slide2">
													<img class="img-responsive" width="85" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage2']); ?>" />
												</a>
											</div>
											<div class="item">
												<a class="horizontal-thumb" data-target="#owl-single-product" data-slide="3" href="#slide3">
													<img class="img-responsive" width="85" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage3']); ?>" height="200" />
												</a>
											</div>
										</div><!-- /#owl-single-product-thumbnails -->
									</div>
								</div>
							</div>
							<div class='col-sm-6 col-md-7 product-info-block'>
								<div class="product-info">
									<h1 class="name"><?php echo htmlentities($row['productName']); ?></h1>
									<?php
									$rt = mysqli_query($con, "SELECT * FROM productreviews WHERE productId='$pid'");
									$num = mysqli_num_rows($rt);
									?>
									<!-- <div class="rating-reviews m-t-20">
										<div class="row">
											<div class="col-sm-3">
												<div class="rating rateit-small"></div>
											</div>
										</div>
									</div> -->
									<div class="stock-container info-container m-t-10">
										<div class="row">
											<div class="col-sm-3">
												<div class="stock-box">
													<span class="label">Наличие :</span>
												</div>
											</div>
											<div class="col-sm-9">
												<div class="stock-box">
													<span class="value"><?php echo htmlentities($row['productAvailability']); ?></span>
												</div>
											</div>
										</div><!-- /.row -->
									</div>
									<div class="stock-container info-container m-t-10">
										<div class="row">
											<div class="col-sm-3">
												<div class="stock-box">
													<span class="label">Бренд товара :</span>
												</div>
											</div>
											<div class="col-sm-9">
												<div class="stock-box">
													<span class="value"><?php echo htmlentities($row['productCompany']); ?></span>
												</div>
											</div>
										</div><!-- /.row -->
									</div>
									<div class="stock-container info-container m-t-10">
										<div class="row">
											<div class="col-sm-3">
												<div class="stock-box">
													<span class="label">Доставка :</span>
												</div>
											</div>
											<div class="col-sm-9">
												<div class="stock-box">
													<span class="value"><?php
																		if ($row['shippingCharge'] == 0) {
																			echo "Бесплатно";
																		} else {
																			echo htmlentities($row['shippingCharge']);
																		}
																		?></span>
												</div>
											</div>
										</div><!-- /.row -->
									</div>
									<div class="price-container info-container m-t-20">
										<div class="row">
											<div class="col-sm-6">
												<div class="price-box">
													<span class="price">₸. <?php echo htmlentities($row['productPrice']); ?></span>

												</div>
											</div>
											<div class="col-sm-6">
												<div class="favorite-button m-t-10">
													<a class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Избранное" href="product-details.php?pid=<?php echo htmlentities($row['id']) ?>&&action=wishlist">
														<i class="fa fa-heart"></i>
													</a>
												</div>
											</div>
										</div><!-- /.row -->
									</div><!-- /.price-container -->













									<div class="quantity-container info-container">
										<div class="row">
											<div class="col-sm-2" style='margin-right: 25px'>
												<span class="label">Количество: </span>
											</div>
											<div class="col-sm-2">
												<div class="cart-quantity">
													<div class="quant-input">
														<div class="arrows">
															<div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
															<div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
														</div>
														<input type="text" value="1">
													</div>
												</div>
											</div>
											<div class="col-sm-7">
												<?php if ($row['productAvailability'] == 'В наличии') { ?>
													<a href="product-details.php?page=product&action=add&id=<?php echo $row['id']; ?>" class="btn btn-primary">
														<i class="fa fa-shopping-cart inner-right-vs"></i> ДОБАВИТЬ В КОРЗИНУ
													</a>
												<?php } else { ?>
													<div class="action" style="color:red">Нет в наличии</div>
												<?php } ?>
											</div>
										</div><!-- /.row -->
									</div><!-- /.quantity-container -->
								</div><!-- /.product-info -->
							</div><!-- /.col-sm-7 -->
						</div><!-- /.row -->

						<div class="product-tabs inner-bottom-xs wow fadeInUp">
							<div class="row">
								<div class="col-sm-3">
									<ul id="product-tabs" class="nav nav-tabs nav-tab-cell">
										<li class="active"><a data-toggle="tab" href="#description">ОПИСАНИЕ</a></li>
									</ul><!-- /.nav-tabs #product-tabs -->
								</div>
								<div class="col-sm-9">
									<div class="tab-content">
										<div id="description" class="tab-pane in active">
											<div class="product-tab">
												<p class="text"><?php echo $row['productDescription']; ?></p>
											</div>
										</div><!-- /.tab-pane -->
									</div><!-- /.product-tab -->
								</div><!-- /.tab-pane -->
							</div><!-- /.tab-content -->
						</div><!-- /.col -->
					</div><!-- /.row -->
			</div><!-- /.product-tabs -->

		<?php $cid = $row['category'];
					$subcid = $row['subCategory'];
				} ?>
		<!-- ============================================== РЕКОМЕНДУЕМЫЕ ТОВАРЫ ============================================== -->
		<section class="section featured-product wow fadeInUp">
			<h3 class="section-title">Похожие товары</h3>
			<div class="owl-carousel home-owl-carousel upsell-product custom-carousel owl-theme outer-top-xs">
				<?php
				$qry = mysqli_query($con, "select * from products where subCategory='$subcid' and category='$cid'");
				while ($rw = mysqli_fetch_array($qry)) { ?>
					<div class="item item-carousel">
						<div class="products">
							<div class="product">
								<div class="product-image">
									<div class="image">
										<a href="product-details.php?pid=<?php echo htmlentities($rw['id']); ?>">
											<img src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($rw['id']); ?>/<?php echo htmlentities($rw['productImage1']); ?>" width="200vw" height="200vh"  alt="" style='object-fit:cover'>
										</a>
									</div><!-- /.image -->
								</div><!-- /.product-image -->

								<div class="product-info text-left">
									<h3 class="name">
										<a href="product-details.php?pid=<?php echo htmlentities($rw['id']); ?>">
											<?php echo htmlentities($rw['productName']); ?>
										</a>
									</h3>

									<div class="description"></div>
									<div class="product-price">
										<span class="price">
											₸.<?php echo htmlentities($rw['productPrice']); ?>
										</span>

									</div><!-- /.product-price -->
								</div><!-- /.product-info -->
								<div class="cart clearfix animate-effect">
									<div class="action">
										<ul class="list-unstyled">
											<li class="add-cart-button btn-group">
												<button class="btn btn-primary icon" data-toggle="dropdown" type="button">
													<i class="fa fa-shopping-cart"></i>
												</button>
												<a href="product-details.php?page=product&action=add&id=<?php echo $rw['id']; ?>" class="lnk btn btn-primary">Добавить в корзину</a>
											</li>
										</ul>
									</div><!-- /.action -->
								</div><!-- /.cart -->
							</div><!-- /.product -->
						</div><!-- /.products -->
					</div><!-- /.item -->
				<?php } ?>
			</div><!-- /.home-owl-carousel -->
		</section><!-- /.section -->

		<!-- ============================================== РЕКОМЕНДУЕМЫЕ ТОВАРЫ : КОНЕЦ ============================================== -->

		</div><!-- /.col -->
		<div class="clearfix"></div>
	</div>
	<?php include('includes/brands-slider.php'); ?>
	</div>
	</div>
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

	<!-- Для демонстрационных целей – может быть удален на продакшн -->
	<script src="switchstylesheet/switchstylesheet.js"></script>
	<script>
		$(document).ready(function() {
			$(".changecolor").switchstylesheet({
				seperator: "color"
			});
			$('.show-theme-options').click(function() {
				$(this).parent().toggleClass('open');
				return false;
			});
		});

		$(window).bind("load", function() {
			$('.show-theme-options').delay(2000).trigger('click');
		});
	</script>
	<!-- Для демонстрационных целей – может быть удален на продакшн : Конец -->

</body>

</html>