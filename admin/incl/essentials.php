<?php

    //frontend purpose data
    define('SITE_URL', 'http://127.0.0.1/hotel-website/');
    define("ABOUT_IMG_PATH", SITE_URL.'images/about/');

    
    //backend upload process needs this data
    define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'].'/hotel-website/images/');
    define('ABOUT_FOLDER', 'about/');

    function adminLogin(){
        session_start();
        if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
        // if(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true){    
            // echo "<script>
            // window.location.href='index.php';
            // </script>";
            header("Location: /hotel-website/admin/index.php");
            exit;
        }
        // session_regenerate_id(true); 
    }

    // function redirect($url){
    //     echo "<script>
    //         window.location.href='$url';
    //         </script>";
    // }

    function redirect($path){    
        if(isset($_SERVER["HTTPS"]) && S_SERVER['HTTPS'] != 'off'){
            $protocol = "https";
        }else {
            $protocol = "http";
        }
       // header("Location: article.php?id=$id"); This is a relative url that works only newer browsers
    
        header("Location: $path"); // header("Location: article.php?id=$id"); This is an absolute url that works on all browsers
        exit;    
    }

    function alert($type, $msg){
        $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
        echo "                   
            <div class='alert $bs_class alert-dismissible fade show custom-alert' role='alert'>
                <strong class='me-3'>$msg</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>             
            </div>                  
        ";
    } 

    function uploadImage($image, $folder){
        $valid_mime = ['image/jpeg','image/png', 'image/webp'];
        $img_mime = $image['type'];

        if(!in_array($img_mime, $valid_mime)){
            return 'inv_img';// invalid image mime or format
        }else if($image['size']/(1024*1024)>2){
            return "inv_size"; //invalid size greater than 2mb              
        }else{
            $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111, 99999).'.$ext';
            
            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'], $img_path)){
                return $rname;
            }else{
                return 'upd_failed';
            }
        }
    }

    function deleteImage($image, $folder){

        if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
            return true;
        }else{
            return false;
        }

    }


?>

