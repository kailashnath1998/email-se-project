<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta name="description" content="Cocoon -Portfolio">
    <meta name="keywords" content="Cocoon , Portfolio">
    <meta name="author" content="Pharaohlab">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- ========== Title ========== -->
    <title> Cocoon -Portfolio</title>
    <!-- ========== Favicon Ico ========== -->
    <!--<link rel="icon" href="fav.ico">-->
    <!-- ========== STYLESHEETS ========== -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
    <script type="text/javascript" language="javascript" src="./js/jquery.min.js"></script>
    <script type="text/javascript" language="javascript" src="./js/apiurl.js"></script>
    <script type="text/javascript" language="javascript" src="./js/bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="./js/sweetalert.min.js"></script>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fonts Icon CSS -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/et-line.css" rel="stylesheet">
    <link href="assets/css/ionicons.min.css" rel="stylesheet">
    <!-- Carousel CSS -->
    <link href="assets/css/slick.css" rel="stylesheet">
    <!-- Magnific-popup -->
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <!-- Custom styles for this template -->
    <link href="assets/css/main.css" rel="stylesheet">
    <script src="/js/compose.js"></script>
</head>

<body>
    <div class="loader">
        <div class="loader-outter"></div>
        <div class="loader-inner"></div>
    </div>

    <div class="body-container container-fluid">
        <a class="menu-btn" href="javascript:void(0)">
            <i class="ion ion-grid"></i>
        </a>
        <div class="row justify-content-center">
            <!--=================== side menu ====================-->
            <div class="col-lg-2 col-md-3 col-12 menu_block">

                <!--logo -->
                <div class="logo_box">
                    <a href="#">
                        <img src="assets/img/logo.png" alt="cocoon">
                    </a>
                </div>
                <!--logo end-->

                <!--main menu -->
                <!--main menu -->
                <div class="side_menu_section">
                    <ul class="menu_nav">
                        <li>
                            <a href="index.html">
                                Inbox
                            </a>
                        </li>
                        <li class="active">
                            <a href="contact.html">
                                Compose
                            </a>
                        </li>
                        <li>
                            <a href="services.html">
                                Sent
                            </a>
                        </li>


                    </ul>
                </div>
                <!--main menu end -->



                <div class="side_menu_bottom">
                    <div class="side_menu_bottom_inner">

                        <div class="copy_right">
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            <p class="copyright">Made by Howdy</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--=================== side menu end====================-->

            <!--=================== content body ====================-->
            <div class="col-lg-10 col-md-9 col-12 body_block  align-content-center">
                <div>
                    <div class="img_card">
                        <div class="row justify-content-center">
                            <div class="col-md-6 col-7 content_section">
                                <!--=================== contact info and form start====================-->
                                <div class="content_box">
                                    <div class="content_box_inner">
                                        <div>
                                            <h3>
                                                Compose Mail
                                            </h3>


                                            <div class="mt75 row justify-content-center">
                                                <div class="col-12">
                                                    <p type="text" id="reply1">{{id}}</p>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="to1" placeholder="E-Mail"
                                                        class="form-control">
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="subject1" placeholder="Subject"
                                                        class="form-control">
                                                </div>
                                                <div class="col-12">
                                                    <textarea placeholder="Massage" id="message1" class="form-control"
                                                        cols="4" rows="4"></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <br>

                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary"
                                                        onclick="send()">Send</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--=================== contact info and form end====================-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--=================== content body end ====================-->
        </div>
    </div>



    <!-- jquery -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <!--slick carousel -->
    <script src="assets/js/slick.min.js"></script>
    <!--Portfolio Filter-->
    <script src="assets/js/imgloaded.js"></script>
    <script src="assets/js/isotope.js"></script>
    <!-- Magnific-popup -->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <!--Counter-->
    <script src="assets/js/jquery.counterup.min.js"></script>
    <!-- WOW JS -->
    <script src="assets/js/wow.min.js"></script>
    <!--map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuahgsm_qfH1F3iywCKzZNMdgsCfnjuUA"></script>
    <!-- Custom js -->
    <script src="assets/js/main.js"></script>
</body>

</html>