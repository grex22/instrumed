<?php

use Roots\Sage\Config;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!--[if lt IE 9]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php
      do_action('get_header');
      get_template_part('templates/header');
    ?>
    <?php if(is_front_page()): ?>
    <div class="feature">
      <div class="jumbotron jumbotron_home">
        <table class="image_grid">
          <thead>
            <tr><th></th><th></th><th></th><th></th><th></th></tr>
          </thead>
          <tbody>
          <tr>
            <td class="hidden-xs ig_animated"><div style="background-image:url('<?php echo get_template_directory_uri(); ?>/dist/images/imagegrid/ig_1_1.png')"></div></td>
            <td class="ig_xs" colspan="2"><div style="background-image:url('<?php echo get_template_directory_uri(); ?>/dist/images/imagegrid/ig_1_2.png')"></div></td>
            <td class="hidden-xs"><div style="background-image:url('<?php echo get_template_directory_uri(); ?>/dist/images/imagegrid/ig_1_3.png')"></div></td>
            <td class="hidden-xs hidden-sm" rowspan="2"><div class="rowspan" style="background-image:url('<?php echo get_template_directory_uri(); ?>/dist/images/imagegrid/ig_1_4.png')"></div></td>
          </tr>
          <tr>
            <td class="hidden-xs"><div style="background-image:url('<?php echo get_template_directory_uri(); ?>/dist/images/imagegrid/ig_2_1.png')"></div></td>
            <td colspan=2 class="message ig_xs"><h1>Quality. Precision. Reliability.</h1></td>
            <td class="hidden-xs"><div style="background-image:url('<?php echo get_template_directory_uri(); ?>/dist/images/imagegrid/ig_2_2.png')"></div></td>
          </tr>
          <tr>
            <td class="hidden-xs"><div style="background-image:url('<?php echo get_template_directory_uri(); ?>/dist/images/imagegrid/ig_3_1.png')"></div></td>
            <td class="hidden-xs"><div style="background-image:url('<?php echo get_template_directory_uri(); ?>/dist/images/imagegrid/ig_3_2.png')"></div></td>
            <td class="ig_xs" colspan=2><div style="background-image:url('<?php echo get_template_directory_uri(); ?>/dist/images/imagegrid/ig_3_3.png')"></div></td>
            <td class="hidden-xs hidden-sm"><div style="background-image:url('<?php echo get_template_directory_uri(); ?>/dist/images/imagegrid/ig_3_4.png')"></div></td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="ctabar">
      <div class="container">
        <div class="col-sm-8">
          <h3>Contract Manufacturing for the Medical Device Industry</h3>
        </div>
        <div class="col-sm-4 text-right">
          <a class="btn btn-primary" href="<?php echo get_permalink(17); ?>">Request a Quote</a>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row" id="three_features">
        <div class="col-sm-4 features">
          <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/dist/images/feature1.png"></a>
          <h4>Precision Manufacturing</h4>
          <p>Gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor quantas ipsum dolor sit amet, conset</p>
          <a href="<?php echo get_permalink(118); ?>">Our Process...</a>
        </div>
        <div class="col-sm-4 features">
          <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/dist/images/feature2.png"></a>
          <h4>Design and Prototyping Services</h4>
          <p>Gubergren, no sea takimata sanctus est Lorem ipsum dolor quantas sic sit amet. Lorem ipsum dolor sit amet, conset</p>
          <a href="#">How we integrate with you...</a>
        </div>
        <div class="col-sm-4 features">
          <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/dist/images/feature3.png"></a>
          <h4>Industry Certifications</h4>
          <p>Gubergren, no sea takimata ipsum dolor quantas sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, conset</p>
          <a href="#">Our Industry Certifications...</a>
        </div>
      </div>
    </div>
    <section id="benefit-1" class="">
      <div class="container">
        <div class="row">
          <div class="col-md-6 illustration">
            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/machine-1.jpg">
          </div>
          <div class="col-md-6 content align-help">
            <h2>Enterprise-Grade Manufacturing Processes and Materials</h2>
            <p class="highlighted">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor consetetur sadipscing elitr consetetur sadipscing elitr quantas san trinto invidun empor invidunt ut labore et do.</p>
            <a href="<?php echo get_permalink(11); ?>" class="btn btn-primary btn-lg">Learn More</a>
          </div>
        </div>
      </div>
    </section>
    <div class="container">
      <div class="row more_padded screen-sm-text-center">
        <div class="col-md-6">
          <h2 class="blue">Instru-med in Social Media</h2>
          <p class="highlighted">Follow Instru-med for the latest updates and news from the orthopedics capital of the world, Warsaw, Indiana!</p>
          <p class="highlighted">Find us on the following social networks:</p>
          <div class="btn-group btn-group-social">
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
        <div class="col-md-6">
          <a class="twitter-timeline" href="https://twitter.com/Instru_med" data-widget-id="639124671343009792">Tweets by @Instru_med</a>
          <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </div>
      </div>
    </div>
    <section id="benefit-2" class="alt flush_footer">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 content align-help padded">
            <h2 class="blue">Quality. Precision. Reliability.<br>Instru-med is your design partner.</h2>
            <p class="highlighted">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, adipscing elitr quan invidunt ut labore et do.</p>
            <a href="<?php echo get_permalink(17);?>" class="btn btn-primary btn-lg">Request a Quote</a>
            <a href="<?php echo get_permalink(9);?>" class="btn btn-secondary btn-lg">How Can We Help</a>
            <br><br>
          </div>
        </div>
      </div>
    </section>
    <?php else: //if NOT front page ?>
    
    <div id="subheader">
      <div class="container">
        <div class="row">
          <div class="col-sm-4"><h5><?php the_title(); ?></h5></div>
          <div class="col-sm-8 text-right">
            <?php wp_nav_plus(array('theme_location'=>'primary_navigation','start_depth'=>1,'depth'=>1,'menu_class'=>'subnav list-inline list-unstyled')); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="page_header_cta">
      <div class="jumbotron" style="background-image:url('<?php echo get_template_directory_uri(); ?>/dist/images/<?php the_field('intro_background'); ?>');">
        
        <div class="container">
          <div class="row">
            <?php
              $title = get_field('intro_title');
              $paragraph = get_field('intro_paragraph');
              $show_button = get_field('intro_display_button');
              $buttontext = get_field('intro_button_text');
              $buttonlink = get_field('intro_button_link');
            ?>
            <div class="col-xs-12 col-sm-7">
              <h1><?php if($title): echo $title; else: the_title(); endif; ?></h1>
              <?php if($paragraph) echo "<p>" . $paragraph . "</p>"; ?>
              <?php if($show_button): ?>
              <p><a href="<?php echo $buttonlink ?>" class="btn btn-primary"><?php echo $buttontext ?></a></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php if(Wrapper\SageWrapping::$base == "template-custom"): ?>
        <div class="wrap">
        <?php include Wrapper\template_path(); ?>
        </div>
    <?php else: ?>
      <div class="wrap container">
        <div class="content row">
          <?php if (Config\display_sidebar()) : ?>
            <aside class="sidebar">
              <?php include Wrapper\sidebar_path(); ?>
            </aside>
          <?php endif; ?>
          <main class="main" role="main">
            <?php include Wrapper\template_path(); ?>
          </main>
        </div>
      </div>
    <?php endif; ?>
    
    <?php endif; //endif is not front page ?>
    <?php
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>
  </body>
</html>
