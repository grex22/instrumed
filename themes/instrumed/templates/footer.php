<footer class="content-info" role="contentinfo">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 col-xs-12 footerlogo">
        <img src="<?php echo get_template_directory_uri(); ?>/dist/images/instrumed-logo-g.png">
        <?php dynamic_sidebar('sidebar-footer'); ?>
      </div>
      <div class="col-sm-3 col-xs-6">
        <?php dynamic_sidebar('sidebar-footer-2'); ?>
      </div>
      <div class="col-sm-3 col-xs-6">
        <?php dynamic_sidebar('sidebar-footer-3'); ?>
      </div>
      <div class="col-sm-3 col-xs-12">
        <?php dynamic_sidebar('sidebar-footer-4'); ?>
        
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
