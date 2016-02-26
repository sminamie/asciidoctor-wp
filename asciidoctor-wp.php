<?php
/*
Plugin Name: Asciidoctor for Wordpress
Plugin URI:
Description: Asciidoctor for Wordpress
Author: SHUICHI MINAMIE
Version: 1.0
Author URI: https://chimeraskyblog.wordpress.com
*/


$wpasciidocPlugin = new Plugin_wpasciidoc();


class Plugin_wpasciidoc
{

     public function __construct()
    {

        if (function_exists('register_activation_hook'))
        {
            register_activation_hook(__FILE__, array(&$this, 'activation'));
        }

        // if (function_exists('register_deactivation_hook'))
        // {
        //     register_deactivation_hook(__FILE__, array(&$this, 'deactivationHook'));
        // }

        // if (function_exists('register_uninstall_hook'))
        // {
        //     register_uninstall_hook(__FILE__, array(&$this, 'uninstallHook'));
        // }

            add_action( 'admin_menu', 'wpasciidoc_Menu' );

    }

    function activation() {
        if (empty($_POST['wpasc_mode_select']) ) {
            update_option('wpasc_mode_select', '0');
             }
    }
}

    //add admin sub menu
  function wpasciidoc_Menu() {

    add_options_page( 'Asciidoc', 'Asciidoc', 'manage_options', 'asciidoc_setting', 'asciidoc_option_page', '', '75.293' );
  }


  function asciidoc_option_page() {

    if (isset($_POST['wpasc_mode_select'])  && check_admin_referer('wpasciidoc')  ) {
        update_option('wpasc_mode_select', $_POST['wpasc_mode_select']);
        $wpasc_check_post = isset($_POST['wpasc_check_post']) ? 1 : 0;
        update_option('wpasc_check_post', $wpasc_check_post);
        $wpasc_check_page = isset($_POST['wpasc_check_page']) ? 1 : 0;
        update_option('wpasc_check_page', $wpasc_check_page);
        $wpasc_check_asciidoccss = isset($_POST['wpasc_check_asciidoccss']) ? 1 : 0;
        update_option('wpasc_check_asciidoccss', $wpasc_check_asciidoccss);
        $wpasc_check_custum = isset($_POST['wpasc_check_custum']) ? 1 : 0;
        update_option('wpasc_check_custum', $wpasc_check_custum);
        $wpasc_check_image = isset($_POST['wpasc_check_image']) ? 1 : 0;
        update_option('wpasc_check_image', $wpasc_check_image);
        $wpasc_check_highlight = isset($_POST['wpasc_check_highlight']) ? 1 : 0;
        update_option('wpasc_check_highlight', $wpasc_check_highlight);
        // $wpasc_check_jquery = isset($_POST['wpasc_check_jquery']) ? 1 : 0;
        // update_option('wpasc_check_jquery', $wpasc_check_jquery);
       }

    if (isset($_POST['wpasc_mode_select']) ) {
        echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
            <p><strong>seve settings</strong></p></div>';
    }


    echo '<form method="post" action="">';

    wp_nonce_field('wpasciidoc');

    echo '<p id="">Mode:</p>';
    echo '<p><label><input name="wpasc_mode_select" value="0" type="radio" ';
    checked( 0, get_option('wpasc_mode_select'));
    echo '> Individual posts</label></p>';
    echo '<p>If you want to set in each posts and pages, Please check here.</p>';
    echo '<br />';

    echo '<p><label><input name="wpasc_mode_select" value="1" type="radio" ';
    checked( 1, get_option('wpasc_mode_select'));
    echo '> All posts</label></p>';
    echo '<p>If you want use with "Front end editor" or "wordpress.com", must be check here.</p>';
    echo '<br />';



    // echo '<p id="">:</p>';
    // echo '<p><input type="checkbox" value="1" name="wpasc_check_post" ';
    // checked( 1, get_option('wpasc_check_post'));
    // echo '> POST</p>';
    // echo '<p><input type="checkbox" value="1" name="wpasc_check_page" ';
    // checked( 1, get_option('wpasc_check_page'));
    // echo '> PAGE</p>';
    // echo '<p><input type="checkbox" value="1" name="wpasc_check_custum" ';
    // checked( 1, get_option('wpasc_check_custum'));
    // echo '> COSTUM POST TYPE</p>';

    echo '<p id="">Extra settings:</p>';

    echo '<p><input type="checkbox" value="1" name="wpasc_check_asciidoccss" ';
    checked( 1, get_option('wpasc_check_asciidoccss'));
    echo '> Use Asciidoc css</p>';
    echo '<p>If you want use Asciidoc css, please check here.</p>';

    echo '<br />';

    echo '<p><input type="checkbox" value="1" name="wpasc_check_image" ';
    checked( 1, get_option('wpasc_check_image'));
    echo '> Use Asciidoctor images format</p>';
    echo '<p>If you want use Asciidoctor images format, please check here.</p>';

    echo '<br />';

    echo '<p><input type="checkbox" value="1" name="wpasc_check_highlight" ';
    checked( 1, get_option('wpasc_check_highlight'));
    echo '> highlight.js</p>';
    echo '<p>If you want use highlight.js, please check here.</p>';

    echo '<br />';

    // echo '<p><input type="checkbox" value="1" name="wpasc_check_jquery" ';
    // checked( 1, get_option('wpasc_check_jquery'));
    // echo '> jquery.js</p>';
    // echo '<p>If dose not have jquery is used in the current theme, please check here.</p>';
    //
    // echo submit_button();
    // echo '</form>';



  }

  add_action( 'wp_enqueue_scripts', 'asciidoc_css_and_scripts' );


 //add css and script
function asciidoc_css_and_scripts(){
	// wp_enqueue_script( 'opal.min.js', plugins_url('/js/opal.min.js', __FILE__) , array(), '' );
	wp_enqueue_script( 'asciidoctor.js', plugins_url('/js/asciidoctor-all.min.js', __FILE__) , array(), '' );
    wp_enqueue_script( 'setting.js', plugins_url('/js/setting.js', __FILE__) , array(), '' );
    wp_enqueue_script( 'jquery' );
    // wp_enqueue_style( 'wpasciidoc.css', plugins_url('/css/wpasciidoc.css', __FILE__) , array(), '' );

    $wpasc_check_asciidoccss = get_option('wpasc_check_asciidoccss');
    if($wpasc_check_asciidoccss == '1'){
    wp_enqueue_style( 'asciidoctor.css', plugins_url('/js/css/asciidoctor.css', __FILE__) , array(), '' );
    }

    // $wpasc_check_jquery = get_option('wpasc_check_jquery');
    // if($wpasc_check_jquery == '1'){
    // wp_enqueue_script( 'jquery.js', '//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js' );
    // }

    $wpasc_check_highlight = get_option('wpasc_check_highlight');
    if($wpasc_check_highlight == '1'){
    wp_enqueue_script( 'highlight.js', plugins_url('/js/highlight.js', __FILE__) , array(), '' );
    wp_enqueue_script( 'setting_highlight.js', plugins_url('/js/setting_highlight.js', __FILE__) , array(), '' );
    wp_enqueue_style( 'highlight.css', '//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/styles/default.min.css');
    }

// wp_enqueue_script( 'opal.js', plugins_url('/js/vendor/opal.js', __FILE__) , array(), '' );
// wp_enqueue_script( 'asciidoctor.js', plugins_url('/js/vendor/asciidoctor.js', __FILE__) , array(), '' );
// wp_enqueue_script( 'highlight.js', plugins_url('/js/vendor/highlight.min.js', __FILE__) , array(), '' );
// wp_enqueue_script( 'renderer.js', plugins_url('/js/renderer.js', __FILE__) , array(), '' );
}



// if select  Individual posts mode display check field in post edit pages
$wpasc_mode_select = get_option('wpasc_mode_select');
if($wpasc_mode_select == '0'){
    function add_wpasciidoc_custom_inputbox() {

    	$screens = array( 'post', 'page','custom_post_type' );

	   foreach ( $screens as $screen ) {

		add_meta_box(
			'wpasciidoc_id',
			__( 'Asciidoc', 'Asciidoc' ),
			'wpasciidoc_custom_field',
			$screen, 'side', 'high'
		  );
	   }
    }

add_action('admin_menu', 'add_wpasciidoc_custom_inputbox');
add_action('save_post', 'save_wpasciidoc_custom_postdata');



// make custom field
function wpasciidoc_custom_field(){


       $id = get_the_ID();

        $get_wpasciidoc_checkbox = get_post_meta($id,'wpasciidoc_checkbox',true);
        // $wpasciidoc_checkbox =$get_wpasciidoc_checkbox  ? $get_wpasciidoc_checkbox  : array();
        echo '<label><input type="checkbox" name="wpasciidoc_checkbox[]" value="1"' . (!empty($get_wpasciidoc_checkbox) ? ' checked="checked" ' : null) . '.>Asciidoc</label>';
}

// update process
function save_wpasciidoc_custom_postdata($post_id){
    //input value
    $wpasciidoc_checkbox=isset($_POST['wpasciidoc_checkbox']) ? $_POST['wpasciidoc_checkbox']: null;
    //date on db
    $wpasciidoc_checkbox_ex = get_post_meta($post_id, 'wpasciidoc_checkbox', true);
    if($wpasciidoc_checkbox){
      update_post_meta($post_id, 'wpasciidoc_checkbox',$wpasciidoc_checkbox);
    }else{
      delete_post_meta($post_id, 'wpasciidoc_checkbox',$wpasciidoc_checkbox_ex);
    }
}

}

//change asciidoc to html
add_filter('the_content','wpasciidoc_custom');

function wpasciidoc_custom($contentData){

    $id = get_the_ID();
    $custom = get_post_meta($id, "wpasciidoc_checkbox", true);
    if (is_array($custom)) {
    $custom = implode($custom);
    }

    // make javascript after each post for quick change asciidoc to html
    $wpasc_mode_select = get_option('wpasc_mode_select');
    if($wpasc_mode_select == '0'){

         if($custom == "1"){

         return '<div class="asciidoc_entry" style="display:none;">'.$contentData.'</div><div class="asciidoc_entry_display"></div><script type ="text/javascript"> var content = jQuery(".post-'.$id.' .asciidoc_entry")[0].innerHTML.trim(); content = escapeHtml(content); ;var html = Opal.Asciidoctor.$convert(content);jQuery(".post-'.$id.' .asciidoc_entry_display")[0].innerHTML = html</script>';
           }else{
        	$contentData = wpautop( $contentData );
         	$contentData = wptexturize( $contentData );
        	return $contentData;
         }
    }elseif ($wpasc_mode_select == '1') {

        return '<div class="asciidoc_entry" style="display:none;">'.$contentData.'</div><div class="asciidoc_entry_display"></div><script type ="text/javascript"> var content = jQuery(".post-'.$id.' .asciidoc_entry")[0].innerHTML.trim(); content = escapeHtml(content); var html = Opal.Asciidoctor.$convert(content);jQuery(".post-'.$id.' .asciidoc_entry_display")[0].innerHTML = html</script>';

    }else{
            $contentData = wpautop( $contentData );
            $contentData = wptexturize( $contentData );
            return $contentData;
    }


}

//remove_filter wpautop and wptexturize
add_action('init', function() {
    // remove_filter('the_excerpt', 'wpautop');
    remove_filter('the_content', 'wpautop');
    remove_filter('the_content', 'wptexturize');
    // remove_filter('the_content', 'convert_chars');
});

add_filter('tiny_mce_before_init', function($init) {
    $init['wpautop'] = false;
    $init['apply_source_formatting'] = ture;
    return $init;
});

//add asciidoctor image format
$wpasc_check_image = get_option('wpasc_check_image');
if($wpasc_check_image == '1'){
function wpasciidoc_image_wrap($html, $id, $caption, $title, $align, $url, $size, $alt){
    list( $img_src, $width, $height ) = image_downsize($id, $size);

    $media_array = array();
    if ($width ==! ""){$width = 'width="'.$width.'"';$media_array[]=$width;}
    if ($height ==! ""){$height = 'height="'.$height.'"';$media_array[]=$height;}
    // if ($title ==! ""){$title = 'title="'.$esc_attr($title).'"';$media_array[]=$title;}
    // if ($caption ==! ""){$caption = 'caption="'.$caption.'"';$media_array[]=$caption;}
    if ($alt ==! ""){$alt = 'alt="'.esc_attr($alt).'"';$media_array[]=$alt;}
    if ($url ==! ""){$url = 'link="'.$url.'"';$media_array[]=$url;}
    if ($align ==! ""){$align = 'align="'.$align.'"';$media_array[]=$align;}
    $comma_separated = implode(", ", $media_array);


    $html = 'image::' . esc_attr($img_src) . '['.$comma_separated.']';

    return $html;
}
add_filter('image_send_to_editor','wpasciidoc_image_wrap',10,8);

define('CAPTIONS_OFF', true);
add_filter('disable_captions', create_function('','return true;'));
}

?>
