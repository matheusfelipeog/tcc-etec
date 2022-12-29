$(document).ready(function () {

    /**
     * ajax_get_notificacao() É responsável buscar todos os produto de forma assíncrona
     * 
     * @return {JSON} -> Um JSON contendo todos os produto que estão na cozinha
     */
    function ajax_get_notificacao() {
        $.ajax({
            type: 'POST',
            url: '../../php/controller/global/notificacoes.php',
            success: function (dados) {

                try {
                    
                    dados_obj = JSON.parse(dados);

                    mostra_notificacao(dados_obj['lista_de_notificacao']);

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
     * mostra_notificacao(produto) É responsável por listar todas as notificações do sistema
     * 
     * @param produto -> Corresponde a um JSON contendo todas as notificações do sistema
     */
    function mostra_notificacao(produto) {

        // Limpa toda a lista existente
        $('#lista_de_notificacao').empty();

        if (produto.length === 0) {

            $('#lista_de_notificacao').append(
                `
                    <div class="d-flex align-items-center mt-2">
                        <div class="ml-auto mr-auto text-xs">
                            <span class="font-weight-bold w-25">Nenhum alerta encontrado</span>
                        </div>
                    </div>
                `
            );

            $('#num_notificacao').text('')

            return
        }

        $('#num_notificacao').text(`${produto.length}+`)

        produto.forEach((element) => {

            if ($(`#aviso-${element.id}`).length === 0) {

                if (Number(element.quantidade) === Number(element.quantidade_minima)) {

                    $('#lista_de_notificacao').append(
                        `
                            <div id="aviso-${element.id}" class="d-flex align-items-center mt-2 ml-4 mr-4">
                                <div class="mr-3">
                                    <div class="icon-circle bg-info">
                                        <i class="fas fa-exclamation text-white"></i>
                                    </div>
                                </div>
                                <div class="w-100 text-justify" style="word-wrap: break-word;">
                                    <span class="font-weight-bold">
                                        O produto <b><ins>${element.nome}</ins></b> de ID <b>${element.id}</b> atingiu a quantidade mínima permitida de <b>${element.quantidade_minima} unidades</b> no estoque.
                                    </span>
                                </div>
                            </div>
                            <hr class="mb-0 mt-2" />
                        `
                    );

                } else if (Number(element.quantidade) === 0) {

                    $('#lista_de_notificacao').append(
                        `
                            <div id="aviso-${element.id}" class="d-flex align-items-center mt-2 ml-4 mr-4">
                                <div class="mr-3">
                                    <div class="icon-circle bg-danger">
                                        <i class="fas fa-exclamation text-white"></i>
                                    </div>
                                </div>
                                <div class="w-100 text-justify" style="word-wrap: break-word;">
                                    <span class="font-weight-bold">
                                        Parece que o produto <b><ins>${element.nome}</ins></b> de ID <b>${element.id}</b> está <b>SEM UNIDADES</b> no estoque.
                                    </span>
                                </div>
                            </div>
                            <hr class="mb-0 mt-2" />
                        `
                    );

                } else if (Number(element.quantidade) < Number(element.quantidade_minima)) {

                    $('#lista_de_notificacao').append(
                        `
                            <div id="aviso-${element.id}" class="d-flex align-items-center mt-2 ml-4 mr-4">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation text-white"></i>
                                    </div>
                                </div>
                                <div class="w-100 text-justify" style="word-wrap: break-word;">
                                    <span class="font-weight-bold">
                                        O produto <b><ins>${element.nome}</ins></b> de ID <b>${element.id}</b> está abaixo da quantidade mínima permitida <b>(${element.quantidade_minima} unidades)</b> no estoque,
                                        estando atualmente com <b>${element.quantidade} unidades</b>.
                                    </span>
                                </div>
                            </div>
                            <hr class="mb-0 mt-2" />
                        `
                    );

                }

            }

        });

    }

    // Fazendo a chamada para listar os produto da cozinha a cada N segundos
    ajax_get_notificacao(); // Força primeiro carregamento
    setInterval(
        ajax_get_notificacao,
        15000
    );

});