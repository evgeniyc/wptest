<?php
/*
Plugin Name:  WP Test Plugin
Plugin URI:  http ://example.com/wordpress-plugins/wpt-plugin 
Description:  This is a test plugin 
Version:  1.0 
Author: Chepur Evgeny
Author URI:  http://example.com 
License: GPLv2 
*/
?>
<?php
register_activation_hook(__FILE__, 'wpt_install');
function wpt_install() { 
	global $wp_version;
	if ( version_compare( $wp_version,  '3.5',  '<'  )  )  {
		wp_die(  'Этот плагин работает только с версией WordPress 3.5 или выше.'  );
	}
}

add_action('init',  'wpt_register_my_types'); 
function wpt_register_my_types()  { 
	register_post_type('products', 
		array(
			'labels'  => array(
				'name'  =>  'Продукты',
				'singular_name' => 'Продукт',
				'add_new' => 'Добавить новый',
				),
			'public'  => true,
			'taxonomies' => array('category', 'post_tag'),
			'menu_icon'   => 'dashicons-products',
			'has_archive' => true,
			'supports' => array('title','editor','thumbnail'),
			)
		);
	register_post_type('orders', 
		array(
			'labels'  => array(
				'name'  =>  'Заказы',
				'singular_name' => 'Заказ',
				'add_new' => 'Добавить новый',
				),
			'public'  => true,
			'menu_icon'   => 'dashicons-cart',
			'has_archive' => true,
			)
		);
	register_taxonomy('status', 'orders', array(
			'public'=> true,
			'labels' => array('name' => 'Статус'),
			'hierarchical' => true,
		)
	);
	register_taxonomy('delivery', 'orders', 
		array(
			'public' => true,
			'labels' => array('name' => 'Способ доставки'),
			'hierarchical' => true,
		)
	);
	//=====================================================
wp_insert_term(
	'Обрабатывается', // the term 
	'status', // the taxonomy
	array(
		'description'=> 'Заказ в обработке.',
		'slug' => 'processing',
	)
);
wp_insert_term(
	'Отправлен', // the term 
	'status', // the taxonomy
	array(
		'description'=> 'Заказ отправлен.',
		'slug' => 'sent',
	)
);
wp_insert_term(
	'Отклонен', // the term 
	'status', // the taxonomy
	array(
		'description'=> 'Заказ отклонен.',
		'slug' => 'rejected',
	)
);
wp_insert_term(
	'Доставка почтой', // the term 
	'delivery', // the taxonomy
	array(
		'description'=> 'Доставка почтой.',
		'slug' => 'mail_delivery',
	)
);
wp_insert_term(
	'Курьерская доставка', // the term 
	'delivery', // the taxonomy
	array(
		'description'=> 'Курьерская доставка.',
		'slug' => 'express_delivery',
	)
);
wp_insert_term(
	'Самовывоз', // the term 
	'delivery', // the taxonomy
	array(
		'description'=> 'Самовывоз.',
		'slug' => 'pickup',
	)
);
function wpt_add_styles()  
{  
    // Register the style like this for a plugin:  
    wp_register_style( 'wpt-style', plugins_url( '/css/wstyle.css', __FILE__ ));  
    // For either a plugin or a theme, you can then enqueue the style:  
    wp_enqueue_style( 'wpt-style' );  
}  
add_action( 'wp_enqueue_scripts', 'wpt_add_styles' );

function wpt_shortcode()
{
	if(isset($_GET['add']))
	{
		$id = $_GET['add'];
		$product = get_post($id);
		$current_user = wp_get_current_user();
		if ( !($current_user instanceof WP_User) ) return;
		$products = get_posts(array('post_type'=>'products','order'=>'asc','posts_per_page'=>-1));
		$delivery_method = wp_get_post_terms( 0, 'delivery', array('fields'=>'name'));
		$proc_link = plugins_url( 'proc.php', __FILE__ );
		echo '<h1>Страница заказа</h1>';
		echo '<h3>'.$product->post_title.'</h3>';
		echo '	<form id="basket-form" method="post" action="http://localhost/wp/basket/">
				<label>Имя:</label><br>
				<input name="first_name" type="text" value="'.$current_user->user_firstname.'"><br>
				<label>Фамилия:</label><br>
				<input name="last_name" type="text" value="'.$current_user->user_lastname.'"><br>
				<label>email:</label><br>
				<input name="email" type="text" value="'.$current_user->user_email.'"><br>';
					
		echo '	<br><label>Список доступных<br> продуктов:</label><br>
				<select  name="prods">';
		foreach($products as $prod)
		{
			if($prod->ID == $id)
			{
				echo '<option selected value="'.$prod->ID.'">'.$prod->post_title.'</option>';
				continue;
			}
			echo '<option value="'.$prod->ID.'">'.$prod->post_title.'</option>';
			
		}
		echo '	</select><br>';
		echo '	<br><label>Способ доставки:</label><br>
				<select  name="delivery">';
		echo '	<option value="mail_delivery">Доставка почтой</option>
				<option value="express_delivery">Курьерская доставка</option>
				<option value="pickup">Самовывоз</option>
				</select><br><br>
				<label>Выбранный продукт:</label><br>
				<input name="prod_name" type="text" value="'.$product->post_title.'"><br>
				<input name="prod_id" type="hidden" value="'.$id.'">
				<input name="basket-order" type="submit" value="Подтвердить заказ">
		</form>';
	}
	elseif(isset($_POST['basket-order']))
	{
		$current_user = wp_get_current_user();
		// Create post object
		$order_post = array(
		  'post_title'    => $_POST['prod_name'],
		  'post_content'  => $_POST['prod_id'],
		  'post_author'   => $current_user->ID,
		  'post_type'     => 'orders',
		);
		$order_delivery    => $_POST['delivery'],
		// Insert the post into the database
		$post_id = wp_insert_post( $order_post );
		if($post_id)
		{
			wp_set_object_terms( $post_id, 'processing', 'status');
			wp_set_object_terms( $post_id, $order_delivery, 'delivery');
			echo '<h3>Заказ успешно сохранен</h3>';
			echo '<h3>id заказа '.$post_id.'</h3>';
		}
		else 
		{
			echo 'Ошибка сохранения заказа';
			print_r($order_post);
		}
	}
	else echo 'Корзина пуста';
}
add_shortcode('basket','wpt_shortcode');
	
}
?>
