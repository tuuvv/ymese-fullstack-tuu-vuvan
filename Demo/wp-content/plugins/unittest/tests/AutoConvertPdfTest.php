<?php

class AutoConvertPdfTest extends WP_UnitTestCase{


    public function testpdfconvert(){
        $content = '<h1>The img element</h1> <img src="https://www.w3schools.com/tags/img_girl.jpg" alt="Girl in a jacket" width="500" height="600">';
        
        if (php_sapi_name() == 'cli') {
            $url = "http://internationalsamuel.com/APISEOTOOL/public/index.php/api/exportpdf";
        }
        else {
            $url = "http://api.test/index.php/api/exportpdf";
        }
        

        

        $postdata = '{"text": '.$content.'}';
    
        $ch = curl_init($url); 
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        
        // Check the return value of curl_exec(), too
        if ($result === false) {
         echo curl_error($ch);
        }
        curl_close($ch);
        $result = json_decode($result, true);
       
            $this->assertTrue($result['code'] == 200);
    
    }
  
 }