<?php 
	global $wpdb;
	$data = serialize($_POST);
	//$current_user = wp_get_current_user();
	$save_data = array(
		'post_author'=>1,
		'post_content'=>$data,
		'post_type'=>'orders',
		);
	$wpdb->insert( wp_posts, $save_data);
	echo $wpdb->insert_id;
?>