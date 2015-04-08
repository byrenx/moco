<?php
defined('_BASEPATH') or die("No direct Access Allowed!");
if(!intval($CF->offline)){  
    if(file_exists(INCLUDES.DS.'framework'.ext)){
        $framework = INCLUDES.DS.'framework'.ext;
    }else{
        trigger_error ("File not found.Check the location of the file!", E_USER_WARNING);
    }
    $CF->MetaDesc .= " The MSU Main Campus - Marawi is the largest and the flagship campus of the MSU System. It is a leading institution in producing top "
            . " graduates and renowned for its excellence and promoting cultural integration in the Philippines, particularly in MINSUPALA (Mindanao-Sulu-Palawan) Region.";
    $meta = array('description'=>$CF->MetaDesc,'keywords'=>$CF->MetaKeys,'author'=>$CF->client_meta_author ,'charset'=>$CF->client_charset,
                   'owner'=>$CF->client_meta_owner,'copyright'=>$CF->MetaRights);
    html_head_init($CF->sitename, $meta);
    load_css(URL . THEMES . "/" . 'reset.css');    
    readfolder(THEMES."/".$CF->client_theme);
    setIco(URL . $CF->client_ico);
    
   /***please remove if you don't need a gallery DYNAMIC GALLERY IS COMING*/
   
    if(isset($_SESSION['pType'])){
        //session_destroy($_SESSION['pType']);
        unset($_SESSION['pType']);
    }
    
    /**PLEASE REMOVE THIS IF YOU DON'T NEED A GALLERY**/
    end_head();    
    include ( $framework );
    html_end();
}else{
    header("Location:".OFFLINE.DS."?error=1");
    //just include the offline page
    exit;
} 
?>