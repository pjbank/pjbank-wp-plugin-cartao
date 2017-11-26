<?php
/*
Plugin Name: Cartão PJBank
Plugin URI:  https://pjbank.com.br
Description: Plugin para receber pagamentos de cartão através do PJBank.
Version:     1.0
Author:      PJBank
Author URI:  https://pjbank.com.br
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
Domain Path: /languages
*/


function some_custom_checkout_field_cartao($checkout){
	$user_id = get_current_user_id();
	
}
add_action( 'woocommerce_after_order_notes', 'some_custom_checkout_field_cartao' );

function form_append_cartao(){
	global $woocommerce;
	$total = $woocommerce->cart->total;

	$options = get_option('woocommerce_pjbank_cartao_settings');
	$jurosVista = $options['juros_vista'];
	$jurosSec = $options['juros_sec'];
	$jurosTri = $options['juros_tri'];

	$enabled_cartao = $options['enabled'];

	?>
		<script>
			jQuery(document).ready(function($){

				var enabled_cartao = '<?php echo $enabled_cartao ?>';

				if(enabled_cartao == 'no'){
					enabled_cartao = false;
				}else{
					enabled_cartao = true;
				}
				console.log("Cartão: "+enabled_cartao);

				if(enabled_cartao){

					var jurosVista = "<?php echo $jurosVista; ?>";
					var jurosSec = "<?php echo $jurosSec; ?>";
					var jurosTri = "<?php echo $jurosTri; ?>";
					var total = "<?php echo $total; ?>";

					var ano = (new Date()).getFullYear();
					var lano = ano + 10;

					$( 'body' ).on( 'updated_checkout', function() {
						$(".payment_method_pjbank_cartao").append(" \
							<input type='hidden' class='post_cartao' name='post_cartao' value='false'>\
							<div class='dados-cartao col1-set' style='display: none'> \
								<div class='box_pagamento col-1'> \
									<div class='form-row'> \
										<p class='numero-cartao form-row form-row-first'> \
											<label for='numero_cartao'>Número do cartão</label> \
											<input type='text' name='numero_cartao' class='input-text pjbank-cartao'> \
										</p> \
										<p class='vencimento-cartao form-row form-row-last'> \
											<label for=''>Data de vencimento</label> \
											<input type='number' min='1' max='12' name='mes_vencimento' class='input-text input-data-mes' placeholder='MM'> <input type='number' name='ano_vencimento' min='"+ano+"' max='"+lano+"' class='input-text input-data-ano' placeholder='AAAA'> \
										</p> \
										<p class='nome-cartao form-row form-row-first'> \
											<label for='nome_cartao'>Nome impresso no cartão</label> \
											<input type='text' name='nome_cartao' class='input-text'> \
										</p> \
										<p class='cpf-cartao form-row form-row-last'> \
											<label for='cpf_cartao'>CPF do portador do cartão</label> \
											<input type='text' name='cpf_cartao' class='input-text'> \
										</p> \
										<p class='codigo-cartao form-row form-row-first'> \
											<label for='codigo_cvv'>Código CVV</label> \
											<input type='text' name='codigo_cvv' class='input-text'> \
										</p> \
										<p class='parcelamento-cartao form-row form-row-last'> \
											<label for='parcelas'>Quantidade de Parcelas</label> \
											<select name='total' class='input-text input-total'> \
												<option qtparcelas='1' parcelamento='"+retornaParcela(total, 1, jurosVista)+"' juros='"+jurosVista+"' value='"+retornaTotal(total, 1, jurosVista)+"' selected='selected'>À Vista - "+calculaJuros(total, 1, jurosVista)+"</option> \
												<option qtparcelas='2' parcelamento='"+retornaParcela(total, 2, jurosSec)+"' juros='"+jurosSec+"' value='"+retornaTotal(total, 2, jurosSec)+"'>2x - "+calculaJuros(total, 2, jurosSec)+"</option> \
												<option qtparcelas='3' parcelamento='"+retornaParcela(total, 3, jurosSec)+"' juros='"+jurosSec+"' value='"+retornaTotal(total, 3, jurosSec)+"'>3x - "+calculaJuros(total, 3, jurosSec)+"</option> \
												<option qtparcelas='4' parcelamento='"+retornaParcela(total, 4, jurosSec)+"' juros='"+jurosSec+"' value='"+retornaTotal(total, 4, jurosSec)+"'>4x - "+calculaJuros(total, 4, jurosSec)+"</option> \
												<option qtparcelas='5' parcelamento='"+retornaParcela(total, 5, jurosSec)+"' juros='"+jurosSec+"' value='"+retornaTotal(total, 5, jurosSec)+"'>5x - "+calculaJuros(total, 5, jurosSec)+"</option> \
												<option qtparcelas='6' parcelamento='"+retornaParcela(total, 6, jurosSec)+"' juros='"+jurosSec+"' value='"+retornaTotal(total, 6, jurosSec)+"'>6x - "+calculaJuros(total, 6, jurosSec)+"</option> \
												<option qtparcelas='7' parcelamento='"+retornaParcela(total, 7, jurosTri)+"' juros='"+jurosTri+"' value='"+retornaTotal(total, 7, jurosTri)+"'>7x - "+calculaJuros(total, 7, jurosTri)+"</option> \
												<option qtparcelas='8' parcelamento='"+retornaParcela(total, 8, jurosTri)+"' juros='"+jurosTri+"' value='"+retornaTotal(total, 8, jurosTri)+"'>8x - "+calculaJuros(total, 8, jurosTri)+"</option> \
												<option qtparcelas='9' parcelamento='"+retornaParcela(total, 9, jurosTri)+"' juros='"+jurosTri+"' value='"+retornaTotal(total, 9, jurosTri)+"'>9x - "+calculaJuros(total, 9, jurosTri)+"</option> \
												<option qtparcelas='10' parcelamento='"+retornaParcela(total, 10, jurosTri)+"' juros='"+jurosTri+"' value='"+retornaTotal(total, 10, jurosTri)+"'>10x - "+calculaJuros(total, 10, jurosTri)+"</option> \
												<option qtparcelas='11' parcelamento='"+retornaParcela(total, 11, jurosTri)+"' juros='"+jurosTri+"' value='"+retornaTotal(total, 11, jurosTri)+"'>11x - "+calculaJuros(total, 11, jurosTri)+"</option> \
												<option qtparcelas='12' parcelamento='"+retornaParcela(total, 12, jurosTri)+"' juros='"+jurosTri+"' value='"+retornaTotal(total, 12, jurosTri)+"'>12x - "+calculaJuros(total, 12, jurosTri)+"</option> \
											</select>\
											<input type='hidden' value='0' name='juros' class='input-juros'>\
											<input type='hidden' value='1' name='parcelas' class='input-parcelas'>\
											<input type='hidden' value='"+total+"' name='parcelamento' class='input-parcelamento'>\
										</p> \
										<input type='hidden' name='pjbank-token' class='pjbank-token'> \
									</div> \
								</div> \
							</div> "
						);

						if($('#payment_method_pjbank_cartao').is(':checked')) {
							$(".dados-cartao").slideDown("fast");
							$(".post_cartao").val("true");
						}

						$(".payment_methods .input-radio").on('click', function(e){	
							if($('#payment_method_pjbank_cartao').is(':checked')) {
								$(".dados-cartao").slideDown("fast");
								$(".post_cartao").val("true");
							}else{
								$(".dados-cartao").slideUp("fast");
								$(".post_cartao").val("false");
							}
						})
						
						$(".dados-cartao .input-total").change(function(){
							$(".dados-cartao .input-juros").val($(".dados-cartao .input-total option:selected").attr('juros'));
							$(".dados-cartao .input-parcelas").val($(".dados-cartao .input-total option:selected").attr('qtparcelas'));
							$(".dados-cartao .input-parcelamento").val($(".dados-cartao .input-total option:selected").attr('parcelamento'));
						});
					});
				}
			});
		</script>
	<?php
}
add_action('woocommerce_checkout_after_order_review', 'form_append_cartao');

function some_custom_checkout_field_process_cartao() {

	if ($_POST['post_cartao'] == 'true'){
		if(!$_POST['numero_cartao']){
			wc_add_notice( __( '<b>Número do cartão</b> é um campo obrigatório.' ), 'error' );
		}
		if(!$_POST['mes_vencimento']){
			wc_add_notice( __( '<b>Mês de vencimento do cartão</b> é um campo obrigatório.' ), 'error' );
		}
		if(!$_POST['ano_vencimento']){
			wc_add_notice( __( '<b>Ano de vencimento do cartão</b> é um campo obrigatório.' ), 'error' );
		}
		if(!$_POST['nome_cartao']){
			wc_add_notice( __( '<b>Nome do portador do cartão</b> é um campo obrigatório.' ), 'error' );
		}
		if(!$_POST['cpf_cartao']){
			wc_add_notice( __( '<b>CPF do portador do cartão</b> é um campo obrigatório.' ), 'error' );
		}
		if(!$_POST['codigo_cvv']){
			wc_add_notice( __( '<b>Código CVV do cartão</b> é um campo obrigatório.' ), 'error' );
		}
	}

}
add_action('woocommerce_checkout_process', 'some_custom_checkout_field_process_cartao');

function some_custom_checkout_field_update_order_meta_cartao($order_id ) {
}
add_action( 'woocommerce_checkout_update_order_meta', 'some_custom_checkout_field_update_order_meta_cartao' );

function init_pjbank_getway_cartao(){
	require_once("WC_PJBank_Gateway_Cartao.php");
	
	wp_enqueue_style('style-cartao', plugin_dir_url( __FILE__ ) . 'css/style.css');

	wp_enqueue_script('calcula-juros', plugin_dir_url( __FILE__ ) . 'js/calcula-juros.js');
	wp_enqueue_script('checkout-transparente', 'https://s3-sa-east-1.amazonaws.com/widgets.superlogica.net/embed.js');
}
add_action( 'wp_loaded', 'init_pjbank_getway_cartao' );

function add_pjbank_gateway_class_cartao( $methods ) { 
	$methods[] = 'WC_PJBank_Gateway_Cartao';
	return $methods;
}
add_filter( 'woocommerce_payment_gateways', 'add_pjbank_gateway_class_cartao' );

function custom_fields_admin_cartao($order){
	
	$pj_cartao = get_post_meta( $order->get_id(), '_pj_cartao');

	if($pj_cartao){
		
		$juros = get_post_meta( $order->get_id(), '_juros');
		if($juros[0] > 0){
			echo "<p><b style='color: #333'>Juros:</b> " . $juros[0] . "%</p>";
		}else{
			echo "<p><b style='color: #333'>Juros:</b> Indisponível</p>";
		}

		$parcelamento = get_post_meta( $order->get_id(), '_parcelamento');
		$parcelas = get_post_meta( $order->get_id(), '_parcelas' );
		if($parcelas[0] > 0){
			echo "<p><b style='color: #333'>Parcelas:</b> " . $parcelas[0] . "x de R$" . $parcelamento[0] ."</p>";
		}else{
			echo "<p><b style='color: #333'>Parcelas:</b> Indisponível</p>";
		}
		
		$valor_total = get_post_meta( $order->get_id(), '_valor_total' );
		if($valor_total[0] > 0){
			echo "<p><b style='color: #333'>Valor total c/ juros:</b> R$".  $valor_total[0] . "</p>";
		}else{
			echo "<p><b style='color: #333'>Valor total c/ juros:</b> Indisponível</p>";
		}
	}

}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'custom_fields_admin_cartao', 10, 1 );


