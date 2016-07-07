<?php
/**
 * Template Name: Full-Width Flexible
 */
?>

<?php while (have_posts()) : the_post();

    $contentcount = 1;
    echo "<section class='contentblock layout-wp-content'>";
    echo "<div class='container container-limit-width'>";
    get_template_part('templates/page', 'header');
    the_content();
    echo "</div>";
    echo "</section>";

    // check if the flexible content field has rows of data
    if( have_rows('page_content_blocks') ):

         // loop through the rows of data
        while ( have_rows('page_content_blocks') ) : the_row();

          echo "<section class='contentblock layout-".get_row_layout()."'>";
          echo "<div class='container container-limit-width'>";
            echo "<div id='content-block-section-".$contentcount."'>";

            if( get_row_layout() == 'standard_content' ):

              the_sub_field('paragraph_content');

            elseif( get_row_layout() == 'tabbed_box' ):

              $tabbed_box_title = get_sub_field('tabbed_box_title');
              $tabbed_box_intro = get_sub_field('tabbed_box_intro');

              if($tabbed_box_title) echo "<div class='page-header'><h3>$tabbed_box_title</h3></div>";
              if($tabbed_box_intro) echo "<div class='tabbed_box_intro'>".$tabbed_box_intro."</div>";


              if( have_rows('tabs') ):

                // loop through the rows of data
                  $tabsarray = array();
                  $tabscontent = array();
                  while ( have_rows('tabs') ) : the_row();

                      $tabsarray[] = get_sub_field('tab_title');
                      $tabscontent[] = get_sub_field('tab_content');

                  endwhile;

                  if($tabsarray && $tabscontent):

                    $i = 1;
                    $tabs_string = "<ul class='nav nav-tabs'>";
                    $tabscontent_string = "<div class='tab-content content-block-tab-content'>";

                    foreach($tabsarray as $tabtitle):
                      $tabs_string .= '<li';
                      if($i == 1) $tabs_string.=' class="active"';
                      $tabs_string.='><a href="#tab'.$i.'" data-toggle="tab">'.$tabtitle.'</a></li>';
                      $i++;
                    endforeach;
                    $tabs_string .= "</ul>";

                    $i = 1;

                    foreach($tabscontent as $tabcont):
                      $tabscontent_string .= '<div class="tab-pane';
                      if($i == 1) $tabscontent_string.=' active';
                      $tabscontent_string.='" id="tab'.$i.'">'.$tabcont.'</div>';
                      $i++;
                    endforeach;
                    echo $tabs_string;
                    echo $tabscontent_string;

                    ?>


                    </div>

                    <?php

                  endif;
                endif;

            elseif( get_row_layout() == 'full-width_call-to-action' ):
              $cta_box_title = get_sub_field('cta_box_title');
              $cta_box_content = get_sub_field('cta_box_content');
              $cta_box_button_show = get_sub_field('cta_box_button_show');
              $cta_box_button_text = get_sub_field('cta_box_button_text');
              $cta_box_button_link = get_sub_field('cta_box_button_link');
              ?>

                <div class="container container-limit-width">
                  <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 text-center content align-help padded">
                      <h2 class="blue"><?php echo $cta_box_title ?></h2>
                      <p class="highlighted"><?php echo $cta_box_content ?></p>
                      <?php if($cta_box_button_show): ?>
                      <a href="<?php echo $cta_box_button_link ?>" class="btn btn-primary btn-lg"><?php echo $cta_box_button_text ?></a>
                      <?php endif; ?>
                      <br><br>
                    </div>
                  </div>
                </div>

              <?php
            elseif( get_row_layout() == 'image_grid' ):
              $ig_title = get_sub_field('title');
              $ig_images = get_sub_field('gallery');
              $ig_button_show = get_sub_field('show_button');
              $ig_button_text = get_sub_field('button_text');
              $ig_button_link = get_sub_field('button_link');
              ?>

                <div class="container container-limit-width">
                  <div class="row">
                    <div class="col-xs-10 col-xs-offset-1 text-center content align-help padded">
                      <h2 class="blue"><?php echo $ig_title ?></h2>
                      <?php
                        if($ig_images):
                          echo "<div class='image_grid_gallery'>";
                          foreach($ig_images as $img):
                            echo "<a rel='lightbox[gallery-".$contentcount."]' class='gallery_item' href='".$img['sizes']['large']."'><img src='".$img['sizes']['thumbnail']."'></a>";
                          endforeach;
                          echo "</div>";
                        endif;
                      ?>
                      <div class="clearfix"></div>
                      <?php if($ig_button_show): ?>
                      <a href="<?php echo $ig_button_link ?>" class="btn btn-primary btn-lg"><?php echo $ig_button_text ?></a>
                      <?php endif; ?>
                      <br><br>
                    </div>
                  </div>
                </div>
              <?php
              elseif( get_row_layout() == 'filterable_image_wall' ):
                $iso_title = get_sub_field('section_title');
                ?>
                  <div class="container container-limit-width">
                    <div class="row">
                      <div class="col-xs-12 content align-help padded">
                        <h2 class="blue"><?php echo $iso_title ?></h2>
                        <?php
                          if( have_rows('image_group') ):
                            $group_name_array = array();
                            $image_array = array();
                            while ( have_rows('image_group') ) : the_row();
                              $group_name_array[] = get_sub_field('group_name');
                              $group_imgs = get_sub_field('group_images');
                              if($group_imgs):
                                foreach($group_imgs as $img):
                                  $image_array[] = array(
                                    'thumb' => $img['sizes']['medium'],
                                    'full' => $img['url'],
                                    'class' => sanitize_title(get_sub_field('group_name'))
                                  );
                                endforeach;
                              endif;
                            endwhile;

                            if($group_name_array && shuffle($image_array)):
                              echo '<div class="isotope_wrapper" id="isotope_id_'.sanitize_title($iso_title).'">';
                                echo '<div class="filter-button-group option-set" data-option-key="filter">';
                                echo '<button data-option-value="*" data-target="isotope_id_'.sanitize_title($iso_title).'" class="btn active btn-default btn-sm">All</button>';
                                foreach($group_name_array as $grp):
                                  echo '<button data-option-value=".'.sanitize_title($grp).'" data-target="isotope_id_'.sanitize_title($iso_title).'" class="btn btn-default btn-sm">'.$grp.'</button>';
                                endforeach;
                                echo "</div><br><br>";
                                echo "<div class='isotope_grid_gallery' id='isotope_".sanitize_title($iso_title)."'>";
                                foreach($image_array as $img):
                                  echo "<a rel='lightbox[]' class='element-item ".$img['class']."' href='".$img['full']."'><img src='".$img['thumb']."'></a>";
                                endforeach;
                                echo "</div>";
                              echo "</div>";

                            endif;
                          endif;
                        ?>
                        <div class="clearfix"></div>

                        <br><br>
                      </div>
                    </div>
                  </div>

                <?php

            endif;

          echo "</div>"; // end wrapping div
          echo "</div>"; // end container
          echo "</section>"; // end section

        $contentcount++;
        endwhile;

    endif; //end if have_rows('page_content_blocks')

endwhile; // end loop
