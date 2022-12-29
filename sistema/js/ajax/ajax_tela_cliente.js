$(document).ready(function () {

    // Variavel geral da tabela
    const TabelaCliente = $('#tabelaClientes').DataTable();

    /**
    * Atualizar a tabela após clique do usuário
    */
    $('#refresh-table').on('click', () => {
        TabelaCliente.ajax.reload();

        $('#btnAdicionarCli').fadeIn();
        $('#btnAlterarCli, #btnDesativarCli, #btnPagarDividaCli').fadeOut();
        $('#qtdSelecionadoCli').text('').fadeOut();
    });

    // ####################### INICIO ADICIONAR #############################

    // Pegando evento submit
    $('#add-cliente').on('submit', function () {

        // Verifica inputs vazios
        for (i = 0; i < this.length; i++) {
            if (this[i].value == "") {

                notify(`Campo ${this[i].title} vazio ou inválido, tente novamente ...`, template_danger);

                return false;  // Impede submit
            }
        }

        // Preparando dados para request
        const dados_form = $(this).serialize();

        // Ajax para adicionar produto
        $.ajax({
            type: "POST",
            url: "../../php/controller/cliente/cliente.Salvar.php",
            data: dados_form,
            success: function (dados) {

                console.log(dados);

                notify('Produto adicionado com sucesso!', template_success);

                TabelaCliente.ajax.reload();

                // Para fechar o modal e voltar ao default
                $('#add-cliente').removeClass('was-validated');
                $('#modalAdicionar').modal('hide');

                $('#btnAlterarCli, #btnDeletarCli').fadeOut();
                $('#qtdSelecionadoCli').text('').fadeOut();


            },
            error: function (request, status, error) {

                const caracteristicas_popup = select_template_status_code(request.status);

                notify(caracteristicas_popup.msg, caracteristicas_popup.template);

            }
        });

        return false;  // Impede redirecionamento

    });

    // ####################### FIM ADICIONAR #############################



    // ####################### INICIO ALTERAR #############################

    // Pegando evento submit
    $('#altera-cliente').on('submit', function () {

        // Verifica inputs vazios e se inputs com valores válidos
        for (i = 0; i < this.length; i++) {
            if (this[i].value == "") {

                notify(`Campo "${this[i].title}" vazio ou inválido, tente novamente ...`, template_danger);

                return false;  // Impede submit
            }
        }


        // Itera sobre os dados dos inputs e os dados selecionados, para fins de validação        
        if (TabelaCliente.rows('.selected').data().length == 1) {

            // Valores válidos
            const situacao = {1: 'Em dia', 2: 'Em aberto', 3: 'Em débito'}
            const tipo = {1: 'Comum', 2: 'Mensal'}
            const status = {1: 'Ativo', 2: 'Desativo'}

            let iguais = 0;

            for (i = 0; i < this.length - 1; i++) {   

                // Verifica se foi realizada alguma modificação, acrescentando 1 à variável 'iguais' caso verdadeiro
                // Após i chegar a 3, será incrementado 1 unidade na busca dos dados no datatable para ignorar a coluna divida
                if (i >=  2 && i <= 6){
                    if (i === 2){
                        if ( situacao[this[i].value] === TabelaCliente.rows('.selected').data()[0][i] ){
                            iguais += 1;
                        }
                    } else if (i === 3){
                        if ( tipo[this[i].value] === TabelaCliente.rows('.selected').data()[0][i + 1] ){
                            iguais += 1;
                        }
                    } else if (i === 4){
                        if ( status[this[i].value] === TabelaCliente.rows('.selected').data()[0][i + 1] ){
                            iguais += 1;
                        }
                    } else if (i === 5){
                        if ( this[i].value === TabelaCliente.rows('.selected').data()[0][i + 1].split('/').reverse().join('-') ){
                            iguais += 1;
                        }
                        
                    } else if (i === 6){
                        if ( this[i].value === TabelaCliente.rows('.selected').data()[0][i + 1] ){
                            iguais += 1;
                        }
                    }
                } else{

                    if (this[i].value === TabelaCliente.rows('.selected').data()[0][i]) {

                        iguais += 1;
                    }
                }

            }

            
            // Verifica se tem alteração, é decrescido 1 em length para eliminar o input de imagem
            if (iguais === this.length - 1) {
                notify(`Não foi realizada nenhuma alteração ...`, template_info);

                return false;
            }
        }


        // Preparando dados para request
        const dados_form = $(this).serialize();

        // Ajax para alterar produto
        $.ajax({
            type: "POST",
            url: "../../php/controller/cliente/cliente.Atualizar.php",
            data: dados_form,
            success: function (dados) {

                console.log(dados);

                notify('Produto alterado com sucesso!', template_success);

                TabelaCliente.ajax.reload();

                // Para resetar fechar o modal e resetar os botões
                $('#altera-cliente').removeClass('was-validated');
                $('#modalAlterar').modal('hide');
                $('#btnAlterarCli, #btnDesativarCli').fadeOut();
                $('#btnPagarDividaCli').fadeOut();
                $('#qtdSelecionadoCli').text('').fadeOut();

                // Anti-falha para o botão de adicionar aparecer após muitas deleções
                $('#btnAdicionarCli').fadeIn();

            },
            error: function (request, status, error) {

                const caracteristicas_popup = select_template_status_code(request.status);

                notify(caracteristicas_popup.msg, caracteristicas_popup.template);

            }
        });

        return false;  // Impede redirecionamento

    });

    // ####################### FIM ALTERAR #############################




    // ####################### INICIO PAGAR DIVIDA ##########################

    $('#pagar-divida').on('submit', function(e){

        if(e.target[0].value === ''){
            notify(`Ocorreu um erro, selecione o cliente novamente`, template_danger);
            return false;
        } else if(e.target[1].value === ''){
            notify(`Ocorreu um erro ao selecionar o cliente, tente novamente`, template_danger);
            return false;
        } else if(e.target[2].value === ''){
            notify(`Informe um valor válido para finalizar a operação`, template_danger);
            return false;
        } else if(!e.target[2].value.match(/[^+-/*%=e]+/g)){
            // console.log(!e.target[2].value.match(/[^+-/*%=e]+/g), e.target[2].value)
            notify(`Foi identificado um ou mais caracteres inválidos no valor. Corrija e tenta novamente para finalizar`, template_danger);
            return false;
        }        

        if(Number(e.target[2].value) > Number(e.target[2].max) ){
            notify(`Valor informado excedeu o limite da divida do cliente, informe o valor válido para finalizar`, template_danger);
            return false;
        } else if(Number(e.target[2].value) <= 0.05){
            notify(`Valor inválido, informe um valor correto para finalizar`, template_danger);
            return false;
        }  
        
        
        const dados_form = $(this).serialize();

        // Ajax para alterar produto
        $.ajax({
            type: "POST",
            url: "../../php/controller/cliente/divida.Pagar.php",
            data: dados_form,
            success: function (dados) {

                console.log(dados);

                notify('Pagamento realizado com sucesso!', template_success);

                TabelaCliente.ajax.reload();

                // Para resetar fechar o modal e resetar os botões
                $('#pagar-divida').removeClass('was-validated');
                $('#modalPagarDivida').modal('hide');
                $('#btnAlterarCli, #btnDesativarCli, #btnPagarDividaCli').fadeOut();
                $('#qtdSelecionadoCli').text('').fadeOut();

                // Força botão a aparecer
                $('#btnAdicionarCli').fadeIn();

            },
            error: function (request, status, error) {

                const caracteristicas_popup = select_template_status_code(request.status);

                notify(caracteristicas_popup.msg, caracteristicas_popup.template);

            }
        });

        return false;
    });

    // ####################### FIM PAGAR DIVIDA #############################




    // ####################### INICIO DELETAR #############################

    // Pegando evento submit
    $('#desativar-cliente').on('submit', function () {

        const registros = $('#tabelaClientes').DataTable().rows('.selected').data();

        // Verifica inputs vazios
        for (i = 0; i < registros.length; i++) {

            if (registros[i][0].value == "") {

                notify('Ocorreu um erro, tente novamente ...', template_danger);

                return false;  // Impede submit
            }
        }

        // Serializando no dedo
        const chave = [];
        const ids = [];
        for (i = 0; i < registros.length; i++) {
            chave[i] = `id_${i}`
            ids[i] = registros[i][0];  // A lista ids irá receber somente os id's dos registros
        }

        let dados_serializados = '';
        for (i = 0; i < ids.length; i++) {
            dados_serializados += `${chave[i]}=${ids[i]}&`;
        }

        // Ajax para deletar produto
        $.ajax({
            type: "POST",
            url: "../../php/controller/cliente/cliente.Excluir.php",
            data: dados_serializados,
            success: function (dados) {

                console.log(dados);

                notify('Cliente(s) desativado(s) com sucesso!', template_success);

                // Dando refresh na tabela e desmarcando e removendo todas linhas marcadas
                TabelaCliente.rows('.selected').remove();
                TabelaCliente.ajax.reload();

                // Para resetar fechar o modal e resetar os botões
                $('#modalDesativar').modal('hide');
                $('#btnAlterarCli, #btnDesativarCli').fadeOut();
                $('#qtdSelecionadoCli').text('').fadeOut();

                // Anti-falha para o botão de adicionar aparecer após muitas deleções
                $('#btnAdicionarCli').fadeIn();

            },
            error: function (request, status, error) {

                const caracteristicas_popup = select_template_status_code(request.status);

                notify(caracteristicas_popup.msg, caracteristicas_popup.template);

            }
        });

        return false;  // Impede redirecionamento

    });

    // ####################### FIM DELETAR #############################

});
