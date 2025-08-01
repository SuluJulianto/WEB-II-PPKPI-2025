<?php
session_start();
include 'admin/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="fe/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="fe/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="fe/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="fe/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="fe/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="fe/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="fe/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="fe/css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <!-- <div id="preloder">
        <div class="loader"></div>
    </div> -->

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="img/logo.png" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
            </ul>
            <div class="header__cart__price">item: <span>$150.00</span></div>
        </div>
        <div class="humberger__menu__widget">
            <div class="header__top__right__language">
                <img src="img/language.png" alt="">
                <div>English</div>
                <span class="arrow_carrot-down"></span>
                <ul>
                    <li><a href="#">Spanis</a></li>
                    <li><a href="#">English</a></li>
                </ul>
            </div>
            <div class="header__top__right__auth">
                <a href="#"><i class="fa fa-user"></i> Login</a>
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="./index.html">Home</a></li>
                <li><a href="./shop-grid.html">Shop</a></li>
                <li><a href="#">Pages</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="./shop-details.html">Shop Details</a></li>
                        <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                        <li><a href="./checkout.html">Check Out</a></li>
                        <li><a href="./blog-details.html">Blog Details</a></li>
                    </ul>
                </li>
                <li><a href="./blog.html">Blog</a></li>
                <li><a href="./contact.html">Contact</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                <li>Free Shipping for all Order of $99</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <?php include 'inc/header.php'; ?>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <?php $pg = isset($_GET['pg']) ? $_GET['pg'] : '' ?>
    <section class="hero <?php echo ($pg) ? 'hero-normal' : '' ?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>All departments</span>
                        </div>
                        <ul>
                            <li><a href="#">Fresh Meat</a></li>
                            <li><a href="#">Vegetables</a></li>
                            <li><a href="#">Fruit & Nut Gifts</a></li>
                            <li><a href="#">Fresh Berries</a></li>
                            <li><a href="#">Ocean Foods</a></li>
                            <li><a href="#">Butter & Eggs</a></li>
                            <li><a href="#">Fastfood</a></li>
                            <li><a href="#">Fresh Onion</a></li>
                            <li><a href="#">Papayaya & Crisps</a></li>
                            <li><a href="#">Oatmeal</a></li>
                            <li><a href="#">Fresh Bananas</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="#">
                                <div class="hero__search__categories">
                                    All Categories
                                    <span class="arrow_carrot-down"></span>
                                </div>
                                <input type="text" placeholder="What do yo u need?">
                                <button type="submit" class="site-btn">SEARCH</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>+65 11.188.888</h5>
                                <span>support 24/7 time</span>
                            </div>
                        </div>
                    </div>
                    <?php if (!$pg): ?>
                        <div class="hero__item set-bg" data-setbg="fe/img/hero/banner.jpg">
                            <div class="hero__text">
                                <span>FRUIT FRESH</span>
                                <h2>Vegetable <br />100% Organic</h2>
                                <p>Free Pickup and Delivery Available</p>
                                <a href="#" class="primary-btn">SHOP NOW</a>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->
    <?php if ($pg): ?>
        <!-- Breadcrumb Section Begin -->
        <section class="breadcrumb-section set-bg" data-setbg="fe/img/breadcrumb.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb__text">
                            <h2>Organi Shop</h2>
                            <div class="breadcrumb__option">
                                <a href="./index.html">Home</a>
                                <span>Shop</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->
    <?php endif ?>

    <!-- main content -->
    <div class="content">
        <!-- ?namaparam=nilai -->
        <?php
        if (isset($_GET['pg'])) {
            if (file_exists("content/" . $_GET['pg'] . '.php')) {
                include 'content/' . $_GET['pg'] . '.php';
            } else {
                include 'content/notfound.php';
            }
        } else {
            include 'content/home.php';
        }
        ?>
    </div>
    <!-- end main content -->


    <!-- Footer Section Begin -->
    <?php include 'inc/footer.php' ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <?php include 'inc/js.php' ?>

    <script>
        $(document).ready(function() {

            $.ajax({
                url: "get_total_cart.php",
                method: "GET",
                dataType: "json",
                success: function(res) {

                    if (res.success == true) {
                        $('.total_item').text(res.total_items)
                    }

                }

            });

            $('.remove-cart').click(function(e) {
                const id = $(this).data('id');
                if (confirm('Apakah anda yakin akan menghapus produk ini??')) {
                    $.ajax({
                        url: "remove_cart.php",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        success: function(res) {
                            if (res.success) {
                                $('.item-row-' + id).fadeOut(300, function() {
                                    $(this).remove();
                                    let formatted = new Intl.NumberFormat('id-ID').format(res.grand_total);
                                    $('#subtotal').text(formatted);
                                    $('#total').text(formatted);
                                });

                            } else {
                                alert(res.message);
                            }
                        }
                    });
                }
            });

            $('.add-to-cart').click(function(e) {
                e.preventDefault();
                let productId = $(this).data('id'),
                    productName = $(this).data("name"),
                    productPrice = $(this).data("price"),
                    productQty = $(this).data("qty");

                $.ajax({
                    url: 'add_to_cart.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        'id': productId,
                        'name': productName,
                        'price': productPrice,
                        'qty': parseInt(1),
                    },
                    success: function(res) {
                        console.log(res);

                        if (res.success == true) {
                            alert(res.message);
                            $('.total_item').text(res.total_items);
                        } else {
                            alert(res.message)
                        }

                    }
                });
            });

        });
        // document.getElementsByClassName()
        // document.querySelector('.add-to-cart');
    </script>


</body>

</html>