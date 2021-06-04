<?php 
    session_start();
    include('header.php');
    include('../controller/helper.php');



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


    $category =  htmlspecialchars($_GET['category']);

    $helper = new helper();

    $json = $helper->getAllFiltered($json_list, $category);

    

  
    

?>

        <style>
            .single_post_content2{float:left; width:49%; margin-bottom:20px}
            .single_post_content_left2{width:90%}
            @media(min-width: 360px) and (max-width: 480px){.single_post_content2{width: 100%; clear: both;}.single_post_content_left2{width:100%;}}

        </style>

        <?php if($category == "" || !$helper->checkCategory($category)) : ?>
          <section id="contentSection">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8">
        <div class="left_content">
          <div class="error_page">
            <h3>We Are Sorry</h3>
            <h1>404</h1>
            <p>Unfortunately, the page you were looking for could not be found. It may be temporarily unavailable, moved or no longer exists</p>
            <span></span> <a href="../index.php" class="wow fadeInLeftBig">Go to home page</a> </div>
        </div>
      </div>
      
    </div>
  </section><br>





        <!-- ----------------else show the news content------------------------ -->

        <?php else : ?>
        <h2><span><?= $category ?></span></h2>
        <?php foreach(array_keys($json['articles']) as $id) : ?>
        <?php if($json['articles'][$id]['urlToImage'] != "") : ?>
        <div class="single_post_content2" id="cont">
            <div class="single_post_content_left2">
              <ul class="business_catgnav  wow fadeInDown">
                <li>
                  <figure class="bsbig_fig"> <a href="news.php?category=general&id=<?=$id?>" 
                  class="featured_img"> 
                  <img id="loaded" alt="" src="<?= $json['articles'][$id]['urlToImage']?>" 
                  onerror="this.style.display='none';"> <span class="overlay"></span> </a> <br>
                    <p><?php echo $helper->getElements($json,$id,"publishedAt"); ?></p>
                    <figcaption> <a href="news.php?category=general&id=<?=$id?>">
                    <?php echo $helper->getElements($json,$id,"title"); ?></a> </figcaption>
                    <p><?php echo $helper->getElements($json,$id,"description"); ?></p>

                  </figure>
                </li>
              </ul>
            </div>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php endif;?>
        
        
        




<?php include('footer.php'); ?>