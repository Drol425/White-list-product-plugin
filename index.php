<?php
/*
Plugin Name: Whitelist
Description: Whitelist
Version: 1.0
Author: Drol
*/

?>

<?php

function template_whitelist($id_product){
		$id_p = $id_product['id_product'];
	$get_meta = get_post_meta( $id_p, 'whiteliste', true );

?>

	<button id="whitelist_button"><3 <?php if($get_meta){ echo $get_meta;}else{ echo 0; }?></button>
<script>

	jQuery(function($){
	$('#whitelist_button').click(function(){
		$.ajax({
			url: '<?php echo admin_url("admin-ajax.php") ?>',
			type: 'POST',
			data: 'action=whit&param1=<?php echo $id_p; ?>', // можно также передать в виде массива или объекта
			success: function( data ) {
				//$('#misha_button').text('Отправить');	
				//alert( data );
			}
		});
	});
});


</script>
<?php

}
add_action( 'wp_ajax_whit', 'template_white' ); // wp_ajax_{ЗНАЧЕНИЕ ПАРАМЕТРА ACTION!!}
add_action( 'wp_ajax_nopriv_whit', 'template_white' );  // wp_ajax_nopriv_{ЗНАЧЕНИЕ ACTION!!}
// первый хук для авторизованных, второй для не авторизованных пользователей
 
function template_white(){

	if($_POST['param1']){

		if ( is_user_logged_in() ) {

			$id_user = get_current_user_id();
			$id_product = $_POST['param1'];
			$user_last = get_user_meta( $id_user, 'whiteliste', true ); 
			$get_meta = get_post_meta( $id_product, 'whiteliste', true );

				if(!$user_last){
					$ball = $get_meta + 1;
					update_user_meta( $id_user, 'whiteliste', 1 );
					update_post_meta( $id_product, 'whiteliste', $ball );
					echo $ball;
				}

		}
	}
 
	die; 
}

	
add_shortcode('whitelist_product', 'template_whitelist');
