<?php  ?>

<script>
    jQuery(document).ready(function($){
        $( 'body' ).on( 'updated_checkout', function() {

            var options = "<?php echo get_option('woocommerce_pjbank_cartao_settings')['juros_vista'] ?>";

            console.log(options);

            $(".payment_method_pjbank_cartao").append(" \
                <div class='dados-cartao col2-set' style='display: none'> \
                    <div class='box_pagamento col-1'> \
                        <div class='form-row'> \
                            <p class='numero-cartao form-row'> \
                                <label for='numero_cartao'>Número do cartão</label> \
                                <input type='text' name='numero_cartao' class='input-text'> \
                            </p> \
                            <p class='nome-cartao form-row form-row-first'> \
                                <label for='nome_cartao'>Nome impresso no cartão</label> \
                                <input type='text' name='nome_cartao' class='input-text'> \
                            </p> \
                            <p class='cpf-cartao form-row form-row-last'> \
                                <label for='cpf_cartao'>CPF do portador do cartão</label> \
                                <input type='text' name='cpf_cartao' class='input-text'> \
                            </p> \
                            <p class='vencimento-cartao form-row form-row-first'> \
                                <label for=''>Data de vencimento</label> \
                                <input type='text' name='mes_vencimento' class='input-text input-data-mes'> <input type='text' name='ano_vencimento' class='input-text input-data-ano'> \
                            </p> \
                            <p class='codigo-cartao form-row form-row-last'> \
                                <label for='codigo_cvv'>Código CVV</label> \
                                <input type='text' name='codigo_cvv' class='input-text'> \
                            </p> \
                        </div> \
                    </div> \
                    <div class='col-1'> \
                    </div> \
                </div> "
            );

            if($('#payment_method_pjbank_cartao').is(':checked')) {
                $(".dados-cartao").slideDown("fast");
            }

            $(".payment_methods .input-radio").on('click', function(e){
                if($('#payment_method_pjbank_cartao').is(':checked')) {
                    $(".dados-cartao").slideDown("fast");
                }else{
                    $(".dados-cartao").slideUp("fast");
                }
            })
        });
    });
</script>