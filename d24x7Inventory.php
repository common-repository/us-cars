<?php
/*
Plugin Name:  Dealer 24x7 Inventory Widget
Plugin URI: http://www.dealer24x7.Com
Description: Display cars for sale on your website
Version: 1.0
Author: Dealer 24x7
Author URI: http://www.dealer24x7.Com/
*/

/* Changelog
* Aug 30 2012 - v1.0
- Started

*/

class D24x7Cars_Widget extends WP_Widget {

    function D24x7Cars_Widget() {
        // widget actual processes
		$widget_ops = array('classname' => 'D24x7Cars_Widget', 'description' => __('Displays inventory for sale in USA from Dealer24x7') );
        $this->WP_Widget('dealer24x7-com-inventory-widget', __('Dealer24x7 Cars For Sale'), $widget_ops);
    }
 
    function form($instance) {
        // outputs the options form on admin
		//  Assigns values
		$instance = wp_parse_args( (array) $instance, array( 'YearsRange' => '', 'Make' => '', 'Model' => '', 'MileRange' => '', ZipCode => '' ) );
		$YearsRange = strip_tags($instance['YearsRange']);
		$Make = strip_tags($instance['Make']);
		$Model = strip_tags($instance['Model']);
		$MileRange = strip_tags($instance['MileRange']);
		$Zipcode = strip_tags($instance['Zipcode']);
		$ItemsToShow = strip_tags($instance['ItemsToShow']);
		
		$LoopYearRanges = array(
					"2010-2014",
					"2005-2009",
					"2000-2004",
					"1970-1999",
				);
		$LoopMileRanges = array(
					"0k-30k",
					"30k-60k",
					"60k-90k",
					"90k-1000k",
				);
		$LoopIPPs = array(
					"1",
					"5",
					"10",
					"15",
					"25",
					"50",
				);
		?>
       	<div class="d24x7">
			<p>
				<label for="<?php echo $this->get_field_id('Make'); ?>">
					<?php echo __('Manufacturer'); ?>: 
					<input  class="widefat" id="<?php echo $this->get_field_id('Make'); ?>" name="<?php echo $this->get_field_name('Make'); ?>" 
						type="text"value="<?php echo attribute_escape($Make); ?>" />
                </label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('Model'); ?>">
					<?php echo __('Model'); ?>: 
					<input  class="widefat" id="<?php echo $this->get_field_id('Model'); ?>" name="<?php echo $this->get_field_name('Model'); ?>" 
						type="text"value="<?php echo attribute_escape($Model); ?>" />
                </label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('YearsRange'); ?>">
					<?php echo __('Manufacturing year range'); ?>: 
                    <select class="widefat" id="<?php echo $this->get_field_id('YearsRange'); ?>" name="<?php echo $this->get_field_name('YearsRange'); ?>">
                    	<option value=""><?php echo __('All Years'); ?></option>
                            <?php
                            foreach ( $LoopYearRanges as $LoopYearRange ) {
                                echo '<option value="' . $LoopYearRange . '" '
                                    . ( $LoopYearRange == $YearsRange ? ' selected="selected"' : '' )
                                    . '>' . $LoopYearRange . "</option>\n";
                            }
                            ?>
                    </select>
                </label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('MileRange'); ?>">
					<?php echo __('Mileage Range'); ?>: 
                    <select class="widefat" id="<?php echo $this->get_field_id('MileRange'); ?>" name="<?php echo $this->get_field_name('MileRange'); ?>">
                    	<option value=""><?php echo __('Any Mileage'); ?></option>
                            <?php
                            foreach ( $LoopMileRanges as $LoopMileRange ) {
                                echo '<option value="' . $LoopMileRange . '" '
                                    . ( $LoopMileRange == $MileRange ? ' selected="selected"' : '' )
                                    . '>' . $LoopMileRange . "</option>\n";
                            }
                            ?>
                    </select>
                </label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('Zipcode'); ?>">
					<?php echo __('Zipcode'); ?>: 
					<input  class="widefat" id="<?php echo $this->get_field_id('Zipcode'); ?>" name="<?php echo $this->get_field_name('Zipcode'); ?>" 
						type="text"value="<?php echo attribute_escape($Zipcode); ?>" />
                </label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('ItemsToShow'); ?>">
					<?php echo __('Cars per page'); ?>: 
                    <select class="widefat" id="<?php echo $this->get_field_id('ItemsToShow'); ?>" name="<?php echo $this->get_field_name('ItemsToShow'); ?>">
                    	<option value="100"><?php echo __('All returned'); ?></option>
                            <?php
                            foreach ( $LoopIPPs as $LoopIPP ) {
                                echo '<option value="' . $LoopIPP . '" '
                                    . ( $LoopIPP == $ItemsToShow ? ' selected="selected"' : '' )
                                    . '>' . $LoopIPP . "</option>\n";
                            }
                            ?>
                    </select>
                </label>
			</p>
        </div>	
		<?php
    }
 
    function update($new_instance, $old_instance) {
        // processes widget options to be saved
		$instance = $old_instance;

		$instance['YearsRange'] = strip_tags($new_instance['YearsRange']);
		$instance['Make'] = strip_tags($new_instance['Make']);
		$instance['Model'] = strip_tags($new_instance['Model']);
		$instance['MileRange'] = strip_tags($new_instance['MileRange']);
		$instance['Zipcode'] = strip_tags($new_instance['Zipcode']);
		$instance['ItemsToShow'] = strip_tags($new_instance['ItemsToShow']);

		return $instance;
    }
 
    function widget($args, $instance) {
        // outputs the content of the widget
		extract($args);

		//  Outputs the widget in its standard ul li format.
		echo $before_widget;
		echo $before_title . "Vehicles on Dealer24x7.com" . $after_title;
		echo '<ul style="list-style:none;margin-left:0px;">';
	 
	 	$ResultKey = "";
	 	$ResultKey = $ResultKey . $instance['YearsRange'] ;
	 	$ResultKey = $ResultKey . $instance['Make'] ;
	 	$ResultKey = $ResultKey . $instance['Model'] ;
	 	$ResultKey = $ResultKey . $instance['MileRange'] ;
	 	$ResultKey = $ResultKey . $instance['Zipcode'] ;
		
		?>
       	<div class="d24x7">
            <a href="http://www.dealer24x7.com/<?php
            	if( $instance['Make'] != "" )
				{
					echo $instance['Make'] . "/";
				}
            	if( $instance['Model'] != "" )
				{
					echo $instance['Model'] . "/";
				}
            	if( $instance['Zipcode'] != "" )
				{
					echo "City/State/" .$instance['Zipcode'] . "/";
				}
            	if( $instance['YearsRange'] != "" )
				{
					echo $instance['YearsRange'] . "/";
				}
				echo "Used/1/";
            	if( $instance['MileRange'] != "" )
				{
					echo $instance['MileRange'] . "/";
				}
				echo "Inventory/";
			?>" target="_blank" >View Live</a>
            <br/>
            <br/>
            
			<?php // Get RSS Feed(s)
            include_once(ABSPATH . WPINC . '/feed.php');
            
            // Get a SimplePie feed object from the specified feed source.
			$feedURL = 'http://dealer24x7.com/rss.aspx?Make=' . $instance['Make'] . '&Model=' . $instance['Model'];
			if( $instance['Zipcode'] != "" )
			{
				$feedURL = $feedURL . '&Zipcode=' . $instance['Zipcode'] ;
			}
			if( $instance['YearsRange'] != "" )
			{
				$feedURL = $feedURL . '&YearStart=' . str_replace("-", "&YearEnd=", $instance['YearsRange']) ;
			}
			if( $instance['MileRange'] != "" )
			{
				$feedURL = $feedURL . '&MileageStart=' . str_replace("-", "&MileageStart=", $instance['MileRange']) ;
			}
			
			add_filter( 'wp_feed_cache_transient_lifetime' , 'return_7200' );
            $rss = fetch_feed( $feedURL );
			remove_filter( 'wp_feed_cache_transient_lifetime' , 'return_7200' );

            if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
                // Figure out how many total items there are, but limit it to 5. 
                $maxitems = $rss->get_item_quantity($instance['ItemsToShow']); 
            
                // Build an array of all the items, starting with element 0 (first element).
                $rss_items = $rss->get_items(0, $maxitems); 
            endif;
            ?>
            
            <div class="d24x7List">
                <?php if ($maxitems == 0 || $rss_items.length == 0) echo '<li>No items.</li>';
                else
                // Loop through each feed item and display each item as a hyperlink.
				$D24x7ItemNumber =0;
                foreach ( $rss_items as $item ) : ?>
                <div class="d24x7Item">
                	<?php
						if ($enclosure = $item->get_enclosure())
						{
							?>
                                <img src="<?php echo esc_url( $item->get_enclosure()->get_link() ); ?>" width="100%"/>
                                <br/>
                            <?php
						}
					?>
                    <a 
                    	href='<?php echo esc_url( $item->get_permalink() ); ?>'
                    	onclick="document.getElementById('D24x7ItemNumber<?php echo $D24x7ItemNumber; ?>').style.display='block'; return false;"
	                    title='<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>'
                        ><?php echo esc_html( $item->get_title() ); ?></a>
                        
                    <div id="D24x7ItemNumber<?php echo $D24x7ItemNumber; ?>" style="display:none">
                        <a href="javascript:document.getElementById('D24x7ItemNumber<?php echo $D24x7ItemNumber; ?>').style.display='none'; return false;"><strong>Close</strong></a>
                        |
                        <a href='<?php echo esc_url( $item->get_permalink() ); ?>' 
                        	target="_blank">
                            <strong>more...</strong>
                        </a>
                        <br/>
						<?php echo str_replace( '&bull;', '<br/>&bull;', esc_html( $item->get_description() ) ); ?>
                        
                        <br/>
                        <a href="javascript:document.getElementById('D24x7ItemNumber<?php echo $D24x7ItemNumber; ?>').style.display='none'; return false;"><strong>Close</strong></a>
                        |
                        <a href='<?php echo esc_url( $item->get_permalink() ); ?>' 
                        	target="_blank">
                            <strong>more...</strong>
                        </a>
                    </div>
                </div>
                <?php 
					$D24x7ItemNumber = $D24x7ItemNumber + 1;
				endforeach; ?>
            </div>
		</div>
        <?php
		echo $after_widget;
		//  Done
		
    }
 
}

function return_7200( $seconds )
{
  // change the default feed cache recreation period to 2 hours
  return 24 * 60 * 60;
}

//register_widget('D24x7Cars_Widget');
add_action('widgets_init', create_function('', 'return register_widget("D24x7Cars_Widget");'));

add_action( 'init', 'd24x7_load_js_and_css' );
function d24x7_load_js_and_css() {
	wp_register_style( 'd24x7-css', plugins_url('d24x7.css', __FILE__) );
	wp_enqueue_style( 'd24x7-css');
}
?>