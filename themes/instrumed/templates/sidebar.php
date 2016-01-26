<?php dynamic_sidebar('sidebar-primary'); ?>
<?php

  $events = get_posts(array(
    'post_type' => 'event',
    'posts_per_page'	=> 5,
    'meta_query'	=> array(
      array(
        'key'	 	=> 'start_date',
        'value'	  	=> date("Ymd"),
        'compare' 	=> '>=',
      )
    ),
    'orderby'			=> 'meta_value_num',
    'order'				=> 'ASC'
  ));
  if($events):
    echo "<section class='widget widget-upcoming-events'>";
    echo "<h4>Upcoming Events</h4><ul class='list-unstyled list-events'>";
    foreach($events as $event):
      echo "<li><strong>". $event->post_title . "</strong><br>";
      echo "<small><strong>".date("M j, Y", strtotime(get_field('start_date',$event->ID)));
      if(get_field('end_date',$event->ID)) echo " - ".date("M j, Y", strtotime(get_field('end_date',$event->ID)));
      echo " &mdash; ".get_field('event_location',$event->ID);
      echo "</strong><br>";
      if(get_field('event_description',$event->ID)) echo get_field('event_description',$event->ID);
      echo "</small>";
      echo "</li>";
    endforeach;
    echo "</ul></section>";
  endif;
