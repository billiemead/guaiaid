<?php 
    if (!defined('ABSPATH')) { 
            exit; 
    } 
    add_action("wp_ajax_add_to_wishlist", "guai_aid_add_to_wishlist");
    add_action("wp_ajax_nopriv_add_to_wishlist", "guai_aid_add_to_wishlist");
    function guai_aid_add_to_wishlist() 
    {
    	if( isset($_POST['pid']) && ($pid=trim($_POST['pid'])) && is_numeric($pid) && ($uid=get_current_user_id()) )
    	{
    		$ids = (array)get_metadata( 'user', $uid, 'wishlist_items',true );
    		if(!in_array($pid,$ids) ){
    			$ids[]=$pid;
    		}
    		$ids=array_filter($ids,'trim');
       		if(update_metadata( 'user', $uid, 'wishlist_items',$ids)){
    			echo 'true';
    		}else{
    			echo 'false';
    		}
   		}
    	exit;
    }

    add_action("wp_ajax_remove_wishlist", "guai_aid_remove_wishlist");
    add_action("wp_ajax_nopriv_remove_wishlist", "guai_aid_remove_wishlist");
    function guai_aid_remove_wishlist() 
    {
    	if( isset($_POST['pid']) && ($pid=trim($_POST['pid'])) && is_numeric($pid) && ($uid=get_current_user_id()) )
    	{
    		$ids = (array)get_metadata( 'user', $uid, 'wishlist_items',true );
    		if(in_array($pid,$ids) ){
    			$ids = array_diff($ids, array($pid));
    		}
    		$ids=array_filter($ids,'trim');
       		if(update_metadata( 'user', $uid, 'wishlist_items',$ids)){
    			echo 'true';
    		}else{
    			echo 'false';
    		}
   		}
    	exit;
    }
?>