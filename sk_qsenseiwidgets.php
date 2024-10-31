<?php
/*
Plugin Name: Q-Sensei Sidebar Widgets
Plugin URI: http://www.qsensei.com/widgets/
Description: This Plugin allows you to quickly and easily include the useful features of the Q-Sensei Search Engine directly into your blog.
Author: Steffen Kuegler
Version: 1.0
Author URI: http://www.qsensei.com
License: GPL 2.0, @see http://www.gnu.org/licenses/gpl-2.0.html
*/

class sk_qsenseiwidgets {

    function init() {
    	// check for the required WP functions, die silently for pre-2.2 WP.
    	if (!function_exists('wp_register_sidebar_widget'))
    		return;
        
        // let WP know of this plugin's widget view entry
    	wp_register_sidebar_widget('sk_qsenseiwidgets', 'Q-Sensei Widgets', array('sk_qsenseiwidgets', 'widget'),
            array(
            	'classname' => 'sk_qsenseiwidgets',
            	'description' => 'Allows the user to add a Q-Sensei Widget to the Wordpress Blog Sidebar.'
            )
        );
    
        // let WP know of this widget's controller entry
    	wp_register_widget_control('sk_qsenseiwidgets', 'Q-Sensei Widgets', array('sk_qsenseiwidgets', 'control'),
    	    array('width' => 400)
        );       
    }
    		
	// back end options dialogue
	function control() {
	    $options = get_option('sk_qsenseiwidgets');
		if (!is_array($options))
			$options = array('title'=> 'Q-Sensei Widget', 'label'=> 'Add Q-Sensei Widget', 'fieldwidth'=> '300');
		if ($_POST['sk_qsenseiwidgets-submit']) {
			$options['code'] = str_replace("\\\"", "\"", $_POST['sk_qsenseiwidgets-code']);
			update_option('sk_qsenseiwidgets', $options);
		}
		$code = $options['code'];

		echo '<p>Please paste the Q-Sensei Widget Code here: <br /><textarea style="width: 400px; height: 200px" id="sk_qsenseiwidgets-code" name="sk_qsenseiwidgets-code">'.$code.'</textarea></p>';
		
		echo '<input type="hidden" id="sk_qsenseiwidgets-submit" name="sk_qsenseiwidgets-submit" value="1" />';
	}

    function view($is_widget, $args=array()) {
    	if($is_widget) extract($args);
    
    	// get widget options
    	$options = get_option('sk_qsenseiwidgets');
    	$code = $options['code'];
        
    	// the widget's form
		$out[] = $before_widget . $before_title . $title . $after_title;
		$out[] = '<div style="margin-top:5px;">';
		$out[] = $code;
		$out[] = '</div>';
    	$out[] = $after_widget;
    	return join($out, "\n");
    }

    function widget($atts) {
        echo sk_qsenseiwidgets::view(true, $atts);
    }
}

add_action('widgets_init', array('sk_qsenseiwidgets', 'init'));

?>