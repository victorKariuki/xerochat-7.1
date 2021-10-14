<?php
/*
Theme Name: Demo Theme 
Unique Name: Demo Theme
Theme URI: https://xerochat.com
Author: Xerone IT
Author URI: http://xeroneit.net
Version: 1.0
Description: Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Create a stylish landing page for your business startup and get leads for the offered services with this free HTML landing page template.">
    <meta name="author" content="Inovatik">

    <!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
	<meta property="og:site_name" content="" /> <!-- website name -->
	<meta property="og:site" content="" /> <!-- website link -->
	<meta property="og:title" content=""/> <!-- title shown in the actual shared post -->
	<meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
	<meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
	<meta property="og:url" content="" /> <!-- where do you want your post to link to -->
	<meta property="og:type" content="article" />

    <!-- Website Title -->
    <title><?php echo $this->config->item('product_name'); if($this->config->item('slogan')!='') echo " | ".$this->config->item('slogan')?></title>
    
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,600,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="<?php echo base_url('home/xit_load_files/css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('home/xit_load_files/css/fontawesome-all.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('home/xit_load_files/css/swiper.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('home/xit_load_files/css/magnific-popup.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('home/xit_load_files/css/styles.css'); ?>" rel="stylesheet">
	
	<!-- Favicon  -->
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/img/favicon.png">
</head>
<body data-spy="scroll" data-target=".fixed-top">
    
    <!-- Preloader -->
	<div class="spinner-wrapper">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    <!-- end of preloader -->
    

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <!-- Text Logo - Use this if you don't have a graphic logo -->
        <!-- <a class="navbar-brand logo-text page-scroll" href="index.html"><?php echo $this->config->item("product_short_name"); ?></a> -->

        <!-- Image Logo -->
        <a class="navbar-brand logo-image" href="index.html"><img src="<?php echo base_url();?>assets/img/logo.png" alt="alternative"></a>
        
        <!-- Mobile Menu Toggle Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-awesome fas fa-bars"></span>
            <span class="navbar-toggler-awesome fas fa-times"></span>
        </button>
        <!-- end of mobile menu toggle button -->

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="#header">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="#pricing">Pricing</a>
                </li>
                <?php if ($this->session->userdata('license_type') == 'double')  {?>
                <li>
                    <a href="<?php echo base_url('blog');?>"><?php echo $this->lang->line('Blog'); ?></a>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="<?php echo base_url('home/login'); ?>">Login</a>
                </li>

                <!-- Dropdown Menu -->          
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle page-scroll" href="#about" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">About</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?php echo base_url('home/terms_use'); ?>"><span class="item-text">Terms Conditions</span></a>
                        <div class="dropdown-items-divide-hr"></div>
                        <a class="dropdown-item" href="<?php echo base_url('home/privacy_policy'); ?>"><span class="item-text">Privacy Policy</span></a>
                    </div>
                </li>
                <!-- end of dropdown menu -->

                <li class="nav-item">
                    <a class="nav-link page-scroll" href="#contact">Contact</a>
                </li>
            </ul>
            <span class="nav-item social-icons">
                <?php if($this->config->item('facebook') != '') : ?>
                <span class="fa-stack">
                    <a href="<?php echo $this->config->item('facebook'); ?>">
                        <i class="fas fa-circle fa-stack-2x facebook"></i>
                        <i class="fab fa-facebook-f fa-stack-1x"></i>
                    </a>
                </span>
                <?php endif; ?>
                <?php if($this->config->item('twitter') != '') : ?>
                <span class="fa-stack">
                    <a href="<?php echo $this->config->item('twitter'); ?>">
                        <i class="fas fa-circle fa-stack-2x twitter"></i>
                        <i class="fab fa-twitter fa-stack-1x"></i>
                    </a>
                </span>
                <?php endif; ?>
            </span>
        </div>
    </nav> <!-- end of navbar -->
    <!-- end of navigation -->


    <!-- Header -->
    <header id="header" class="header">
        <div class="header-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="text-container">
                            <h1><span class="turquoise">StartUp Landing</span> Page Template Free</h1>
                            <p class="p-large">Use <?php echo $this->config->item("product_short_name"); ?> free landing page template to promote your business startup and generate leads for the offered services</p>
                            <a class="btn-solid-lg page-scroll" href="<?php echo base_url('home/sign_up'); ?>">Sign Up</a>
                        </div> <!-- end of text-container -->
                    </div> <!-- end of col -->
                    <div class="col-lg-6">
                        <div class="image-container">
                            <img class="img-fluid" src="<?php echo xit_load_images('images/header-teamwork.svg'); ?>" alt="alternative">
                        </div> <!-- end of image-container -->
                    </div> <!-- end of col -->
                </div> <!-- end of row -->
            </div> <!-- end of container -->
        </div> <!-- end of header-content -->
    </header> <!-- end of header -->
    <!-- end of header -->


    <!-- Customers -->
    <div class="slider-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h5>Trusted By</h5>
                    
                    <!-- Image Slider -->
                    <div class="slider-container">
                        <div class="swiper-container image-slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="image-container">
                                        
                                        <img class="img-responsive" src="<?php echo xit_load_images('images/customer-logo-1.png'); ?>" alt="alternative">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="image-container">
                                        <img class="img-responsive" src="<?php echo xit_load_images('images/customer-logo-2.png'); ?>" alt="alternative">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="image-container">
                                        <img class="img-responsive" src="<?php echo xit_load_images('images/customer-logo-3.png'); ?>" alt="alternative">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="image-container">
                                        <img class="img-responsive" src="<?php echo xit_load_images('images/customer-logo-4.png'); ?>" alt="alternative">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="image-container">
                                        <img class="img-responsive" src="<?php echo xit_load_images('images/customer-logo-5.png'); ?>" alt="alternative">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="image-container">
                                        <img class="img-responsive" src="<?php echo xit_load_images('images/customer-logo-6.png'); ?>" alt="alternative">
                                    </div>
                                </div>
                            </div> <!-- end of swiper-wrapper -->
                        </div> <!-- end of swiper container -->
                    </div> <!-- end of slider-container -->
                    <!-- end of image slider -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of slider-1 -->
    <!-- end of customers -->


    <!-- Services -->
    <div id="services" class="cards-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Business Growth Services</h2>
                    <p class="p-heading p-large">We serve small and medium sized companies in all tech related industries with high quality growth services which are presented below</p>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">
                <div class="col-lg-12">

                    <!-- Card -->
                    <div class="card">
                        <img class="card-image" src="<?php echo xit_load_images('images/services-icon-1.svg'); ?>" alt="alternative">
                        <div class="card-body">
                            <h4 class="card-title">Market Analysis</h4>
                            <p>Our team of enthusiastic marketers will analyse and evaluate how your company stacks against the closest competitors</p>
                        </div>
                    </div>
                    <!-- end of card -->

                    <!-- Card -->
                    <div class="card">
                        <img class="card-image" src="<?php echo xit_load_images('images/services-icon-2.svg'); ?>" alt="alternative">
                        <div class="card-body">
                            <h4 class="card-title">Opportunity Scan</h4>
                            <p>Once the market analysis process is completed our staff will search for opportunities that are in reach</p>
                        </div>
                    </div>
                    <!-- end of card -->

                    <!-- Card -->
                    <div class="card">
                        <img class="card-image" src="<?php echo xit_load_images('images/services-icon-3.svg'); ?>" alt="alternative">
                        <div class="card-body">
                            <h4 class="card-title">Action Plan</h4>
                            <p>With all the information in place you will be presented with an action plan that your company needs to follow</p>
                        </div>
                    </div>
                    <!-- end of card -->
                    
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of cards-1 -->
    <!-- end of services -->


    <!-- Details 1 -->
    <div class="basic-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="text-container">
                        <h2>Design And Plan Your Business Growth Steps</h2>
                        <p>Use our staff and our expertise to design and plan your business growth strategy. <?php echo $this->config->item("product_short_name"); ?> team is eager to advise you on the best opportunities that you should look into</p>
                        <a class="btn-solid-reg popup-with-move-anim" href="#details-lightbox-1">LIGHTBOX</a>
                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
                <div class="col-lg-6">
                    <div class="image-container">
                        <img class="img-fluid" src="<?php echo xit_load_images('images/details-1-office-worker.svg'); ?>" alt="alternative">
                    </div> <!-- end of image-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of basic-1 -->
    <!-- end of details 1 -->

    
    <!-- Details 2 -->
    <div class="basic-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="image-container">
                        <img class="img-fluid" src="<?php echo xit_load_images('images/details-2-office-team-work.svg'); ?>" alt="alternative">
                    </div> <!-- end of image-container -->
                </div> <!-- end of col -->
                <div class="col-lg-6">
                    <div class="text-container">
                        <h2>Search For Optimization Wherever Is Possible</h2>
                        <ul class="list-unstyled li-space-lg">
                            <li class="media">
                                <i class="fas fa-check"></i>
                                <div class="media-body">Basically we'll teach you step by step what you need to do</div>
                            </li>
                            <li class="media">
                                <i class="fas fa-check"></i>
                                <div class="media-body">In order to develop your company and reach new heights</div>
                            </li>
                            <li class="media">
                                <i class="fas fa-check"></i>
                                <div class="media-body">Everyone will be pleased from stakeholders to employees</div>
                            </li>
                        </ul>
                        <a class="btn-solid-reg popup-with-move-anim" href="#details-lightbox-2">LIGHTBOX</a>
                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of basic-2 -->
    <!-- end of details 2 -->

    <!-- Details Lightboxes -->
    <!-- Details Lightbox 1 -->
	<div id="details-lightbox-1" class="lightbox-basic zoom-anim-dialog mfp-hide">
        <div class="container">
            <div class="row">
                <button title="Close (Esc)" type="button" class="mfp-close x-button">×</button>
                <div class="col-lg-8">
                    <div class="image-container">
                        <img class="img-fluid" src="<?php echo xit_load_images('images/details-lightbox-1.svg'); ?>" alt="alternative">
                    </div> <!-- end of image-container -->
                </div> <!-- end of col -->
                <div class="col-lg-4">
                    <h3>Design And Plan</h3>
                    <hr>
                    <h5>Core feature</h5>
                    <p>The emailing module basically will speed up your email marketing operations while offering more subscriber control.</p>
                    <p>Do you need to build lists for your email campaigns? It just got easier with <?php echo $this->config->item("product_short_name"); ?>.</p>
                    <ul class="list-unstyled li-space-lg">
                        <li class="media">
                            <i class="fas fa-check"></i><div class="media-body">List building framework</div>
                        </li>
                        <li class="media">
                            <i class="fas fa-check"></i><div class="media-body">Easy database browsing</div>
                        </li>
                        <li class="media">
                            <i class="fas fa-check"></i><div class="media-body">User administration</div>
                        </li>
                        <li class="media">
                            <i class="fas fa-check"></i><div class="media-body">Automate user signup</div>
                        </li>
                        <li class="media">
                            <i class="fas fa-check"></i><div class="media-body">Quick formatting tools</div>
                        </li>
                        <li class="media">
                            <i class="fas fa-check"></i><div class="media-body">Fast email checking</div>
                        </li>
                    </ul>
                    <a class="btn-solid-reg mfp-close page-scroll" href="#request">REQUEST</a> <a class="btn-outline-reg mfp-close as-button" href="#screenshots">BACK</a>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of lightbox-basic -->
    <!-- end of details lightbox 1 -->

    <!-- Details Lightbox 2 -->
	<div id="details-lightbox-2" class="lightbox-basic zoom-anim-dialog mfp-hide">
        <div class="container">
            <div class="row">
                <button title="Close (Esc)" type="button" class="mfp-close x-button">×</button>
                <div class="col-lg-8">
                    <div class="image-container">
                        <img class="img-fluid" src="<?php echo xit_load_images('images/details-lightbox-2.svg'); ?>" alt="alternative">
                    </div> <!-- end of image-container -->
                </div> <!-- end of col -->
                <div class="col-lg-4">
                    <h3>Search To Optimize</h3>
                    <hr>
                    <h5>Core feature</h5>
                    <p>The emailing module basically will speed up your email marketing operations while offering more subscriber control.</p>
                    <p>Do you need to build lists for your email campaigns? It just got easier with <?php echo $this->config->item("product_short_name"); ?>.</p>
                    <ul class="list-unstyled li-space-lg">
                        <li class="media">
                            <i class="fas fa-check"></i><div class="media-body">List building framework</div>
                        </li>
                        <li class="media">
                            <i class="fas fa-check"></i><div class="media-body">Easy database browsing</div>
                        </li>
                        <li class="media">
                            <i class="fas fa-check"></i><div class="media-body">User administration</div>
                        </li>
                        <li class="media">
                            <i class="fas fa-check"></i><div class="media-body">Automate user signup</div>
                        </li>
                        <li class="media">
                            <i class="fas fa-check"></i><div class="media-body">Quick formatting tools</div>
                        </li>
                        <li class="media">
                            <i class="fas fa-check"></i><div class="media-body">Fast email checking</div>
                        </li>
                    </ul>
                    <a class="btn-solid-reg mfp-close page-scroll" href="#request">REQUEST</a> <a class="btn-outline-reg mfp-close as-button" href="#screenshots">BACK</a>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of lightbox-basic -->
    <!-- end of details lightbox 2 -->
    <!-- end of details lightboxes -->



    <?php if(!empty($pricing_table_data)) : ?>
    <!-- Pricing -->
    <div id="pricing" class="cards-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Multiple Pricing Options</h2>
                    <p class="p-heading p-large">We've prepared pricing plans for all budgets so you can get started right away. They're great for small companies and large organizations</p>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">
                <div class="col-lg-12">
                    <?php 
                        $i=0;
                        foreach($pricing_table_data as $pack) :    
                        $i++;   
                    ?>
                    <!-- Card-->
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title"><?php echo $pack["package_name"]; ?></div>
                            <!-- <div class="card-subtitle">Just to see what can be achieved</div> -->
                            <hr class="cell-divide-hr">
                            <div class="price">
                                <span class="currency"><?php echo $curency_icon; ?></span><span class="value"><?php echo $pack["price"]?></span>
                                <div class="frequency"><?php echo $pack["validity"]?> <?php echo $this->lang->line("days"); ?></div>
                            </div>
                            <hr class="cell-divide-hr">
                            <div class="scrollit" style="height: 300px;overflow-y: auto;">
                                <ul class="list-unstyled li-space-lg">
                                    <?php 
                                        $module_ids=$pack["module_ids"];
                                        $monthly_limit=json_decode($pack["monthly_limit"],true);
                                        $module_names_array=$this->basic->execute_query('SELECT module_name,id FROM modules WHERE FIND_IN_SET(id,"'.$module_ids.'") > 0  ORDER BY module_name ASC');

                                        foreach ($module_names_array as $row) : 
                                    ?>
                                    <li class="media">
                                        <i class="fas fa-check"></i>
                                        <div class="media-body">
                                            <?php 
                                                $limit=0;
                                                $limit=$monthly_limit[$row["id"]];

                                                if($limit=="0") 
                                                    $limit2="<b>".$this->lang->line("unlimited")."</b>";
                                                else 
                                                    $limit2=$limit;

                                                if($row["id"]!="1" && $limit!="0") 
                                                    
                                                    $limit2="<b>".$limit2."/".$this->lang->line("month")."</b>";
                                                    echo $this->lang->line($row["module_name"]);

                                                if($row["id"]!="13" && $row["id"]!="14" && $row["id"]!="16") 
                                                    echo " : <b>". $limit2."</b>"."<br>";
                                                else 
                                                    echo "<br>";
                                            ?>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php if($this->config->item('enable_signup_form') != '0') : ?>
                            <div class="button-wrapper">
                                <a class="btn-solid-reg page-scroll" href="<?php echo site_url('home/sign_up'); ?>">Sign Up</a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div> <!-- end of card -->
                    <!-- end of card -->

                    <?php endforeach; ?>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of cards-2 -->
    <!-- end of pricing -->
    <?php endif; ?>


    <!-- Video -->
    <?php if($this->config->item('display_video_block') == '1' || $this->config->item('promo_video') != '') : ?>
    <div class="basic-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Check Out The Video</h2>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">
                <div class="col-lg-12">
                    
                    <!-- Video Preview -->
                    <div class="image-container">
                        <div class="video-wrapper">
                            <?php 
                                $promo_video_link = $this->config->item('promo_video');
                            ?>
                            <a class="popup-youtube" href="<?php echo $promo_video_link; ?>" data-effect="fadeIn">
                                <img class="img-fluid" src="<?php echo xit_load_images('images/video-frame.svg'); ?>" alt="alternative">
                                <span class="video-play-button">
                                    <span></span>
                                </span>
                            </a>
                        </div> <!-- end of video-wrapper -->
                    </div> <!-- end of image-container -->
                    <!-- end of video preview -->

                    <p>This video will show you a case study for one of our <strong>Major Customers</strong> and will help you understand why your startup needs <?php echo $this->config->item("product_short_name"); ?> in this highly competitive market</p>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of basic-3 -->
    <!-- end of video -->
    <?php endif; ?>


    <!-- Testimonials -->
    <div class="slider-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="image-container">
                        <img class="img-fluid" src="<?php echo xit_load_images('images/testimonials-2-men-talking.svg'); ?>" alt="alternative">
                    </div> <!-- end of image-container -->
                </div> <!-- end of col -->
                <div class="col-lg-6">
                    <h2>Testimonials</h2>

                    <!-- Card Slider -->
                    <div class="slider-container">
                        <div class="swiper-container card-slider">
                            <div class="swiper-wrapper">
                            <?php 
                                $customerReview = $this->config->item('customer_review');
                                $ct=0;
                                foreach($customerReview as $singleReview) : 
                                $ct++;
                                $original = $singleReview[2];
                                $base     = base_url();

                                if (substr($original, 0, 4) != 'http') {
                                    $img = $base.$original;
                                } else {
                                   $img = $original;
                                }

                            ?>
                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <div class="card">
                                        <img class="card-image" src="<?php echo $img; ?>" alt="alternative">
                                        <div class="card-body">
                                            <p class="testimonial-text">
                                                <?php echo $str = $singleReview[3]; ?>
                                            </p>
                                            <p class="testimonial-author"><?php echo $singleReview[0]; ?> - <?php echo $singleReview[1]; ?></p>
                                        </div>
                                    </div>
                                </div> <!-- end of swiper-slide -->
                                <!-- end of slide -->
                            <?php endforeach;
                             ?>
                            </div> <!-- end of swiper-wrapper -->
        
                            <!-- Add Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <!-- end of add arrows -->
        
                        </div> <!-- end of swiper-container -->
                    </div> <!-- end of slider-container -->
                    <!-- end of card slider -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of slider-2 -->
    <!-- end of testimonials -->


    <!-- About -->
    <div id="about" class="basic-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>About The Team</h2>
                    <p class="p-heading p-large">Meat our team of specialized marketers and business developers which will help you research new products and launch them in new emerging markets</p>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">
                <div class="col-lg-12">
                    
                    <!-- Team Member -->
                    <div class="team-member">
                        <div class="image-wrapper">
                            <img class="img-fluid" src="<?php echo xit_load_images('images/team-member-1.svg'); ?>" alt="alternative">
                        </div> <!-- end of image-wrapper -->
                        <p class="p-large"><strong>Lacy Whitelong</strong></p>
                        <p class="job-title">Business Developer</p>
                        <span class="social-icons">
                            <span class="fa-stack">
                                <a href="#your-link">
                                    <i class="fas fa-circle fa-stack-2x facebook"></i>
                                    <i class="fab fa-facebook-f fa-stack-1x"></i>
                                </a>
                            </span>
                            <span class="fa-stack">
                                <a href="#your-link">
                                    <i class="fas fa-circle fa-stack-2x twitter"></i>
                                    <i class="fab fa-twitter fa-stack-1x"></i>
                                </a>
                            </span>
                        </span> <!-- end of social-icons -->
                    </div> <!-- end of team-member -->
                    <!-- end of team member -->

                    <!-- Team Member -->
                    <div class="team-member">
                        <div class="image-wrapper">
                            <img class="img-fluid" src="<?php echo xit_load_images('images/team-member-2.svg'); ?>" alt="alternative">
                        </div> <!-- end of image wrapper -->
                        <p class="p-large"><strong>Chris Brown</strong></p>
                        <p class="job-title">Online Marketer</p>
                        <span class="social-icons">
                            <span class="fa-stack">
                                <a href="#your-link">
                                    <i class="fas fa-circle fa-stack-2x facebook"></i>
                                    <i class="fab fa-facebook-f fa-stack-1x"></i>
                                </a>
                            </span>
                            <span class="fa-stack">
                                <a href="#your-link">
                                    <i class="fas fa-circle fa-stack-2x twitter"></i>
                                    <i class="fab fa-twitter fa-stack-1x"></i>
                                </a>
                            </span>
                        </span> <!-- end of social-icons -->
                    </div> <!-- end of team-member -->
                    <!-- end of team member -->

                    <!-- Team Member -->
                    <div class="team-member">
                        <div class="image-wrapper">
                            <img class="img-fluid" src="<?php echo xit_load_images('images/team-member-3.svg'); ?>" alt="alternative">
                        </div> <!-- end of image wrapper -->
                        <p class="p-large"><strong>Sheila Zimerman</strong></p>
                        <p class="job-title">Software Engineer</p>
                        <span class="social-icons">
                            <span class="fa-stack">
                                <a href="#your-link">
                                    <i class="fas fa-circle fa-stack-2x facebook"></i>
                                    <i class="fab fa-facebook-f fa-stack-1x"></i>
                                </a>
                            </span>
                            <span class="fa-stack">
                                <a href="#your-link">
                                    <i class="fas fa-circle fa-stack-2x twitter"></i>
                                    <i class="fab fa-twitter fa-stack-1x"></i>
                                </a>
                            </span>
                        </span> <!-- end of social-icons -->
                    </div> <!-- end of team-member -->
                    <!-- end of team member -->

                    <!-- Team Member -->
                    <div class="team-member">
                        <div class="image-wrapper">
                            <img class="img-fluid" src="<?php echo xit_load_images('images/team-member-4.svg'); ?>" alt="alternative">
                        </div> <!-- end of image wrapper -->
                        <p class="p-large"><strong>Mary Villalonga</strong></p>
                        <p class="job-title">Product Manager</p>
                        <span class="social-icons">
                            <span class="fa-stack">
                                <a href="#your-link">
                                    <i class="fas fa-circle fa-stack-2x facebook"></i>
                                    <i class="fab fa-facebook-f fa-stack-1x"></i>
                                </a>
                            </span>
                            <span class="fa-stack">
                                <a href="#your-link">
                                    <i class="fas fa-circle fa-stack-2x twitter"></i>
                                    <i class="fab fa-twitter fa-stack-1x"></i>
                                </a>
                            </span>
                        </span> <!-- end of social-icons -->
                    </div> <!-- end of team-member -->
                    <!-- end of team member -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of basic-4 -->
    <!-- end of about -->


    <!-- Contact -->
    <div id="contact" class="form-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Contact Information</h2>
                    <ul class="list-unstyled li-space-lg">
                        <li class="address">Don't hesitate to give us a call or send us a contact form message</li>
                        <li><i class="fas fa-map-marker-alt"></i><?php echo $this->config->item('institute_address2'); ?></li>
                        <li><i class="fas fa-phone"></i><a class="turquoise"><?php echo $this->config->item('institute_mobile'); ?></a></li>
                        <li><i class="fas fa-envelope"></i><a class="turquoise"><?php echo $this->config->item('institute_email'); ?></a></li>
                    </ul>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="map-responsive">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d100939.98555098464!2d-122.507640204439!3d37.757814996609724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80859a6d00690021%3A0x4a501367f076adff!2sSan+Francisco%2C+CA%2C+USA!5e0!3m2!1sen!2sro!4v1498231462606" allowfullscreen></iframe>
                    </div>
                </div> <!-- end of col -->
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-xs-12">
                        <?php 
                            if($this->session->userdata('mail_sent') == 1) {
                            echo "<div class='alert alert-success text-center'>".$this->lang->line("we have received your email. we will contact you through email as soon as possible")."</div>";
                            $this->session->unset_userdata('mail_sent');
                            }
                        ?>
                        </div>
                    </div>
                    <!-- Contact Form -->
                    <form action="<?php echo site_url("home/email_contact"); ?>" method="post">
                        <div class="row">
                            <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
                                <div class="form-group" id="email-field">
                                    <div class="form-input">
                                        <input type="email" class="form-control" required id="email" <?php echo set_value("email"); ?> placeholder="<?php echo $this->lang->line("email");?>" name="email">
                                    </div>
                                    <span class="red"><?php echo form_error("email"); ?></span>
                                </div>
                            </div>
                            
                            <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                                <div class="form-group" id="message-field">
                                    <div class="form-input">
                                        <input type="number" class="form-control" step="1" required id="captcha" <?php echo set_value("captcha"); ?> placeholder="<?php echo $contact_num1. "+". $contact_num2." = ?"; ?>" name="captcha">
                                            <span class="red">
                                                <?php 
                                                if(form_error('captcha')) 
                                                    echo form_error('captcha'); 
                                                else  
                                                { 
                                                    echo $this->session->userdata("contact_captcha_error"); 
                                                    $this->session->unset_userdata("contact_captcha_error"); 
                                                } 
                                                ?>
                                            </span>
                                        </div>
                                    <span class="red"><?php echo form_error("message") ?></span>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-group" id="phone-field">
                                    <div class="form-input">
                                        <input type="text" class="form-control" required id="subject" <?php echo set_value("subject"); ?> placeholder="<?php echo $this->lang->line("message subject");?>" name="subject">
                                    </div>
                                    <span class="red"><?php echo form_error("subject"); ?></span>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-group" id="message-field">
                                    <div class="form-input">
                                        <textarea class="form-control" rows="3" required id="message" <?php echo set_value("message"); ?> placeholder="<?php echo $this->lang->line("message");?>" name="message"></textarea>
                                    </div>
                                    <span class="red"><?php echo form_error("message") ?></span>
                                </div>
                            </div>
                            
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-group center">
                                    <button class="btn btn-info" type="submit"><?php echo $this->lang->line("Send Message");?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- end of contact form -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of form-2 -->
    <!-- end of contact -->


    <!-- Footer -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-col">
                        <h4>About <?php echo $this->config->item("product_short_name"); ?></h4>
                        <p>We're passionate about offering some of the best business growth services for startups</p>
                    </div>
                </div> <!-- end of col -->
                <div class="col-md-4">
                    <div class="footer-col middle">
                        <h4>Important Links</h4>
                        <ul class="list-unstyled li-space-lg">
                            <li class="media">
                                <i class="fas fa-square"></i>
                                <div class="media-body">Our business partners <a class="turquoise" href="https://xeroneit.net">xeroneit.net</a></div>
                            </li>
                            <li class="media">
                                <i class="fas fa-square"></i>
                                <div class="media-body">Read our <a class="turquoise" href="<?php echo base_url('home/terms_use'); ?>">Terms & Conditions</a>, <a class="turquoise" href="<?php echo base_url('home/privacy_policy'); ?>">Privacy Policy</a></div>
                            </li>
                        </ul>
                    </div>
                </div> <!-- end of col -->
                <div class="col-md-4">
                    <div class="footer-col last">
                        <h4>Social Media</h4>
                        <?php if($this->config->item('facebook') != ''): ?>
                        <span class="fa-stack">
                            <a href="<?php echo $this->config->item('facebook'); ?>">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-facebook-f fa-stack-1x"></i>
                            </a>
                        </span>
                        <?php endif; ?>
                        <?php if($this->config->item('twitter') != ''): ?>
                        <span class="fa-stack">
                            <a href="<?php echo $this->config->item('twitter'); ?>">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-twitter fa-stack-1x"></i>
                            </a>
                        </span>
                        <?php endif; ?>
                        <?php if($this->config->item('youtube') != ''): ?>
                        <span class="fa-stack">
                            <a href="<?php echo $this->config->item('youtube'); ?>">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-youtube fa-stack-1x"></i>
                            </a>
                        </span>
                        <?php endif; ?>
                        <?php if($this->config->item('linkedin') != ''): ?>
                        <span class="fa-stack">
                            <a href="<?php echo $this->config->item('linkedin'); ?>">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-linkedin-in fa-stack-1x"></i>
                            </a>
                        </span>
                        <?php endif; ?>
                    </div> 
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of footer -->  
    <!-- end of footer -->


    <!-- Copyright -->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="p-small">Copyright © <?php echo $this->config->item("product_short_name"); ?> - StartUp HTML Landing Page Template by <a href="<?php echo base_url(); ?>"><?php echo $this->config->item("institute_address1"); ?></a></p>
                </div> <!-- end of col -->
            </div> <!-- enf of row -->
        </div> <!-- end of container -->
    </div> <!-- end of copyright --> 
    <!-- end of copyright -->
    
    <?php $this->load->view("include/fb_px"); ?> 
    <?php $this->load->view("include/google_code"); ?> 
    	
    <!-- Scripts -->
    <script src="<?php echo base_url('home/xit_load_files/js/jquery.min.js'); ?>"></script> <!-- jQuery for Bootstrap's JavaScript plugins -->
    <script src="<?php echo base_url('home/xit_load_files/js/popper.min.js'); ?>"></script> <!-- Popper tooltip library for Bootstrap -->
    <script src="<?php echo base_url('home/xit_load_files/js/bootstrap.min.js'); ?>"></script> <!-- Bootstrap framework -->
    <script src="<?php echo base_url('home/xit_load_files/js/jquery.easing.min.js'); ?>"></script> <!-- jQuery Easing for smooth scrolling between anchors -->
    <script src="<?php echo base_url('home/xit_load_files/js/swiper.min.js'); ?>"></script> <!-- Swiper for image and text sliders -->
    <script src="<?php echo base_url('home/xit_load_files/js/jquery.magnific-popup.js'); ?>"></script> <!-- Magnific Popup for lightboxes -->
    <script src="<?php echo base_url('home/xit_load_files/js/validator.min.js'); ?>"></script> <!-- Validator.js - Bootstrap plugin that validates forms -->
    <script src="<?php echo base_url('home/xit_load_files/js/scripts.js'); ?>"></script> <!-- Custom scripts -->
    <script src="<?php echo base_url('home/xit_load_files/js/jquery.nicescroll.min.js'); ?>"></script> <!-- Custom scripts -->
</body>
</html>

<style type="text/css" media="screen">
    .red{color:red;}
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $(".scrollit").niceScroll();
    });
</script>