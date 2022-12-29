$(document).ready(function () {


    // EVENTOS

    // Para aparecer o novo gráfico conforme clique no botão
    $(document).on('click', '#btn_altera_grafico', function(event){

        if ( $('.grafico-barra').length === 1 ) {

            $(this).empty().hide().removeClass('grafico-barra').addClass('grafico-linha').attr('title', 'Visualize em gráfico de linha');
            $(this).html('<i class="fas fa-chart-line fa-lg text-gray-700"></i>').fadeIn('slow');

            $('#grafico-linha').hide();
            $('#grafico-barra').fadeIn();

            ajax_get_dados_do_grafico();


        } else if ( $('.grafico-linha').length === 1 ){

            $(this).empty().hide().removeClass('grafico-linha').addClass('grafico-barra').attr('title', 'Visualize em gráfico de barra');
            $(this).html('<i class="fas fa-chart-bar fa-lg text-gray-700"></i>').fadeIn('slow');

            $('#grafico-barra').hide();
            $('#grafico-linha').fadeIn();

            ajax_get_dados_do_grafico();

        }

    });


    // Efeito girar o icone de refresh ao passar o mouse e parar de girar ao tirar o mouse
    $('#atualiza-grafico').on('mouseover', () => { $('#icon-refresh')[0].classList.add('fa-spin') });
    $('#atualiza-grafico').on('mouseout', () => { $('#icon-refresh')[0].classList.remove('fa-spin') });

    $('#atualiza-grafico').on('click', () => { 

        ajax_get_dados_do_grafico();

    });



    // FUNÇÕES

    /* ------------------------------------- FUNÇÕES AJAX ------------------------------------------- */

    /**
     * Faz uma requisição assincrona para pegar os dados do gráfico
     */
    function ajax_get_dados_do_grafico() {

        $.ajax({
            type: 'POST',
            url: '../../php/controller/dash/lucro.Anual.php',
            dataType: 'JSON',
            success: function (dados) {

                mostra_dados_no_grafico(dados);

            },
            error: function (request, status, error) {
                console.error('Error --> ' + error);
            }

        });

    }



    /**
     * Faz uma requisição assincrona para pegar a quantidade total de produtos no estoque
     */
    function ajax_get_qtd_total_produtos() {

        $.ajax({
            type: 'POST',
            url: '../../php/controller/dash/quantidade_total_de_produtos.php',
            dataType: 'JSON',
            success: function (dados) {

                mostra_quantidade_total_produtos(dados);

            },
            error: function (request, status, error) {
                console.error('Error --> ' + error);
            }

        });

    }


    /**
     * Faz uma requisição assincrona para pegar o lucro do mês
     */
    function ajax_get_lucro_mes() {

        $.ajax({
            type: 'POST',
            url: '../../php/controller/dash/lucro_do_mes.php',
            dataType: 'JSON',
            success: function (dados) {

                mostra_lucro_do_mes(dados);

            },
            error: function (request, status, error) {
                console.error('Error --> ' + error);
            }

        });

    }


    /**
     * Faz uma requisição assincrona para pegar as despesas do mês
     */
    function ajax_get_despesa_mes() {

        $.ajax({
            type: 'POST',
            url: '../../php/controller/dash/despesa_do_mes.php',
            dataType: 'JSON',
            success: function (dados) {

                mostra_despesa_do_mes(dados);

            },
            error: function (request, status, error) {
                console.error('Error --> ' + error);
            }

        });

    }



    /**
     * Faz uma requisição assincrona para pegar as quantidade do tipo de pagamentos
     */
    function ajax_get_tipo_de_pagamento() {

        $.ajax({
            type: 'POST',
            url: '../../php/controller/dash/tipo_vendas.php',
            dataType: 'JSON',
            success: function (dados) {

                mostra_tipos_de_pagamento(dados);

            },
            error: function (request, status, error) {
                console.error('Error --> ' + error);
            }

        });

    }



    /* ------------------------- FUNÇÕES DE DISTRIBUIÇÃO DE DADOS --------------------------------- */


    /**
     * Distribui dos dados no gráfico correspondente
     * 
     * @param {Object} obj -> Objeto contendo a estrutura do gráfico, como labels e datas.
     */
    function mostra_dados_no_grafico(obj) {

        
        const labels = obj.estrutura_do_grafico.labels;
        const data = obj.estrutura_do_grafico.data;

        if ( document.getElementById("grafico-linha").style.display === "" ){

            const myLineChart = document.getElementById("chart-linha");
            gerar_grafico_de_linha(myLineChart, labels, data);

        } else if ( document.getElementById("grafico-barra").style.display === "" ) {

            const myBarChart = document.getElementById("chart-barra");
            gerar_grafico_de_barra(myBarChart, labels, data);

        }

    }


     /**
     * Distribui dos dados da despesa do mês no elemento correspondente na tela
     */
    function mostra_tipos_de_pagamento(obj) {

        const myPieChart = document.getElementById("chart-pizza");
        gerar_grafico_tipos_pagamento(myPieChart, obj.tipo_de_pagamento.slice(0,3) )  // SLICE TEMPORÁRIO

    }


    /**
     * Distribui dos dados de quantidade total de produtos no elemento correspondente na tela
     * 
     * @param {Object} obj -> Objeto contendo a quantidade total de produtos em estoque
     */
    function mostra_quantidade_total_produtos(obj) {

        const element = $('#qtd_produtos_estoque').hide();

        element.text(`${obj.qtd_total_produtos} Produtos`).fadeIn('slow');

    }


    /**
     * Distribui dos dados do lucro do mês no elemento correspondente na tela
     * 
     * @param {Object} obj -> Objeto com chave lucro_do_mes e valor o lucro do mês
     */
    function mostra_lucro_do_mes(obj) {

        const element = $('#lucro_do_mes').hide();
        const valor = Number(obj.lucro_do_mes);

        element.text(valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })).fadeIn('slow');

    }


    /**
     * Distribui dos dados da despesa do mês no elemento correspondente na tela
     */
    function mostra_despesa_do_mes(obj) {

        const element = $('#despesa_do_mes').hide();
        const valor = Number(obj.despesa_do_mes);

        element.text(valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })).fadeIn('slow');

    }


   


    /**
     * Função principal, responsável por chamar todas as outras funções
     */
    function main() {

        ajax_get_tipo_de_pagamento();
        ajax_get_dados_do_grafico();
        ajax_get_qtd_total_produtos();
        ajax_get_lucro_mes();
        ajax_get_despesa_mes();
    }

    main();

});