<?php

class WC_PJBank_Gateway_Cartao extends WC_Payment_Gateway {
    function __construct(){
        // define configurações basicas do plugin
        $this->id = "pjbank_cartao";
        $this->method_title = "PJBank - Cartão";
        $this->method_description = "Metodo de pagamento PJBank";
        $this->has_fields = false;

        //funções hierarquicas do woocommerce
        $this->init_form_fields();
        $this->init_settings();

        //os campos que foram iniciados no plugin
        $this->title = $this->settings['title_cartao'];
        $this->token = $this->settings['credencial_cartao'];

        add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
    }

    public function init_form_fields(){
        $this->form_fields = array(
            'enabled' => array(
                'title' => __( 'Enable/Disable', 'woocommerce' ),
                'type' => 'checkbox',
                'label' => __( 'Pagamento Habilitado', 'woocommerce' ),
                'default' => 'no'
            ),
            'homologacao' => array(
                'title' => __( 'Ambiente Homologação ?'),
                'type' => 'checkbox',
                'description' => __( 'Informa ao plugin ambiente de homologação', 'woocommerce'),
                'default' => 'yes',
            ),
            'credencial_cartao' => array(
                'title' => __( 'Credencial', 'woocommerce' ),
                'type' => 'text',
                'description' => __( 'Adicione sua credencial', 'woocommerce' ),
                'default' => __( '', 'woocommerce' ),
                'desc_tip'      => true,
            ),
            'chave_cartao' => array(
                'title' => __( 'Chave', 'woocommerce' ),
                'type' => 'text',
                'description' => __( 'Adicione sua chave', 'woocommerce' ),
                'default' => __( '', 'woocommerce' ),
                'desc_tip'      => true,
            ),
            'title_cartao' => array(
                'title' => __( 'Título', 'woocommerce' ),
                'type' => 'text',
                'description' => __( 'Adicione um título para seu metodo de pagamento', 'woocommerce' ),
                'default' => __( 'Cartão de Crédito', 'woocommerce' ),
                'desc_tip'      => true,
            ),
            'juros_vista' => array(
                'title' => __( 'Juros pagamento à vista'),
                'type' => 'number',
                'description' => __( 'Porcentagem de juros que será cobrado no pagamento à vista', 'woocommerce'),
                'desc_tip' => true,
            ),
            'juros_pri' => array(
                'title' => __( 'Juros parcelamento 2x ~ 3x'),
                'type' => 'number',
                'description' => __( 'Porcentagem de juros que será cobrado no parcelamento 2x até 3x', 'woocommerce'),
                'desc_tip' => true,
            ),
            'juros_sec' => array(
                'title' => __( 'Juros parcelamento 4x ~ 6x'),
                'type' => 'number',
                'description' => __( 'Porcentagem de juros que será cobrado no parcelamento 4x até 6x', 'woocommerce'),
                'desc_tip' => true,
            ),
            'juros_tri' => array(
                'title' => __( 'Juros parcelamento 7x ~ 12x'),
                'type' => 'number',
                'description' => __( 'Porcentagem de juros que será cobrado no parcelamento 7x até 12x', 'woocommerce'),
                'desc_tip' => true,
            ),
            'webhook' => array(
                'title' => __( 'URL Webhook'),
                'type' => 'text',
                'description' => __( 'URL que será chamada em caso de alterações na transação (consultar documentação do PJBank)', 'woocommerce'),
                'desc_tip' => true,
            ),
        );
    }

    public function process_payment($order_id){
        global $woocommerce;
        $order = wc_get_order( $order_id );
        
        $token_cartao = $_POST['pjbank-token'];

        $nome_cartao = $_POST['nome_cartao'];
        $cpf_cartao = $_POST['cpf_cartao'];
        $mes_vencimento = $_POST['mes_vencimento'];
        $ano_vencimento = $_POST['ano_vencimento'];
        $codigo_cvv = $_POST['codigo_cvv'];
        $total = $order->total;
        $parcelamento = $_POST['parcelamento'];
        $parcelas = $_POST['parcelas'];
        if($parcelas==1){
            $juros =  $this->get_option('juros_vista');
        }else if(in_array($parcelas,array(2,3))){
            $juros =  $this->get_option('juros_pri');
        }else if(in_array($parcelas,array(4,5,6))){
            $juros =  $this->get_option('juros_sec');
        }else if(in_array($parcelas,array(7,8,9,10,11,12))){
            $juros =  $this->get_option('juros_tri');
        }else{
            return array(
                'result' => 'error',
                'redirect' => $this->get_return_url( $order )
            );
        }
        $total = number_format(floatval ($order->total * pow ( (1 + ($juros/100)), $parcelas )), 2);

        // Busca o usuário logado e as configurações do Plugin
        $current_user = wp_get_current_user();
        $user_id = get_current_user_id();
        $options = get_option('woocommerce_pjbank_cartao_settings');

        update_post_meta( $order_id, '_pj_cartao', true);
        update_post_meta( $order_id, '_juros', $juros);
        update_post_meta( $order_id, '_parcelamento', $parcelamento );
        update_post_meta( $order_id, '_parcelas', $parcelas );
        update_post_meta( $order_id, '_valor_total', $total );

        // Reduce stock levels
        // $order->reduce_order_stock();

        // Remove cart
        // $woocommerce->cart->empty_cart();
        $api = $options["homologacao"] ? "sandbox" : "api";
        // Inicia chamada cURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://".$api.".pjbank.com.br/recebimentos/".$options['credencial_cartao']."/transacoes",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",            
            CURLOPT_POSTFIELDS => json_encode(array(
                "token_cartao" => $token_cartao,
                "nome_cartao" => $nome_cartao,
                "mes_vencimento" => $mes_vencimento,
                "ano_vencimento" => $ano_vencimento,
                "cpf_cartao" => $cpf_cartao,
                "email_cartao" => get_user_meta( $user_id, 'billing_email', true ),
                "celular_cartao" => get_user_meta( $user_id, 'billing_phone', true),
                "codigo_cvv" => $codigo_cvv,
                "valor" => $total,
                "parcelas" => $parcelas,
                "webhook" => $this->get_option('webhook')
            )),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json",
                "x-chave: ".$options['chave_cartao']." "
            ),
        )); 
        // Retorno da API é salvo no $response
        $response = curl_exec($curl);
        curl_close($curl);
        
        // Adiciona custom note no pedido, com o JSON que retorna da API
        $order->add_order_note('Response: '.$response);

        $response = json_decode($response);

        foreach ($response as $key => $value) {
            // $order->add_order_note($key, $value);
            if($key == 'status'){
                if(($value != 200) && ($value != 201)){
                    $error = true;
                }else{
                    $order->update_status('completed');
                }
            }
            if($key == 'msg'){
                if($error){
                    wc_add_notice( __('Erro de pagamento: ', 'woothemes') . $value, 'error' );
                }
            }
        }

        // Return thankyou redirect
        return array(
            'result' => 'success',
            'redirect' => $this->get_return_url( $order )
        );
    }

    public function admin_options(){
        echo '<h3>'.__('PJBank - Cartão de Crédito', 'woocommerce').'</h3>';
        echo '<p>'.__('Receba pagamentos de cartão através do PJBank.').'</p>';
        echo '<table class="form-table">';
        // Generate the HTML For the settings form.
        $this -> generate_settings_html();
        echo '</table>';
    }

}
