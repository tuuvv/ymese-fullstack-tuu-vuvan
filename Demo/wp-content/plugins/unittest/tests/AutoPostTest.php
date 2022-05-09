<?php

class AutoPostTest extends WP_UnitTestCase{

  
 public function testAutoPost()
    {
           
        
        $content = '<h1>The img element</h1> <img src="https://www.w3schools.com/tags/img_girl.jpg" alt="Girl in a jacket" width="500" height="600">';
        
                        $args = array(
                            'post_type' => 'post',
                            'post_status' => 'publish',
                            'post_title' => "Đây là title test",
                            'post_content' => $content
                        );
                      
                        
                        
                                $post_id = wp_insert_post($args);
    
                            
                                if ($post_id>0):
                                    wp_set_post_terms($post_id, 1,'category' );
                                  
                                endif;
                                if ($post_id):
                                    print_r($post_id);
                                    $this->assertTrue($post_id== true);
                                else:
                                    $this->assertTrue($post_id== true);
                                endif;
                    
                                
    
    
    }

   

}

?>