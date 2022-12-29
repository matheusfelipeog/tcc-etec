
/**
 *  @nome -> ajax_tela_venda.js
 * 
 * @Descrição -> Arquivo responsável por todas as requisições correspondentes a tela de Vendas da aplicação, de modo que outras funcionalidades úteis também são
 * aplicadas neste mesmo arquivo.
 */
$(document).ready(function () {

    // EVENTOS ----------------------------------------------------------------

    $('#pesquisa-produto').on('input', (e) => {
        // console.log(e.target.value.length);

        // Em toda nova pesquisa, é zerado o datalist
        $('#list-pesquisa').empty();

        // Contagem de elementos
        if (e.target.value.length >= 3) {

            ajax_pesquisa_produto(e.target.value);

        } else {

            // Para retirar o aviso
            $('#pesquisa-produto').removeClass('border-danger');
            $('#aviso-pesquisa-produto').fadeOut();
        }

    });


    // Para pegar o evento de submit da busca, após ter selecionado o produto pretendido.
    $('#form-pesquisa-produto').on('submit', (e) => {

        const input_pesq = e.target[0];

        const option = $('option.result-pesquisa-produto');

        // console.log(input_pesq)

        if (option.length > 0) {

            for (let i = 0; i < option.length; i++) {

                if (input_pesq.value === option[i].value) {

                    mostra_dados_produto_selecionado(option[i].dataset)

                    input_pesq.value = '';
                    $('#list-pesquisa').empty();

                    break;
                }

            }

        } else {
            console.log('Sem options para selecionar')  // TEMPORÁRIO
        }

        return false; // Parar o submit
    });


    $('#qtd-produto').on('input', function (e) {
        // console.log(e.target.value);

        if (e.target.value === '') {
            e.target.value = ''
        } else if (e.target.value < 1 || e.target.value.match(/[+-/*%=e,]+/g)) {
            e.target.value = 1
        } else if (e.target.value > 250) {
            e.target.value = 250
        }

        $('#valor-total-pedido').val((Number(e.target.value) * Number($('#valor-produto').val())).toFixed(2));

    });


    $('#add-pedido').on('click', function (e) {

        // Array com as referências dos inputs da características do pedido
        const dados_pedido = [
            $('#cod-produto'),
            $('#nome-produto'),
            $('#qtd-produto'),
            $('#valor-produto'),
            $('#valor-total-pedido')
        ]

        if (typeof (Storage) !== 'undefined') {

            // Para verificar se nenhum valor foi modificado ou está incompativél aos limites
            const validation = dados_pedido[0].val() === sessionStorage.getItem('validate-id')
                && dados_pedido[1].val() === sessionStorage.getItem('validate-nome')
                && Number(dados_pedido[2].val()) >= 1 && Number(dados_pedido[2].val()) <= Number(sessionStorage.getItem('validate-qtdMax'))
                && Number(dados_pedido[3].val()) === Number(sessionStorage.getItem('validate-preco'))


            // Nega caso os dados sejam validos(true), assim não entrando na condição.
            if (!validation) {

                notify(`Adição inválida.<br />Possíveis motivos:<br />O pedido não foi feito;<br />As características do pedido foi alterada;<br />Ou a quantidade excedeu o limite no estoque`, template_warning);

                return false;
            }

        }

        const tamanho_dados_pedido_filtrado = dados_pedido.filter((item) => item.val() !== '').length

        if (tamanho_dados_pedido_filtrado === 5) {

            const tabela_lista_de_pedidos = $('#listaDePedidos').DataTable();

            // Adiciona os dados do pedido na lista
            tabela_lista_de_pedidos.row.add(dados_pedido.map((item) => item.val())).draw(false);

            // Limpa validação
            if (typeof (Storage) !== 'undefined') {
                sessionStorage.clear();
            }


            // Preenchendo o input correnpondênte ao total a pagar por toda a compra
            if ($('#valor-total-da-compra').val() === '0.00') {
                $('#valor-total-da-compra').val(Number(dados_pedido[4].val()).toFixed(2))
            } else {
                $('#valor-total-da-compra').val((Number($('#valor-total-da-compra').val()) + Number(dados_pedido[4].val())).toFixed(2))
            }

            $('#cancelar-compra').attr({'disabled': false, 'title': 'Cancelar a compra do cliente'}).addClass('zoom').css('cursor', 'pointer')
            $('#finalizar-compra').attr({'disabled': false, 'title': 'Finalize a compra do cliente'}).addClass('zoom').css('cursor', 'pointer')

            $('#add-pedido').attr({'disabled': true, 'title': 'Nenhum pedido selecionado'}).removeClass('zoom').css('cursor', 'not-allowed')


            dados_pedido.map((item) => item.val(''))  // Limpa inputs


        } else if (tamanho_dados_pedido_filtrado === 0) {

            notify(`Nenhum pedido realizado`, template_warning);

        } else if (tamanho_dados_pedido_filtrado <= 4) {

            notify(`Uma ou mais característica(s) do pedido não informada, informe para adicionar.`, template_warning);

        }


    });


    // Finalizando a compra
    $('#confirma-finalizar-compra').on('click', function (e) {
        const table = $('#listaDePedidos').DataTable();

        if (table.rows().data().length > 0) {

            const dados_compra = get_dados_da_compra();

            if (dados_compra) {

                registrar_venda(dados_compra);

                table.rows().remove().draw(false);
                $('#valor-total-da-compra').val('0.00')

                $('#cancelar-compra').attr({'disabled': true, 'title': 'Não há compra para cancelar'}).removeClass('zoom').css('cursor', 'not-allowed');
                $('#finalizar-compra').attr({'disabled': true, 'title': 'Não há compra para finalizar'}).removeClass('zoom').css('cursor', 'not-allowed');

                notify(`Compra finalizada com sucesso!`, template_success);
            } else {
                notify(`Selecione o cliente informando o ID e pressionando a tecla ENTER para finalizar!`, template_warning);
            }

        } else {
            notify(`Não existe compra para finalizar!`, template_warning);
        }

    });

    // Botão responsável por abrir o modal de finalizar a compra
    $('#finalizar-compra').on('click', function (e) {

        $('#corpo-input-id-cliente').hide();
        $('#pesquisa-id-cliente').attr('disabled', true).val('')
        $('#corpo-input-nome-cliente').hide();
        $('#nome-cliente').attr('disabled', true).val('');
        $('#aviso-pesquisa-cliente').hide();
        $('#pagarAgora')[0].checked = true;
        $('#corpo-filtro-pesquisa').hide();
        $('#filtroFuncionario, #filtroCliente').attr('disabled', true)

    });


    // Pega o ID informado no input, e faz a pesquisa para verificar se o usuário existe
    $('#form-pesquisa-cliente').on('submit', (e) => {

        // Deixa em branco quando é digitado valores inválidos
        if (e.target[7].value === '') {

            $('#aviso-pesquisa-cliente').fadeOut();
            $('#nome-cliente').attr('disabled', true).val('');
            $('#corpo-input-nome-cliente').fadeOut();
            e.target[7].value = '';
            return false;

        }

        // Limitando os valores dos inputs
        if (e.target[7].value > 9999) {
            e.target[7].value = 9999
            return false;
        } else if (e.target[7].value < 0) {
            e.target[7].value = 0
            return false;
        }

        // Filtro para pesquisar entre funcionário e cliente
        tipoDeConsumo = e.target[5].checked ? e.target[5].value : e.target[6].value

        // Contagem de caracter
        if (e.target[7].value.length >= 1) {

            ajax_pesquisa_cliente(tipoDeConsumo, e.target[7].value);

        }
        else {

            // Para retirar o aviso
            $('#aviso-pesquisa-cliente').fadeOut();

        }

        return false;
    });

    // Pega evento de click nos botões para confirmar visualização
    $(document).on('click', '.btn-ok-pedido', function (e) {
        ajax_confirma_visualizacao_pedido(e.target.dataset);
    });


    // FUNÇÕES PERSONALIZADAS ----------------------------------------------------------------

    /**
     * Responsável por realizar o procedimento de request-response, para alimentação do datalist após uma pesquisa de produto
     * 
     * @param {String} valor corresponde a cadeia de caractere informada para envio da requisição HTTP 
     */
    function ajax_pesquisa_produto(valor) {

        $.ajax({
            type: 'POST',
            url: '../../php/controller/venda/controller.Pesquisar.php',
            data: { 'pesquisa': valor },
            success: function (dados) {

                // console.log(dados);  // TEMPORÁRIO

                try {

                    const dados_obj = JSON.parse(dados);

                    mostra_resultado_pesquisa(dados_obj);

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
     * Responsável por realizar o procedimento de request-response, para busca do nome do cliente
     * 
     * @param {String} tipoDeConsumo corresponde a que tipo de possíveis consumos está sendo filtrado na busca
     * @param {Number} id corresponde ao código do cliente no banco de dados
     */
    function ajax_pesquisa_cliente(tipoDeConsumo, id) {

        $.ajax({
            type: 'POST',
            url: '../../php/controller/venda/cliente.Venda.php',
            data: { 'tipoDeConsumo': tipoDeConsumo, 'pesquisa-id-cliente': id },
            success: function (dados) {

                console.log(dados);  // TEMPORÁRIO

                try {

                    const response = JSON.parse(dados);

                    if (response.cliente.length === 1) {

                        $('#aviso-pesquisa-cliente').fadeOut();
                        $('#nome-cliente').attr('disabled', false).val(response.cliente[0].nome_cliente);
                        $('#corpo-input-nome-cliente').fadeIn('slow');

                    } else {

                        $('#nome-cliente').attr('disabled', true).val('');
                        $('#aviso-pesquisa-cliente').fadeIn();
                        $('#corpo-input-nome-cliente').fadeOut();

                    }


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
     * Para mostrar os dados de forma dinâmica quando for realizada uma pesquisa de um produto
     * 
     * @param {JSON} response corresponde a um objeto json, com os dados retornados da request 
     */
    function mostra_resultado_pesquisa(response) {

        if (response['response'].length !== 0) {

            $('#pesquisa-produto').removeClass('border-danger');
            $('#aviso-pesquisa-produto').removeClass('d-none').hide().fadeOut();

            for (let i = 0; i < response['response'].length; i++) {

                // Para listar somente quando não existir
                if ($(`#produto-${i}`).length === 0) {
                    $('#list-pesquisa').append(`<option id="produto-${i}" class='result-pesquisa-produto' data-id="${response['response'][i].id_produto}" data-nome="${response['response'][i].nome}" data-qtd="1" data-qtd-max="${response['response'][i].tipo !== 'Preparo' ? response['response'][i].quantia : 250}" data-preco="${response['response'][i].preco}" >${response['response'][i].nome}</option>`)
                }

            }

        } else {

            // Aviso para caso o produto não seja encontrado
            $('#pesquisa-produto').addClass('border-danger');
            $('#aviso-pesquisa-produto').removeClass('d-none').hide().fadeIn();

            $('#list-pesquisa').empty();
        }
    }


    // TESTAR E TERMINAR
    function mostra_dados_produto_selecionado(dataset) {

        // console.log(dataset)  // TEMPORÁRIO

        // Para validação
        if (typeof (Storage) !== 'undefined') {
            sessionStorage.setItem('validate-id', dataset.id)
            sessionStorage.setItem('validate-nome', dataset.nome)
            sessionStorage.setItem('validate-qtdMax', dataset.qtdMax)
            sessionStorage.setItem('validate-preco', dataset.preco)
        }


        $('#cod-produto').val(dataset.id);
        $('#nome-produto').val(dataset.nome);
        $('#qtd-produto').val(dataset.qtd).attr('readonly', false);
        $('#qtd-produto').attr('max', dataset.qtdMax);
        $('#valor-produto').val(dataset.preco);
        $('#valor-total-pedido').val((Number(dataset.qtd) * Number(dataset.preco)).toFixed(2));

        $('#add-pedido').attr({'disabled': false, 'title': 'Adicione o pedido selecionado à lista'}).addClass('zoom').css('cursor', 'pointer')


    }


    /**
     * Função utilizada pelo datatables de vendas para pegar todos os pedidos na lista de pedidos
     * 
     * @return {JSON} -> Json contendo todos os pedidos da lista de pedidos
     */
    function get_dados_da_compra() {
        const qtd_dados = $('#listaDePedidos').DataTable().rows().data().length

        // Para pegar a forma de pagamento selecionada pelo cliente  
        let forma_de_pagamento;
        $('input[name="formaDePagamento"]').each(function () {

            if (this.checked) {
                forma_de_pagamento = this.value;
            }

        });

        // Para pegar o tipo de consumo selecionado
        let tipo_de_consumo;
        $('input[name="tipoDeConsumo"]').each(function () {

            if (this.checked && this.disabled === false) {
                tipo_de_consumo = this.value;
            }

        });

        dados_da_compra = { 'listaDeCompras': [], 'valorTotalDaCompra': 0, 'formaDePagamento': forma_de_pagamento, 'tipoDaCompra': 'Comum' }

        // Adicionando o tipo de consumo nos dados da compra somente caso ele tenha um valor definido
        if (tipo_de_consumo) {
            dados_da_compra['tipoDeConsumo'] = tipo_de_consumo;
        }

        if ($('#pagarDepois')[0].checked) {

            if ($('#pesquisa-id-cliente').val() === '' || $('#nome-cliente').val() === '') {
                return false;
            }
            dados_da_compra.tipoDaCompra = 'Mensal'
            dados_da_compra.dadosCliente = { 'id': $('#pesquisa-id-cliente').val(), 'nome': $('#nome-cliente').val() }

        }

        // Pega somente os pedidos da lista, dispensando o resto da API do datatables
        for (let i = 0; i < qtd_dados; i++) {
            dados_da_compra.listaDeCompras.push($('#listaDePedidos').DataTable().rows().data()[i]);
        }

        dados_da_compra.valorTotalDaCompra = $('#valor-total-da-compra').val();

        return dados_da_compra;

    }


    /**
     * registrar_venda(data) é responsável por enviar os dados da venda para o back, que irá realizar o processamento necessário para finalizar e registrar a venda
     * 
     * @param {JSON} dados -> Dados da venda em formato JSON
     */
    function registrar_venda(dados) {

        $.ajax({
            type: 'POST',
            url: '../../php/controller/venda/pedido.Vender.php',
            data: dados,
            success: function (dados) {

                console.log(dados);  // TEMPORÁRIO

                $('#modalFinalizarCompra').modal('hide');
                ajax_get_pedidos_cozinha(); // Atualiza listagem de pedidos em preparo

            },
            error: function (request, status, error) {
                console.log('Ocorreu um erro na request --> ' + error)  // TEMPORÁRIO
            }
        });

    }


    /**
     * ajax_get_pedidos_cozinha() É responsável buscar todos os pedidos de forma assíncrona
     * 
     * @return {JSON} -> Um JSON contendo todos os pedidos que estão na cozinha
     */
    function ajax_get_pedidos_cozinha() {
        $.ajax({
            type: 'POST',
            url: '../../php/controller/venda/lista_pedidos_cozinha.php',
            success: function (dados) {

                try {

                    dados_obj = JSON.parse(dados);

                    mostra_pedidos_cozinha(dados_obj['lista_de_pedidos']);

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
     * mostra_pedidos_cozinha(pedidos) É responsável por listar todos os pedidos que estão na cozinha
     * 
     * @param pedidos -> Corresponde a todos os pedidos que estão na cozinha
     */
    function mostra_pedidos_cozinha(pedidos) {

        // Limpa toda a lista existente
        $('.lista-de-pedidos-em-preparo').empty();

        if (pedidos.length === 0) {

            $('.lista-de-pedidos-em-preparo').append(
                `
                    <div class="d-flex align-items-center"> 
                        <div class="ml-auto mr-auto text-xs">
                            <span class="font-weight-bold w-25">Sem pedidos em preparo</span>
                        </div>
                    </div>
                `
            );

            return
        }

        pedidos.forEach((element) => {

            if ($(`#pedido-${element.id}`).length === 0) {

                if (element.status_pedido === 'Preparo') {
                    $('.lista-de-pedidos-em-preparo').append(
                        `
                            <div id="pedido-${element.id}" class="d-flex align-items-center mt-1 mb-1">
                                <div class="mr-3">
                                <div class="icon-circle bg-gradient-primary">
                                    <span id="id_pedido_${element.id}" class="text-light font-weight-bold">${element.id}</span>
                                </div>
                                </div>
                                <div class="w-50" style="word-wrap: break-word;">
                                    <!-- <div class="small text-gray-500">Há 10 min</div> -->
                                    <span id="nome_pedido_${element.id}" class="font-weight-bold">${element.quantia_pedido}x ${element.nome_pedido}</span>
                                </div>
                                <div class="ml-auto">
                                    <label class="ml-3 mr-3 pr-1">
                                        <span class="text-info spinner-border spinner-border-sm"></span>
                                    </label>
                                </div>
                            </div>
                        `
                    );
                } else if (element.status_pedido === 'Pronto') {
                    $('.lista-de-pedidos-em-preparo').append(
                        `
                            <div class="d-flex align-items-center mt-1 mb-1">
                                <div class="mr-3">
                                <div class="icon-circle bg-success">
                                    <span id="id_pedido_${element.id}" class="text-light font-weight-bold">${element.id}</span>
                                </div>
                                </div>
                                <div class="w-50" style="word-wrap: break-word;">
                                    <span id="nome_pedido_${element.id}" class="font-weight-bold w-25">${element.quantia_pedido}x ${element.nome_pedido}</span>
                                </div>
                                <div class="ml-auto">
                                    <button type="button"
                                    class="btn btn-sm btn-outline-success ml-2 mr-2 pr-2 pl-2 btn-ok-pedido"
                                    data-idPedido="${element.id}" data-nomePedido="${element.nome_pedido}" data-qtdPedido="${element.quantia_pedido}">OK</button>
                                </div>
                            </div>
                        `
                    );

                }

            }

        });

    }

    // Fazendo a chamada para listar os pedidos da cozinha a cada N segundos
    ajax_get_pedidos_cozinha(); // Força primeiro carregamento
    setInterval(
        ajax_get_pedidos_cozinha,
        15000
    );

    
    /**
     *  ajax_confirma_visualizacao_pedido(dataset) é responsável por realizar a requisição assincrona para confirmar a visualização do pedido pronto.
     * 
     * @param {JSON} dataset -> Um json contendo os dados de um dataset correspondentes a um pedido
     */
    function ajax_confirma_visualizacao_pedido (dataset){
        $.ajax({
            type: 'POST',
            url: '../../php/controller/venda/confirma_view_pedido.php',
            data: { 'pedido_visualizado': dataset },
            success: function(dados){
                
                console.log(dados) //  TEMPORÁRIO

                notify(`Visualizaçao confirmada!`, template_success);
                ajax_get_pedidos_cozinha();

            },
            error: function(request, status, error){

                console.log('Erro aqui --> ' + error)

            }
        });
    }

});
