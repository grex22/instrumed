<ul class="mobile_nav visible-xs">
  <?php wp_nav_menu( array( 'theme_location' => 'mobile_drawer_menu', 'depth' => 1, 'container' => false) ); ?>
  <li id="menu-item-310" class="menu-item menu-item-310"><a href="<?php echo get_permalink(get_page_by_path('request-a-quote')); ?>"><i class="fa fa-file-text blue"></i> Request a Quote</a></li>
</ul>
<div id="sitewrap">
  <header id="navheader">
    <div class="container-fluid width-control">
      <div class="row header hidden-xs">
        <div class="col-xs-3 brand">
          <a href="<?php echo bloginfo('url'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/dist/images/instrumed-logo.png" width="195" height="auto"></a>
        </div>
        <div class="col-xs-9 text-right">
          <a href="<?php echo get_permalink('contact-us'); ?>" class="btn btn-primary pull-right">How can we help?</a>
          <ul class="nav navbar-nav pull-right">
            <?php wp_nav_menu( array( 'theme_location' => 'primary_navigation', 'walker' => new Bootstrap_Nav_Walker(), 'container' => false,  'items_wrap' => '%3$s') ); ?>
          </ul>
        </div>
      </div>
      <div class="row header-mobile visible-xs">
        <a href="<?php echo bloginfo('url'); ?>" class="brand"><img src="<?php echo get_template_directory_uri(); ?>/dist/images/instrumed-logo.png" width="120" height="auto"></a>
        <div id="mobile_nav_trigger_wrap">
          <a id="mobile_nav_trigger" href="#"></a>
        </div>
      </div>
    </div>
  </header>
