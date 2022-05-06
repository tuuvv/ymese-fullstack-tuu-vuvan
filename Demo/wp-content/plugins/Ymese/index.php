<?php

/*
Plugin Name: ymese verify
Plugin URI: tuuvv.uit@gmail.com
Description: auto generation pdf from post in demo category
Version: 1.0.1
Author: Vu Van Tuu.
Author URI: https://youtube.com/tuuvuvan
License: GPLv2 or later
*/

/**
 * -------------------------------------------------------
 * CREATE DATABASE
 *  Absolute path to the WordPress directory.
 * -------------------------------------------------------
 */
 
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');
/** do the active hook */
require_once dirname(__FILE__). '/includes/DB_file.php';

register_activation_hook( __FILE__, 'DB_tb_create' );

/**
 * DEFINE PATH
 *  Absolute path to the WordPress directory. 
 * */

define('ADMIN_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('ADMIN_PLUGIN_IMAGE_URL', ADMIN_PLUGIN_URL.'/images');
define('ADMIN_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
define('ADMIN_PLUGIN_VIEW_PATH', ADMIN_PLUGIN_PATH. 'views/');
define("ADMIN_AJAX_ADMIN_URL", admin_url("/admin-ajax.php",__FILE__  ));

//khai báo table chứa thông tin thống kê
function pdf_table() {
    global $wpdb;
    return $wpdb->prefix.'ymese_pdf';
}

/**
 * -------------------------------------------------------
 * Make menu
 * -------------------------------------------------------
 */
function menu_tuuvv(){
    add_menu_page( "Ymese Menu", "Ymese_menu", "manage_options", "Ymese-menu", "ymese_page", "dashicons-superhero-alt", 21);
}
add_action( "admin_menu", 'menu_tuuvv');//hook & callback
function ymese_page()
{
    require_once ADMIN_PLUGIN_VIEW_PATH.'ymese.php';
}
require_once ('api.php');
require_once ('simple_html_dom.php');

 //khai báo bảng tại đây
function ymese_pdf_table() {
   
    global $wpdb;
    return  $wpdb->prefix.'ymese_pdf';
  }



//Gọi API laravel tại đây

function get_info_pdf_post( $post_id) {

    // Only set for post_type = post!
    
    if ( 'post' !== get_post_type($post_id) ) {
    
        return;
    
    }
    
    // If this is just a revision then do no thing
    
    if ( wp_is_post_revision( $post_id ) ) {
    
        return;
    
    }
    
    // Not set for post_status = dralf
    
    if ( get_post($post_id)->post_status == 'pending' || get_post($post_id)->post_status == 'draft' ) {
    
        return;
    
    }
    
        global $wpdb;
        
        //lấy content
        
        $content_post = get_post($post_id );
        
        $content = $content_post->post_content;
        $content = str_get_html('<!DOCTYPE html><html lang="en">'.$content.'</html>');

       
        $temp = postdemo($content);
        
        // var_dump($temp);
        // die();
        $link_dowload = $temp["text"];
        // echo $link_dowload;
            
            $name = time(). "issue";
            
            $wpdb->insert(ymese_pdf_table(), array(
            
            "nameissue" => $name ,
            
            "urlpdf" => $link_dowload
            
            ));
    
}
    
add_action( 'save_post', 'get_info_pdf_post' );


////////////////////////////////unit test//////////////////////////////////////////

function km_set_remote_image_as_featured_image( $post_id, $url, $attachment_data = array() ) {

    $download_remote_image = new KM_Download_Remote_Image( $url, $attachment_data );
    $attachment_id         = $download_remote_image->download();
  
    if ( ! $attachment_id ) {
      return false; 
    }
  
    return set_post_thumbnail( $post_id, $attachment_id );
  }
  function Generate_Featured_Image(  $post_id ,$image_url ){
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $filename = basename($image_url);
    if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
    else                                    $file = $upload_dir['basedir'] . '/' . $filename;
    file_put_contents($file, $image_data);
  
    $wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
    $res2= set_post_thumbnail( $post_id, $attach_id );
  }

  add_action("wp_ajax_runcp", "runcp");
add_action("wp_ajax_nopriv_runcp", "runcp");

function runcp()
{

    

      if(!$_REQUEST["run"]){
        // Code Crawler
        $html_content = file_get_html('https://eventstar.vn/category/dien-anh/');
        $list_post = $html_content->find('.post-listing .item-list');
   
    
        if ( ! function_exists( 'post_exists' ) ) :
            require_once( ABSPATH . 'wp-admin/includes/post.php' );
        endif;

        if (!empty($list_post)):
          foreach ($list_post as $post){
                $post_link = $post->find('.post-box-title a', 0)->href;
             
                //Post Detail
                $html_detail = file_get_html($post_link);
                $title = $html_detail->find('.post-inner h1', 0)->plaintext;
                $content = $html_detail->find('.post-inner .entry', 0)->innertext;
            
                $content = preg_replace( '@<(a)[^>]*?>.*?</\\1>@si', '', $content );// remove all link

                //set first image to thumnails
                $i = 0;

                $imgarr = array();
                $pq =   preg_split('/(<img[^>]+\>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
                foreach($pq as $a){
                    if (str_contains($a, '<img')){
                        $imgarr[$i] = $a;
                        $i = $i+1;
                    }
                } 
                if (count($imgarr)!= 0){
                $doc = new DOMDocument();
                libxml_use_internal_errors(true);
                $doc->loadHTML( $imgarr[0] );
                $xpath = new DOMXPath($doc);
                $imgs = $xpath->query("//img");
                    for ($i=0; $i < $imgs->length; $i++) {
                    $img = $imgs->item($i);
                    $src = $img->getAttribute("src");
                     }
                }
                if (str_contains($src, '.gif')){
                    $doc = new DOMDocument();
                    libxml_use_internal_errors(true);
                    $doc->loadHTML( $imgarr[1] );
                    $xpath = new DOMXPath($doc);
                    $imgs = $xpath->query("//img");
                    for ($i=0; $i < $imgs->length; $i++) {
                        $img = $imgs->item($i);
                        $src = $img->getAttribute("src");
                    }
                }

                                                           
                if (post_exists($title)===0 ):
                    $args = array(
                        'post_type' => 'post',
                        'post_status' => 'publish',
                        'post_title' => $title,
                        'post_content' => $content
                    );
                  
                    
                    // if(str_contains($content, '<img')):
                            $post_id = wp_insert_post($args);

                        
                            if ($post_id>0):
                                wp_set_post_terms($post_id, 1,'category' );
                                Generate_Featured_Image( $post_id, $src );
                            endif;
                            if ($post_id):
                                // echo $title;
                                echo json_encode(array("status"=>1, "message"=>"crawler successfull"));
                                wp_die( );
                            endif;
                    // endif;
                
                endif;
           }
     
        endif;
    }
   


}