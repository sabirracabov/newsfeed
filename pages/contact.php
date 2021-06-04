
<?php 
  include('header.php');




?>



  <section id="contentSection">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8">
        <div class="left_content">
          <div class="contact_area">
            <h2>Contact Us</h2>
            <form action="../controller/contacthandler.php" class="contact_form" method="post">
              <input class="form-control" type="text" placeholder="Name*" name="name">
              <input class="form-control" type="email" placeholder="Email*" name="email">
              <textarea class="form-control" cols="30" rows="10" placeholder="Message*" name="message"></textarea>
              <input type="submit" value="Send Message">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>



  <?php include('header.php');?>