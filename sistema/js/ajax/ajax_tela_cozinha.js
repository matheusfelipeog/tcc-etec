$(document).ready(function () {

    // EVENTOS ------------------------

    // Pega evento de click nos botões para confirmar pedido pronto
    $(document).on('click', '.btn-pedido-pronto', function (e) {
        ajax_confirma_pedido_pronto(e.target.dataset);
    });

    // FUNÇÕES PERSONALIZADAS ---------

    /**
     * ajax_get_pedidos_em_espera() É responsável pegar todos os pedidos realizados
     * 
     * @return {JSON} -> Um JSON contendo todos os pedidos que foram realizados
     */
    function ajax_get_pedidos_em_espera() {
        $.ajax({
            type: 'POST',
            url: '../../php/controller/cozinha/listar.Preparo.php',
            success: function (dados) {

                try {
                    dados_obj = JSON.parse(dados);

                    mostra_pedidos_em_espera(dados_obj['lista_de_pedidos']);

                } catch (error) {
                    console.log('Ocorreu um erro na conversão para JSON --> ' + error)  // TEMPORÁRIO
                }

            },
            error: function (request, status, error) {
                console.log('Ocorreu um erro na request --> ' + error)  // TEMPORÁRIO
            }


        });
    }


    /**
     * mostra_pedidos_em_espera(pedidos) É responsável por listar todos os pedidos que foram realizados
     * 
     * @param pedidos -> Corresponde a todos os pedidos que foram realizados
     */
    function mostra_pedidos_em_espera(pedidos) {

        // Limpa toda a lista existente
        $('.lista-de-pedidos-em-espera').empty();

        if (pedidos.length === 0) {

            $('.lista-de-pedidos-em-espera').append(
                `
                    <div class="d-flex align-items-center">
                        <div class="ml-auto mr-auto text-xs">
                            <span class="font-weight-bold w-25">Nenhum pedido em espera</span>
                        </div>
                    </div>
                `
            );

            $('#caracteristica_pedido').html(`<b>Nenhum pedido em espera</b>`);
            $('#pedido_principal').empty();

            return
        } else if (pedidos.length === 1){
            $('.lista-de-pedidos-em-espera').append(
                `
                    <div class="d-flex align-items-center">
                        <div class="ml-auto mr-auto text-xs">
                            <span class="font-weight-bold w-25">Nenhum pedido em espera</span>
                        </div>
                    </div>
                `
            );
        }

        // Distribuindo pedidos na tela
        for (let i = 0; i < pedidos.length; i++) {

            let element = pedidos[i];

            if ($(`#pedido-${element.id_cozinha}`).length === 0) {

                // i igual a 0 corresponde ao primeiro pedido na lista, assim sendo o pedido principal
                if (i === 0) {
                    $('#caracteristica_pedido').html(`

                        <span class="font-weight-bold">
                            #Nº ${element.id_cozinha} &#10141;
                        </span>
                        <span> 
                            <i>Prato:</i> <b><ins>${element.nome}</ins></b> - <i>Qtd:</i> <b><ins>${element.quantia}</ins></b>
                        </span>

                    `);

                    $('#pedido_principal').html(`

                        <img src="${element.path_img_produto}" alt="Imagem do produto realizado" class="img-fluid"
                            style="width: 100%; height: 67vh;">
                        <button class="btn btn-lg btn-success rounded-0 font-weight-bold mt-auto btn-pedido-pronto"
                            data-idPedido="${element.id_cozinha}" data-nomePedido="${element.nome}" data-qtdPedido="${element.quantia}"
                            style="width: 100%; height: 10vh;">Pronto</button>

                    `);

                }

                // Corresponde ao resto dos pedidos em espera
                else if (i > 0) {

                    $('.lista-de-pedidos-em-espera').append(
                        `
                            <div id="pedido-${element.id_cozinha}" class="d-flex align-items-center mb-3 mb-1">
                                <div class="mr-3">
                                    <img src="${element.path_img_produto}" alt="Imagem do pedido feito"
                                        class="img-thumbnail" style="width: 100px; height: 100px; ">
                                </div>
                                <div class="w-75" style="word-wrap: break-word;">
                                    <span class="font-weight-bold w-25">
                                        #Pedido Nº ${element.id_cozinha} &#10141;
                                    </span>
                                    <span> 
                                        <i>Prato:</i> <b><ins>${element.nome}</ins></b> - <i>Quantidade:</i> <b><ins>${element.quantia}</ins></b>
                                    </span>
                                </div>
                                <div class="ml-auto">
                                    <button type="button" 
                                    data-idPedido="${element.id_cozinha}" data-nomePedido="${element.nome}" data-qtdPedido="${element.quantia}"
                                    class="btn btn-outline-success font-weight-bold ml-2 mr-2 btn-pedido-pronto">Pronto</button>
                                </div>
                            </div>
                        `
                    );
                }

            }


        }

    }


    // Fazendo a chamada para listar os pedidos da cozinha a cada N segundos
    ajax_get_pedidos_em_espera(); // Força primeiro carregamento
    setInterval(
        ajax_get_pedidos_em_espera,
        30000
    );


    /**
     *  ajax_confirma_pedido_pronto(dataset) é responsável por realizar a requisição assincrona para confirmar um pedido pronto
     * 
     * @param {JSON} dataset -> Um json contendo os dados de um dataset correspondentes a um pedido
     */        
    function ajax_confirma_pedido_pronto (dataset){
        $.ajax({
            type: 'POST',
            url: '../../php/controller/cozinha/confirma_pedido_pronto.php',
            data: { 'pedido_pronto': dataset },
            success: function(dados){
                
                console.log(dados)  // TEMPORÁRIO

                notify(`Pedido Nº ${dataset.idpedido} pronto!`, template_success);
                ajax_get_pedidos_em_espera();
                
            },
            error: function(request, status, error){

                console.log('Erro aqui --> ' + error)

            }
        });
    }

});