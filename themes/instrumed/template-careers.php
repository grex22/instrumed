<?php
/**
 * Template Name: Careers
 */
?>

<?php while (have_posts()) : the_post();
    

    //get_template_part('templates/page', 'header');
    the_content();
    
    if( have_rows('open_positions') ):
      echo "<hr>";
        while ( have_rows('open_positions') ) : the_row();
          if(the_sub_field('hide_position') != true):
            $gform_param_link = get_permalink(170)."?position=".str_replace(" ","+",get_sub_field('position_title'));
            echo "<div class='career_item'>";
            echo "<a class='btn btn-primary pull-right' href='$gform_param_link'>Apply Now</a> ";
            echo "<h3><a href='$gform_param_link'>";
            the_sub_field('position_title');
            echo "</a></h3><br>";
            if(the_sub_field('description')):
              echo the_sub_field('description');
            endif;
            echo "</div><hr>";
          endif;
        endwhile;
    else :
        echo "<em>There are currently no open positions. Check back shortly.</em>";
    endif;
    
endwhile; // end loop