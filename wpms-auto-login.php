<?php
/*
 * Plugin Name: WPMS Auto Login on Activation
 * Plugin URI: http://buddydev.com/plugins/wpms-autologin-on-activation/
 * Author: Brajesh Singh
 * Author URI: http://buddydev.com/members/sbrajesh
 * Version: 1.0
 * Network: true
 * Description: This plugin automatically logs in the user and redirects them to their blog(if any) when they activate their account
 * License: GPL
 * Last Modified: March 21, 2012
 */
class BPDevMSAutologin{
    
    private static $instance;

    private function __construct(){
        add_action('wpmu_activate_user', array($this,'login'),100,3);
        add_action('wpmu_activate_blog', array($this,'login_on_blog_activation'),100,5);

    }

    public static function get_instance(){
        if(!isset (self::$instance))
                self::$instance=new self();
        return self::$instance;
    }
    
    //login user on account ctivation
    function login($user_id,$pass,$meta){
            $user=new WP_User($user_id);

            if(empty($user))
                return;

            $auth_user= wp_authenticate($user->user_login, $pass);

           if(!is_wp_error($user)){
               wp_set_auth_cookie ($user_id, true,false);
               wp_safe_redirect(network_home_url());
           }
  
}

//login user on blog activation

    function login_on_blog_activation($blog_id, $user_id, $password, $title, $meta){
        $user=new WP_User($user_id);

        if(empty($user))
            return;

        $auth_user= wp_authenticate($user->user_login, $pass);

       if(!is_wp_error($user)){
           wp_set_auth_cookie ($user_id, true,false);

           //redirect to dashboard
           wp_safe_redirect(get_blogaddress_by_id($blog_id).'wp-admin/');
       }

    }

}

BPDevMSAutologin::get_instance();
?>