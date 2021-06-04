<?php 
    include('controller/helper.php');
    session_start();
    date_default_timezone_set('Asia/Dubai');


    $helper = new helper();


    /*
      ***check for the first access to website if its first then get json from api
      ***If its not then do nothing
      ***But if session time is over(1 Hour)  then get the new json from api
    */
    

    if(!isset($_SESSION['time_stamp'])){
        $_SESSION["time_stamp"] = time(); 
        $_SESSION['json']  = $helper->getAll();
    } else {
      if(time()-$_SESSION["time_stamp"] > 7200){
        session_regenerate_id(true);
        $_SESSION["time_stamp"] = time();
        $_SESSION['json'] = $json_list = $helper->getAll();
      } else {
        // DO NOTHING
      }
    }
   
    $json_list = $_SESSION['json'];
    

    
    
    $category = $helper->shuffle(1);
    $json = $helper->getAllFiltered($json_list, $category);

    $date = date('m/d/Y h:i:s a', time());
    $date_url = date('y-m-d');

?>




<!DOCTYPE html>
<html>
<head>
<title>NewsFeed</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/animate.css">
<link rel="stylesheet" type="text/css" href="assets/css/font.css">
<link rel="stylesheet" type="text/css" href="assets/css/li-scroller.css">
<link rel="stylesheet" type="text/css" href="assets/css/slick.css">
<link rel="stylesheet" type="text/css" href="assets/css/jquery.fancybox.css">
<link rel="stylesheet" type="text/css" href="assets/css/theme.css">
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<!--[if lt IE 9]>
<script src="assets/js/html5shiv.min.js"></script>
<script src="assets/js/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div id="preloader">
  <div id="status">&nbsp;</div>
</div>
<a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
<div class="container">
  <header id="header">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="header_top">
          <div class="header_top_left">
            <ul class="top_nav">
              <li><a href="index.php">Home</a></li>
              <li><a href="#">About</a></li>
              <li><a href="pages/contact.php">Contact</a></li>
            </ul>
          </div>
          <div class="header_top_right">
            <p><?= $date; ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="header_bottom">
          <div class="logo_area"><a href="index.html" class="logo"><img src="images/logo.jpg" alt=""></a></div>
          <div class="add_banner">Advertisement<a href="#"><img src="images/addbanner_728x90_V1.jpg" alt=""></a></div>
        </div>
      </div>
    </div>
  </header>
  <section id="navArea">
    <nav class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav main_nav">
          <li class="active"><a href="index.php"><span class="fa fa-home desktop-home"></span><span class="mobile-show">Home</span></a></li>
          <li><a href="pages/categories.php?category=general">General</a></li>
          <li class="dropdown"> <a href="pages/categories.php?category=business" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Business</a>
          </li>
          <li><a href="pages/categories.php?category=science">Science</a></li>
          <li><a href="pages/categories.php?category=technology">Technology</a></li>
          <li><a href="pages/categories.php?category=sports">Sports</a></li>
          <li><a href="pages/categories.php?category=health">health</a></li>
          <li><a href="pages/categories.php?category=entertainment">entertainment</a></li>
          <li><a href="pages/contact.html">Contact Us</a></li>
        </ul>
      </div>
    </nav>
  </section>
 

  <!-- pick random news for slideshow -->
  <?php  $rand = array_rand($json["articles"], 5)    ?>
  <section id="sliderSection">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8">
        <div class="slick_slider">


        <!-- print slide show which 6 info picked up randomly -->
        <?php foreach(array_keys($rand) as $id) : ?>
        <!-- random select for each category -->
        <?php 
              
              $category = $helper->shuffle(1);
              $json = $helper->getAllFiltered($json_list, $category);

              
        ?>
        <div class="single_iteam"> <a href="pages/news.php?category=<?=$category?>&id=<?=$id?>"> <img onerror="this.src='images/notfound.jpg';" src="<?= $helper->getElements($json,$id,"urlToImage") ?>" alt=""></a>
            <div class="slider_article">
              <h2><a class="slider_tittle" href="pages/news.php?category=<?=$category?>&id=<?=$id?>"><?= $helper->getElements($json,$id,"title") ?></a></h2>
              <p><?= $helper->getElements($json,$id,"description")?></p>
            </div>
        </div>
        <?php endforeach; ?>
          <!-- end for each -->
      </div>
      </div>
      <?php  $rand = array_rand($json["articles"], 5)    ?>
      <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="latest_post">
          <h2><span>Popular Post</span></h2>
          <div class="latest_post_container">
            <div id="prev-button"><i class="fa fa-chevron-up"></i></div>
            <ul class="latest_postnav">
            <?php foreach(array_keys($rand) as $id) :?>
              <!-- random select for each category -->
              <?php 
                $category = $helper->shuffle(1);
                $latest_json = $helper->getAllFiltered($json_list, $category);
                

              ?>
              <li>
                <div class="media"> <a href="pages/news.php?category=<?=$category?>&id=<?=$id?>" class="media-left"> <img onerror="this.src='images/notfound.jpg';" alt=""  src="<?= $helper->getElements($latest_json, $id, 'urlToImage')  ?>"> </a>
                  <div class="media-body"> <a href="pages/news.php?category=<?=$category?>&id=<?=$id?>" class="catg_title"><?= $helper->getElements($latest_json, $id, 'title')  ?></a> </div>
                </div>
              </li>
              <?php endforeach; ?>
              <!-- end for each -->
            
              
            </ul>
            <div id="next-button"><i class="fa  fa-chevron-down"></i></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="contentSection">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8">
        <div class="left_content">
          <div class="single_post_content">
            <h2><span>Business</span></h2>
            <?php
              $json = $helper->getAllFiltered($json_list, "business");
            
            ?>
            <div class="single_post_content_left">
              <ul class="business_catgnav  wow fadeInDown">
                <li>
                  <figure class="bsbig_fig"> <a href="pages/news.php?category=business&id=1" class="featured_img"> <img onerror="this.src='images/notfound.jpg';" alt="" src="<?= $helper->getElements($json, 1, "urlToImage") ?>"> <span class="overlay"></span> </a>
                    <figcaption> <a href="pages/news.php?category=business&id=1"><?= $helper->getElements($json, 1, "title") ?></a> </figcaption>
                    <p><?=$helper->getElements($json, 1, "description")?></p>
                  </figure>
                </li>
              </ul>
            </div>
            <div class="single_post_content_right">
              <ul class="spost_nav">
                <?php $rand =  array_rand($json['articles'],4);  ?>
                <?php foreach(array_keys($rand) as $id) :?>
                <li>
                  <div class="media wow fadeInDown"> <a href="pages/news.php?category=business&id=<?=$id?>" class="media-left"> <img onerror="this.src='images/notfound.jpg';" alt="" src="<?= $helper->getElements($json,$id,"urlToImage")?>"> </a>
                    <div class="media-body"> <a href="pages/news.php?category=business&id=<?=$id?>" class="catg_title"> <?= $helper->getElements($json,$id,"title")?></a> </div>
                  </div>
                </li>
                <?php endforeach ?>
               
                
                
              </ul>
            </div>
          </div>
          <div class="fashion_technology_area">
            <div class="fashion">
              <div class="single_post_content">
                <h2><span>Entertainment</span></h2>

                <?php $json = $helper->getAllFiltered($json_list, "entertainment"); ?>
                <ul class="business_catgnav wow fadeInDown">
                  <li>
                    <figure class="bsbig_fig"> <a href="pages/news.php?category=entertainment&id=2" class="featured_img"> <img onerror="this.src='images/notfound.jpg';" alt="" src="<?=$helper->getElements($json, 3, "urlToImage")?>> <span class="overlay"></span> </a>
                      <figcaption> <a href="pages/news.php?category=entertainment&id=2"><?=$helper->getElements($json, 3, "title")?></a> </figcaption>
                      <p><?=$helper->getElements($json, 3, "description")?></p>
                    </figure>
                  </li>
                </ul>
                <ul class="spost_nav">

                  <?php $rand =  array_rand($json['articles'],4);  ?>
                  <?php foreach(array_keys($rand) as $id) :?>

                  <li>
                    <div class="media wow fadeInDown"> <a href="pages/news.php?category=entertainment&id=<?=$id?>" class="media-left"> <img onerror="this.src='images/notfound.jpg';" alt="" src="<?= $helper->getElements($json,$id,"urlToImage")?>"> </a>
                      <div class="media-body"> <a href="pages/news.php?category=entertainment&id=<?=$id?>" class="catg_title"><?= $helper->getElements($json,$id,"title")?></a> </div>
                    </div>
                  </li>
                  
                  <?php endforeach; ?>
                 
                </ul>
              </div>
            </div>
            <div class="technology">
            <div class="single_post_content">
                <h2><span>Sports</span></h2>

                <?php 
                  $json = $helper->getAllFiltered($json_list, "sports");
                ?>


                <ul class="business_catgnav wow fadeInDown">
                  <li>
                    <figure class="bsbig_fig"> <a href="pages/news.php?category=sports&id=2" class="featured_img"> <img onerror="this.src='images/notfound.jpg';" alt="" src="<?=$helper->getElements($json, 3, "urlToImage")?>> <span class="overlay"></span> </a>
                      <figcaption> <a href="pages/news.php?category=sports&id=2"><?=$helper->getElements($json, 3, "title")?></a> </figcaption>
                      <p><?=$helper->getElements($json, 3, "description")?></p>
                    </figure>
                  </li>
                </ul>
                <ul class="spost_nav">

                  <?php $rand =  array_rand($json['articles'],4);  ?>
                  <?php foreach(array_keys($rand) as $id) :?>

                  <li>
                    <div class="media wow fadeInDown"> <a href="pages/news.php?category=sports&id=<?=$id?>" class="media-left"> <img onerror="this.src='images/notfound.jpg';" alt="" src="<?= $helper->getElements($json,$id,"urlToImage")?>"> </a>
                      <div class="media-body"> <a href="pages/news.php?category=sports&id=<?=$id?>" class="catg_title"><?= $helper->getElements($json,$id,"title")?></a> </div>
                    </div>
                  </li>
                  
                  <?php endforeach; ?>
                 
                </ul>
              </div>
            </div>
          </div>
          
          <div class="single_post_content">
            <h2><span>Science</span></h2>
            <?php
              $json = $helper->getAllFiltered($json_list, "science");
            
            ?>
            <div class="single_post_content_left">
              <ul class="business_catgnav  wow fadeInDown">
                <li>
                  <figure class="bsbig_fig"> <a href="pages/news.php?category=science&id=1" class="featured_img"> <img onerror="this.src='images/notfound.jpg';" alt="" src="<?= $helper->getElements($json, 1, "urlToImage") ?>"> <span class="overlay"></span> </a>
                    <figcaption> <a href="pages/news.php?category=science&id=1"><?= $helper->getElements($json, 1, "title") ?></a> </figcaption>
                    <p><?=$helper->getElements($json, 1, "description")?></p>
                  </figure>
                </li>
              </ul>
            </div>
            <div class="single_post_content_right">
              <ul class="spost_nav">
                <?php $rand =  array_rand($json['articles'],4);  ?>
                <?php foreach(array_keys($rand) as $id) :?>
                <li>
                  <div class="media wow fadeInDown"> <a href="pages/news.php?category=Science&id=<?=$id?>" class="media-left"> <img onerror="this.src='images/notfound.jpg';" alt="" src="<?= $helper->getElements($json,$id,"urlToImage")?>"> </a>
                    <div class="media-body"> <a href="pages/news.php?category=Science&id=<?=$id?>" class="catg_title"> <?= $helper->getElements($json,$id,"title")?></a> </div>
                  </div>
                </li>
                <?php endforeach ?>
               
                
                
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">
        <aside class="right_content">
          
          <div class="single_sidebar">
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#category" aria-controls="home" role="tab" data-toggle="tab">Category</a></li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="category">
                <ul>

                  <!-- list all categories -->
                  <?php foreach($helper->getCategories() as $category) : ?>
                  <li class="cat-item"><a href="pages/categories.php?category=<?= $category?>"><?= $category?></a></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
          <div class="single_sidebar wow fadeInDown">
            <h2><span>Sponsor</span></h2>
            <a class="sideAdd" href="#"><img src="images/add_img.jpg" alt=""></a> </div>
        </aside>
      </div>
    </div>
  </section>
  <footer id="footer">
    <div class="footer_top">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="footer_widget wow fadeInLeftBig">
            <h2>Flickr Images</h2>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="footer_widget wow fadeInDown">
            <h2>Tag</h2>
            <ul class="tag_nav">
            <?php foreach($helper->getCategories() as $category) : ?>
                  <li><a href="../pages/categories.php?category=<?= $category?>"><?= $category?></a></li>
            <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="footer_widget wow fadeInRightBig">
            <h2>Contact</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
            <address>
            Perfect News,1238 S . 123 St.Suite 25 Town City 3333,USA Phone: 123-326-789 Fax: 123-546-567
            </address>
          </div>
        </div>
      </div>
    </div>
    <div class="footer_bottom">
      <p class="copyright">Copyright &copy; 2045 <a href="index.php">NewsFeed</a></p>
      <p class="developer" style="color:aliceblue">Developed by <a style="color:#D083CF" href="https://www.instagram.com/radjabov.init/">Sabir Racabov</a></p>
    </div>
  </footer>
</div>
<script src="assets/js/jquery.min.js"></script> 
<script src="assets/js/wow.min.js"></script> 
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/jquery.li-scroller.1.0.js"></script> 
<script src="assets/js/jquery.newsTicker.min.js"></script> 
<script src="assets/js/jquery.fancybox.pack.js"></script> 
<script src="assets/js/custom.js"></script>
</body>
</html>