<?php
/*
Plugin Name: InstaLivit
Plugin URI: www.mgnw.com
Description: Simple instagram viewer
Version: 1.1
Author: Mulya Gunawan
Author URI: www.mgnw.com
License: no license
*/

// <!-- [instalivit user="raisa6690,chelseaislan" hashtag="arsenal,chelsea"] -->

	add_action( 'http_request_args', 'no_ssl_http_request_args', 10, 2 );
    function no_ssl_http_request_args( $args, $url ) {
        $args['sslverify'] = false;
        return $args;
    }

    function getInstaID($username){

		$instagram_client_user = wp_remote_get( "https://api.instagram.com/v1/users/search?q=".$username."&access_token=141970.467ede5.edbc9c37472d41b790e1db8948793f11" );

	    $instagram_client_user = json_decode( $instagram_client_user['body'] );

	    foreach($instagram_client_user->data as $user)
	    {
	        if($user->username == $username)
	        {
	            return $user->id;
	        }
	    }
    return '00000000';
	}

	function instalivit_function($atts,$content = null){
		 extract(shortcode_atts(array(
      		'user' => 'username',
      		'hashtag' => 'hashtagname'
   		), $atts));

		list($hashtag1,$hashtag2) = explode(',',$hashtag);
		list($user1,$user2) = explode(',',$user);

		$str = '';

	// user 1 start

		$userid1 = getInstaID($user1); 

		$instagram_client_user1 = wp_remote_get( "https://api.instagram.com/v1/users/".$userid1."/media/recent/?access_token=141970.467ede5.edbc9c37472d41b790e1db8948793f11" );

        $instagram_client_user1 = json_decode( $instagram_client_user1['body'] );
        $user1 = array();
        $n = 0;

   		foreach ( $instagram_client_user1->data as $d ) {
	        $user1[$n]['thumbnail'] = $d->images->thumbnail->url;
	        $n++;
    	}

    	foreach ( $user1 as $data ) {
        	$str .= '<div style="float:left;"><img src="'.$data['thumbnail'].'"></div>';
    	}

	// user 2 start

		$userid2 = getInstaID($user2); 

		$instagram_client_user2 = wp_remote_get( "https://api.instagram.com/v1/users/".$userid2."/media/recent/?access_token=141970.467ede5.edbc9c37472d41b790e1db8948793f11" );

        $instagram_client_user2 = json_decode( $instagram_client_user2['body'] );
        $user2 = array();
        $n = 0;

   		foreach ( $instagram_client_user2->data as $d ) {
	        $user2[$n]['thumbnail'] = $d->images->thumbnail->url;
	        $n++;
    	}

    	foreach ( $user2 as $data ) {
        	$str .= '<div style="float:left;"><img src="'.$data['thumbnail'].'"></div>';
    	}

	// hashtag 1 start

        $instagram_client_hashtag1 = wp_remote_get( "https://api.instagram.com/v1/tags/".$hashtag1."/media/recent?access_token=141970.467ede5.edbc9c37472d41b790e1db8948793f11" );

        $instagram_client_hashtag1 = json_decode( $instagram_client_hashtag1['body'] );
        $hashtag_data1 = array();
        $n = 0;

   		foreach ( $instagram_client_hashtag1->data as $d ) {
	        $hashtag_data1[$n]['thumbnail'] = $d->images->thumbnail->url;
	        $n++;
    	}

    	foreach ( $hashtag_data1 as $data ) {
        	$str .= '<div style="float:left;"><img src="'.$data['thumbnail'].'"></div>';
    	}

    // hashtag 2 start

        $instagram_client_hashtag2 = wp_remote_get( "https://api.instagram.com/v1/tags/".$hashtag2."/media/recent?access_token=141970.467ede5.edbc9c37472d41b790e1db8948793f11" );

        $instagram_client_hashtag2 = json_decode( $instagram_client_hashtag2['body'] );
        $hashtag_data2 = array();
        $n = 0;

    	foreach ( $instagram_client_hashtag2->data as $d ) {
	        $hashtag_data2[$n]['thumbnail'] = $d->images->thumbnail->url;
	        $n++;
    	}	

    	foreach ( $hashtag_data2 as $data2 ) {
        	$str .= '<div style="float:left;"><img src="'.$data2['thumbnail'].'"></div>';
    	}	

		return $str;
	}

	function register_instalivit(){
		add_shortcode('instalivit','instalivit_function');
	}

	add_action( 'init', 'register_instalivit');
?>