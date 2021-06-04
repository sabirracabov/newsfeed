<?php 
    session_start();
    include('header.php');
    include('../controller/API.php');
    include('../controller/helper.php');

    $helper = new helper();

    if(!isset($_SESSION['time_stamp'])){
      $_SESSION["time_stamp"] = time(); 
      $_SESSION['json'] = $json_list = $helper->getAll();
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


    $category = strtolower(htmlspecialchars($_GET['category']));
    $id = htmlspecialchars( $_GET['id']);

    $json = $helper->getAllFiltered($json_list, $category);

   

?>

    <?php if($category == "" || $id == "" || !$helper->checkCategory($category) || !$helper->checkCountOfNews($json['articles'],$id) || empty($helper->getElements($json,$id,"content")))  : ?>
        <section id="contentSection">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8">
        <div class="left_content">
          <div class="error_page">
            <h3>We Are Sorry</h3>
            <h1>404</h1>
            <p>Unfortunately, the page you were looking for could not be found. It may be temporarily unavailable, moved or no longer exists</p>
            <span></span> <a href="../index.php" class="wow fadeInLeftBig">Go to home page</a> </div><br>
        </div>
      </div> 

    </div>
  </section>

  <!-- ----------------else show the news content------------------------ -->

  <?php else : ?>
    <section id="contentSection">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8">
        <div class="left_content">
          <div class="single_page">
            <ol class="breadcrumb">
              <li><a href="../index.php">Home</a></li>
              <li><a href="categories.php?category=<?= $category?>"><?= $category ?></a></li>
            </ol>
            <h1><?php echo $helper->getElements($json,$id,"title")  ?></h1>
            <div class="post_commentbox"> <a href="#"><i class="fa fa-user"></i><?php echo $helper->getElements($json,$id,"author")  ?></a> <span><i class="fa fa-calendar"></i><?php echo $helper->getElements($json,$id,"publishedAt")  ?></span> <a href="#"><i class="fa fa-tags"></i><?php echo $category;?></a> </div>
            <div class="single_page_content"> <img class="img-center" src="<?= $helper->getElements($json,$id,"urlToImage") ?>" alt="">
              <p></p>
              <ul>
                <li><?= $helper->getElements($json,$id,"description") ?></li>
              </ul>
              <blockquote> <?= $helper->getElements($json,$id,"content") ?></blockquote>
              
              <button class="btn btn-theme"><a style="color: white;"href="<?= "categories.php?category=".$category?>">Back To the News</a></button>
            </div>
            <div class="social_link">
              <ul class="sociallink_nav">
                <li><a href="https://www.facebook.com/profile.php?id=100067618380099"><i class="fa fa-facebook"></i></a></li>
                <li><a href="https://www.pinterest.com/sabirrcbov"><i class="fa fa-pinterest"></i></a></li>
                <li><a href="https://www.instagram.com/radjabov.init/"><i class="fa fa-instagram"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <nav class="nav-slit"> <a class="prev" href="#"> <span class="icon-wrap"><i class="fa fa-angle-left"></i></span>
        <div>
          <h3>City Lights</h3>
          <img src="../images/post_img1.jpg" alt=""/> </div>
        </a> <a class="next" href="#"> <span class="icon-wrap"><i class="fa fa-angle-right"></i></span>
        <div>
          <h3>Street Hills</h3>
          <img src="../images/post_img1.jpg" alt=""/> </div>
        </a> </nav>
      <div class="col-lg-4 col-md-4 col-sm-4">
        <aside class="right_content">
          <div class="single_sidebar">
            <h2><span>Popular Post</span></h2>
            <ul class="spost_nav">
            <?php  $rand = array_rand($json["articles"], 4)    ?>
            <!-------foreach for random popular post ------------->
            <?php foreach(array_keys($rand) as $id) : ?>
                    <?php ?>
              <li>
                <div class="media wow fadeInDown"> <a href="news.php?category=<?=$category?>&id=<?=$id?>" class="media-left"> <img alt="" src="<?= $helper->getElements($json,$id,"urlToImage") ?>"> </a>
                  <div class="media-body"> <a href="news.php?category=<?=$category?>&id=<?=$id?>" class="catg_title"> <?= $helper->getElements($json,$id,"title") ?></a> </div>
                </div>
              </li>
            <?php endforeach; ?>

            </ul>
          </div>
          <div class="single_sidebar">
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#category" aria-controls="home" role="tab" data-toggle="tab">Category</a></li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="category">
                <ul>
                <!-- list all categories -->
                <?php foreach($helper->getCategories() as $category) : ?>
                  <li class="cat-item"><a href="categories.php?category=<?= $category?>"><?= $category?></a></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
          <div class="single_sidebar wow fadeInDown">
            <h2><span>Sponsor</span></h2>
            <a class="sideAdd" href="#"><img src="../images/add_img.jpg" alt=""></a> </div>
        </aside>
      </div>
    </div>
  </section>
  <?php endif; ?>
</div>

<?php include('footer.php'); ?>
