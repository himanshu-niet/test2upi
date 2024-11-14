<?php
require_once("auth/components/main.components.php");
$site_data = site_data();

// Check if installation is complete
// if (!file_exists('install.lock')) {
//     // Redirect to install.php if installation is not complete
//     header('Location: install.php');
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">
<head>
    <meta name="google-site-verification" content="RbKQuc78RAYfE6Fh1_diUHuftzvIQkk4nBFs-f7EE-w" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?=$site_data['title']?></title>
    <link rel="icon" type="image/png" href="<?=$site_data['favicon']?>" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Volkhov:wght@700&amp;display=swap" rel="stylesheet" />
    <link href="home/assets/css/theme.css" rel="stylesheet" />
<style type="text/css">
.plan-box {
    background-color: transparent;
    box-shadow: 0px 1px 15px 1px rgb(69 65 78 / 8%);
    border: none;
}  

.btn-check:focus + .btn-primary, .btn-primary:focus {
    color: #FFFEFE;
    background-color: #066ede;
    border-color: #066ede;
}

.btn-primary:hover {
    color: #FFFEFE;
    background-color: #066ede;
    border-color: #066ede;
}

.btn-primary {
    color: #FFFEFE;
    background-color: #007bff;
    border-color: #007bff;
}
.text-primary {
    color: #007bff !important;
}
.btn-check:checked + .btn-outline-primary, .btn-check:active + .btn-outline-primary, .btn-outline-primary:active, .btn-outline-primary.active, .btn-outline-primary.dropdown-toggle.show {
    color: #FFFEFE;
    background-color: #007bff;
    border-color: #007bff;
}
.btn-outline-primary:hover {
    color: #FFFEFE;
    background-color: #007bff;
    border-color: #007bff;
}
.btn-outline-primary {
    color: #007bff;
    border-color: #007bff;
}
.modal-content {
    border-radius: 0.5rem;
}
</style>    
</head>

<body>
<!-- Modal -->
<div class="modal fade" id="disclaimer" tabindex="-1" aria-labelledby="Disclaimer" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Disclaimer">❗ Disclaimer</h5>
      </div>
      <div class="modal-body">
		  <p>The <?=$site_data['brand']?> does not provide any payment gateway services, UPI accounts, or UPI merchant accounts.</p>
		  <p>We only provide an API to generate a QR code for your UPI ID.</p>
		  <p>We are not involved in any kind of transaction. Please read our terms and conditions before using our service.</p>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" onclick="$('body').html('');">Leave</button>
        <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">I Agree</button>
      </div>
    </div>
  </div>
</div>        
        <!-- ===============================================-->
        <!--    Main Content-->
        <!-- ===============================================-->
        <main class="main" id="top">
            <nav class="navbar navbar-expand-lg navbar-light sticky-top" data-navbar-on-scroll="data-navbar-on-scroll">
                <div class="container">
                    <a class="navbar-brand" href="index">  <h1><?=$site_data['brand']?>  <style>
        h1 {
            font-weight: bold;
            color: pink;
            text-shadow: 2px 2px 2px black;
        }

       
        @media only screen and (max-width: 600px) {
            h1 {
                font-size: 24px; /* Adjust the font size for smaller screens */
            }
        }
    </style></h1>
   <!-- <img src="<?=$site_data['logo']?>" style="width: 185px;" alt="logo"> --></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"> </span>
                    </button>
                    <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item"><a class="nav-link" aria-current="page" href="index">Home</a></li>
                            <li class="nav-item"><a class="nav-link" aria-current="page" href="#feature">Feature</a></li>
                            <li class="nav-item"><a class="nav-link" aria-current="page" href="#pricing">Pricing</a></li>
                            <li class="nav-item"><a class="nav-link" aria-current="page" href="#helpdesk">Help Desk</a></li>
                        </ul>
                        <div class="d-flex ms-lg-4"><a class="btn btn-secondary-outline" href="auth/index">Login</a><a class="btn btn-primary ms-3" href="auth/register">Register</a></div>
                    </div>
                </div>
            </nav>
            <section class="pt-4" style="margin-bottom: -20px;background-image: url(home/upiapp/wave2.svg);background-size: cover;color: white;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-md-start text-center py-5">
                            <h1 class="mb-4 fs-9 fw-bold text-white">UPI QR Code Generator Pay via UPI Feature</h1>
                            <p class="mb-6 lead text-white">
                                Scan and Pay Feature. Accept All UPI Apps.<br>No Transaction Charge. Instant Settlements.<br> Enable Multiple UPI Accounts.
                            </p>
                            <div class="text-center text-md-start">
                                <a class="btn bg-white me-3 btn-lg" href="https://testpg.shopkiing.com/" role="button"><span class="fas fa-bolt me-2"></span> Try for free</a>
                            </div>
                        </div>
                        <div class="col-md-6 text-end"><img class="pt-7 pt-md-0 img-fluid" src="home/upiapp/qrcode.svg" alt="" style="width:400px"/></div>
                    </div>
                </div>
            </section>

            <!-- ============================================-->
            <!-- <section> begin ============================-->
            <section class="mb-4">
                <div class="bg-holder z-index--1 bottom-0 d-none d-lg-block" style="background-image: url(home/upiapp/1-background.webp); opacity: 0.5;"></div>
                <!--/.bg-holder-->

                <div class="container">
                    <h1 class="fs-6 fw-bold text-center">
                        Accepting Payments Made Easy, Simple & FREE!
                    </h1>
                    <p class="text-center" style="font-size: 12px;">The logos below are the property of respective trademark owners. All the below apps support BHIM-UPI.</p>
                    <div class="row p-2">
                        <div class="col-lg-12 col-sm-12 text-center">
                            <img class="mb-3" src="home/upiapp/allupiapps.png" width="70%" alt="upiapp">
                        </div>
                    </div>
                </div>
                <!-- end of .container-->
            </section>
            <!-- <section> close ============================-->
            <!-- ============================================-->

            <!-- ============================================-->
            <!-- <section> begin ============================-->
            <section class="pt-4" id="feature" style=" background-image: url(home/upiapp/wave2.svg); background-size: cover; ">
                <div class="container py-5">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2 class="mb-2 fs-7 fw-bold mb-4 text-white">QR Code Generator Api</h2>
                            <h4 class="fs-1 fw-bold text-white">Multiple UPI Merchant.</h4>
                            <p class="mb-4 fw-medium text-white">
                                Accept Payments Multiple UPI Merchant.
                            </p>
                            <h4 class="fs-1 fw-bold text-white">Transaction Charge</h4>
                            <p class="mb-4 fw-medium text-white">
                                Accept Payments At 0% Transaction Fee.
                            </p>
                            <h4 class="fs-1 fw-bold text-white">Instant Settlements</h4>
                            <p class="mb-4 fw-medium text-white">
                                Settlement Directly to your Bank Account.
                            </p>
                            <h4 class="fs-1 fw-bold text-white">Dynamic UPI QR Code</h4>
                            <p class="mb-4 fw-medium text-white">
                                Accept Payments Directly Dynamic QR Code.
                            </p>
                            <h4 class="fs-1 fw-bold text-white">Direct UPI Intent</h4>
                            <p class="mb-4 fw-medium text-white">
                                Accept Payments Directly Pay via UPI Feature.
                            </p>
                        </div>
                        <div class="col-lg-6"><img class="img-fluid" src="home/upiapp/upi-gateway-3.png" alt="" /></div>
                    </div>
                </div>
                <!-- end of .container-->
            </section>
            <!-- <section> close ============================-->
            <!-- ============================================-->

            <!-- ============================================-->
             <!-- ============================================-->
            <!-- <section> begin ============================-->
            <section class="pt-2 mb-4" id="pricing" style=" background-image: url(home/upiapp/background.svg); background-size: cover; ">
                <div class="container py-5">
                 <div class="mb-4 text-white"> 
                   <h2 class="fs-7 fw-bold text-white">Pricing</h2>
                   <p>Choose Your Suitable Plan</p>
                 </div>
                    <div class="row">                           
                            <?php 
                             foreach (all_plan_data() as $key => $value) {
                            ?>              
                            <div class="col-md-3 mb-4">
                                <div class="card plan-box text-center">
                                    <div class="card-header">
                                        <h4 class="card-title mt-2"><?=$value['name']?></h4>
                                        <h2 class="text-center">₹<?=$value['amount']?></h2>
                                        <p class="card-category"><?=$value['type']?></p>
                                    </div>
                                    <div class="card-body bg-white">
                                        <div class="mb-2 text-primary">
                                            <b style="font-weight:700;font-size:1rem;"><?=$value['limit']?> Transactions</b></div>
                                        <table class="mx-auto" style=" line-height: 0.99em; ">
                                        <tbody>
                                            <tr>
                                                <td><i class="icon-md text-primary me-2" data-feather="check"></i></td>
                                                <td><p>0 Transaction Fee</p></td>
                                            </tr>
                                            <tr>
                                                <td><i class="icon-md text-primary me-2" data-feather="check"></i></td>
                                                <td><p>Realtime Transaction</p></td>
                                            </tr>
                                            <tr>
                                                <td><i class="icon-md text-primary me-2" data-feather="check"></i></td>
                                                <td><p>No Amount Limit</p></td>
                                            </tr>
                                            <tr>
                                                <td><i class="icon-md text-primary me-2" data-feather="check"></i></td>
                                                <td><p><?=$value['account_limit']?> Merchant Account</p></td>
                                            </tr>
                                            <tr>
                                                <td><i class="icon-md text-danger me-2" data-feather="x"></i></td>
                                                <td><p>Dynamic QR Code</p></td>
                                            </tr>
                                            <tr>
                                                <td><i class="icon-md text-danger me-2" data-feather="x"></i></td>
                                                <td><p>Direct UPI Intent</p></td>
                                            </tr>
                                            <tr>
                                                <td><i class="icon-md text-danger me-2" data-feather="x"></i></td>
                                                <td><p>Accept All UPI Apps</p></td>
                                            </tr>
                                            <tr>
                                                <td><i class="icon-md text-primary me-2" data-feather="check"></i></td>
                                                <td><p>24*7 WhatsApp Support</p></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer">
                                      <a href="auth/register" class="btn btn-outline-primary btn-block">Get Started</a>
                                    </div>
                                </div>
                            </div>          
                            <?php } ?>      
                        </div>
                </div>
                <!-- end of .container-->
            </section>
            <!-- <section> close ============================-->
            <!-- ============================================-->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8998013978531731"
     crossorigin="anonymous"></script>
            <!-- ============================================-->
            <!-- <section> begin ============================-->
            <section class="" id="helpdesk">
                <div class="bg-holder z-index--1 bottom-0 d-none d-lg-block background-position-top" style="background-image: url(home/upiapp/helpdesk-bg.png); opacity: 0.5; background-position: top !important ;"></div>
                <!--/.bg-holder-->

                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h1 class="fw-bold mb-4 fs-7">Help Desk</h1>
                            <p class="mb-3 text-info fw-medium">
                                Do you require some help for your project: Integration, Api, Accounts, UPI Merchant, Settlement?
                            </p>
                            <button class="btn btn-primary btn-md" onclick="location.href='<?=$site_data['whatsapp_link']?>'"><i class="fab fa-whatsapp fa-fw fa-lg"></i> Chat our WhatsApp</button>
                        </div>
                    </div>
                </div>
                <!-- end of .container-->
            </section>
            <!-- <section> close ============================-->
            <!-- ============================================-->

            <!-- ============================================-->
           
            <!-- ============================================-->

            <!-- ============================================-->
            <!-- <section> begin ============================-->
            <section class="pb-2 pb-lg-5" style="margin-top:-5%;">
                <div class="container">
                    <div class="row border-top border-top-secondary pt-7">
                        <div class="col-lg-3 col-md-6 mb-4 mb-md-6 mb-lg-0 mb-sm-2 order-1 order-md-1 order-lg-1">  <h1>PG ShopKing  <style>
        h1 {
            font-weight: bold;
            color: pink;
            text-shadow: 2px 2px 2px black;
        }

       
        @media only screen and (max-width: 600px) {
            h1 {
                font-size: 24px; /* Adjust the font size for smaller screens */
            }
        }
    </style></h1>
   <!-- <img src="<?=$site_data['logo']?>" style="width: 185px;" alt="logo"> -->
                            <p>We are happy to introduce you about UPI QR Code Generator Api, UPI QR Code Generator Api is an IT and Fintech services provider company and deals with IT market Requirements and custom software.</p>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 order-3 order-md-3 order-lg-2">
                            <p class="fs-2 mb-lg-4"><b>Our Services</b></p>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><a class="link-900 text-secondary text-decoration-none" href="<?=$site_data['whatsapp_link']?>">Web Development</a></li>
                                <li class="mb-2"><a class="link-900 text-secondary text-decoration-none" href="#">UPI Merchant Api</a></li>
                                <li class="mb-2"><a class="link-900 text-secondary text-decoration-none" href="#">WhatsApp Api</a></li>
                                <li class="mb-2"><a class="link-900 text-secondary text-decoration-none" href="#">Recharge Api</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 order-4 order-md-4 order-lg-3">
                            <p class="fs-2 mb-lg-4"><b>Quick Links</b></p>
                            <ul class="list-unstyled mb-0">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><a class="link-900 text-secondary text-decoration-none" href="auth/register">Register</a></li>
                                <li class="mb-2"><a class="link-900 text-secondary text-decoration-none" href="#feature">Feature</a></li>
                                <li class="mb-2"><a class="link-900 text-secondary text-decoration-none" href="#pricing">Pricing</a></li>
                                <li class="mb-2"><a class="link-900 text-secondary text-decoration-none" href="auth/index">Login</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6 mb-4 mb-lg-0 order-2 order-md-2 order-lg-4">
                            <p class="fs-2 mb-lg-4">Support</p>
                            <p class="mb-2"><?=$site_data['support']?></p>
                            <a href="auth/register" class="btn btn-primary fw-medium py-1">Register Now</a>
                        </div>
                    </div>
                </div>
                <!-- end of .container-->
            </section>
            <!-- <section> close ============================-->
            <!-- ============================================-->

            <!-- ============================================-->
            <!-- <section> begin ============================-->
            <section class="text-center py-0">
                <div class="container">
                    <div class="container border-top py-3">
                        <div class="row justify-content-between">
                            <div class="col-12 col-md-auto mb-1 mb-md-0">
                                <p class="mb-0">&copy; <?=date("Y")?> <?=$site_data['brand']?></p>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- end of .container-->
            </section>
            <!-- <section> close ============================-->
            <!-- ============================================-->
        </main>
        <!-- ===============================================-->
        <!--    End of Main Content-->
        <!-- ===============================================-->

        <!-- ===============================================-->
        <!--    JavaScripts-->
        <!-- ===============================================-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="home/vendors/@popperjs/popper.min.js"></script>
        <script src="home/vendors/bootstrap/bootstrap.min.js"></script>
        <script src="home/vendors/is/is.min.js"></script>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
        <script src="home/vendors/fontawesome/all.min.js"></script>
        <script src="home/assets/js/theme.js"></script>
        <script>
          $( document ).ready(function() {
           $('#disclaimer').modal({backdrop: 'static', keyboard: false})  
           $("#disclaimer").modal("show");
          });
        </script>
    </body>
</html>
