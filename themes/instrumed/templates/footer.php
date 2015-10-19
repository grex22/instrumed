<footer class="content-info" role="contentinfo">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 col-xs-12 footerlogo">
        <?php dynamic_sidebar('sidebar-footer'); ?>
        <img src="<?php echo get_template_directory_uri(); ?>/dist/images/instrumed-logo-g.png">
      </div>
      <div class="col-sm-3 col-xs-4">
        <h6>Sitemap</h6>
        <ul class="list-unstyled">
          <li><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Manufacturing</a></li>
          <li><a href="#">Innovation</a></li>
          <li><a href="#">Personalization</a></li>
          <li><a href="#">News</a></li>
          <li><a href="#">Contact Us</a></li>
        </ul>
      </div>
      <div class="col-sm-3 col-xs-4">
        <h6>Manufacturing Services</h6>
        <ul class="list-unstyled">
          <li><a href="#">Vendor List</a></li>
          <li><a href="#">Other Services</a></li>
          <li><a href="#">Surgical Instruments</a></li>
          <li><a href="#">Surgical Implants</a></li>
        </ul>
      </div>
      <div class="col-sm-3 col-xs-4">
        <h6>Contact Us</h6>
        727 N Detroit St<br>
        Warsaw, IN 46580<br>
        ph: (574) 269-1982<br>
        
        <div class="btn-group btn-group-social">
          <br>
          <?php 
            $tw = get_field('twitter_address','option');
            $fb = get_field('facebook_address','option');
            $gp = get_field('google+_address','option');
            $li = get_field('linkedin_address','option');
          ?>
          <?php if($tw){ ?><a href="<?php echo $tw; ?>"><i class="fa fa-twitter-square"></i></a><?php } ?>
          <?php if($li){ ?><a href="<?php echo $li; ?>"><i class="fa fa-linkedin-square"></i></a><?php } ?>
          <?php if($gp){ ?><a href="<?php echo $gp; ?>"><i class="fa fa-google-plus-square"></i></a><?php } ?>
          <?php if($fb){ ?><a href="<?php echo $fb; ?>"><i class="fa fa-facebook-square"></i></a><?php } ?>
        </div>
      </div>
    </div>
    <div class="row legalrow">
      <div class="col-sm-6">
        &copy; <?php echo date("Y");?> Instru-medical Technologies
      </div>
      <div class="col-sm-6 text-right">
        <a href="<?php echo get_permalink(142); ?>">Privacy Policy</a>
      </div>
    </div>
  </div>
</footer>
</div> <!-- end #sitewrap -->
