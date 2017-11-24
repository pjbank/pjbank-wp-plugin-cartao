# Plugin PJBank para WooCommerce
Plugin de Wordpress (WooCommerce) para pagamento por cartão de crédito.. 

### Como funciona ###

Após a instalação e configuração do plugin, a opção de cartão de crédito será adicionada as opções de pagamento, na última etapa do checkout.

No painel administrativo (wp-admin), diversas informações serão salvas juntos ao pedido no WooCommerce, como o q quantidade de parcelas, juros, o valor total da cobraça e o JSON de respota da API do PJBank.

## Instalação ##

### Pré-requisito ###

Como este plugin foi desenvolvido com o intuito de trabalhar em conjunto com o WooCommerce, é necessário a utilização do mesmo, caso contrário, não será possível a utilização deste plugin.

### Upload no Painel Administrativo do WordPress ###

1. Baixe o repositório <a href="https://github.com/pjbank/pjbank-wp-plugin-cartao/archive/master.zip" target="_blank">pjbank-wp-plugin</a>
2. Acesse o Painel Administrativo do WordPress e navegue até o menu Plugins.
3. Escolha a opção para adicionar um novo plugin.
4. Ative o botão para fazer o upload manual do plugin.
5. Selecione o arquivo `pjbank-wp-plugin-cartao-master.zip` em seu computador
6. Clique em 'Instalar Agora'.
7. Ative o plugin `Cartão PJBank`.

### Upload via FTP ###

1. Baixe o repositório <a href="https://github.com/pjbank/pjbank-wp-plugin/archive/master.zip" target="_blank">pjbank-wp-plugin</a>
2. Extraia o arquivo em seu computador.
3. Faça o upload da pasta `pjbank-wp-plugin-master` no diretório `/wp-content/plugins/`.
2. Acesse o Painel Administrativo do WordPress e navegue até o menu Plugins.
7. Ative o plugin `Cartão PJBank`.

### Usando o Painel Administrativo do WordPress ###

Ainda não disponível

## Configuração ##

Após a instalação e ativação, é necessário fazer a configuração dele, seguindo o caminho `WooCommerce > Configurações > Finalizar compra > PJBank - Cartão` no Painel Administrativo, onde será necessário configurar as opções abaixo:

* Habilitar/Desabilitar - Este checkbox irá ativar ou desativar o plugin.
* Credencial - Credencial PJBank da empresa, necessário para o correto funcionamento do plugin.
* Chave - Chave PJBank da empresa, necessário para o correto funcionamento do plugin.
* Título - O nome que o plugin irá exibir no final do checkout. Padrão: Boleto Bancário.
* Juros pagamento à vista - Juros para quando o pagamento for à vista. Valor será considerado como porcentagem. Padrão: 0
* Juros parcelamento 2x ~ 6x - Juros para quando o pagamento for dividido de 2 a 6 parcelas. Valor será considerado como porcentagem. Padrão: 0
* Juros parcelamento 7x ~ 12x - Juros para quando o pagamento for dividido de 7 a 12 parcelas. Valor será considerado como porcentagem. Padrão: 0