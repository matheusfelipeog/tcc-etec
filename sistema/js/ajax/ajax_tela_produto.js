$(document).ready(function () {

    // Variavel geral da tabela
    const TabelaProduto = $('#tabelaProdutos').DataTable();

    /**
    * Atualizar a tabela após clique do usuário
    */
    $('#refresh-table').on('click', () => {
        TabelaProduto.ajax.reload();

        $('#btnAdicionarProd').fadeIn();
        $('#btnAlterarProd, #btnDeletarProd').fadeOut();
        $('#qtdSelecionadoProd').text('').fadeOut();
    });


    // ####################### INICIO ADICIONAR #############################

    // Pegando evento submit
    $('#add-produto').on('submit', function () {

        // Verifica inputs vazios
        for (i = 0; i < this.length; i++) {
            if ((this[i].value == "" && this[i].disabled != true && this[i].type !== "file" && this[i].type !== "button") || (Number(this[i].value) < 0)) {

                notify(`Campo ${this[i].title} vazio ou inválido, tente novamente`, template_danger);

                return false;  // Impede submit
            }
        }

        // Tratando adição de quantidades iguais e menores que o valor já cadastrado na tabela
        if (Number(this[9].value) < Number(this[9].min) && this[9].disabled != true) {

            notify(`Quantidade inválida, somente quantidades superiores a ${this[9].min} são aceitas.`, template_danger);

            return false;
        }
        else if (Number(this[9].value) > Number(this[9].max) && this[9].disabled != true) {

            notify(`Quantidade inválida, não é possível adicionar mais que 255 unidades.`, template_danger);

            return false;
        }


        const sizeDefault = 2097152; // 2 Mb em Bytes
        let file_add = $('#id-add-imagem-produto')[0]

        if (file_add.value !== "") {
            if (file_add.files[0].size > sizeDefault) {
                notify(`Arquivo muito grande. Tente novamente ... <br />Tamanho maxímo permitido: 2Mb (2097152 Bytes)`, template_warning);

                return false
            } else if (file_add.files[0].type !== "image/jpeg" && file_add.files[0].type !== "image/png") {

                notify(`Arquivo não compatível.<br />Tipo do seu arquivo: ${file_add.files[0].type}<br />Tipos aceitos: "image/jpeg" e "image/png"`, template_warning);

                return false
            }
        }


        // Preparando dados para request
        const dadosForm = $(this).serialize();

        const formData = new FormData();

        const formImgAdd = document.getElementById('id-add-imagem-produto');

        // Todos os dados que vão ser utilizados, dentro do formData
        formData.append('data', dadosForm)
        formData.append('add-imagem-produto', formImgAdd.files[0])

        // Ajax para adicionar produto
        $.ajax({
            url: "../../php/controller/produto/produto.Salvar.php",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: "POST",
            success: function (dados) {

                if (dados === '#AdiçãoInvalidaPreparo#') {
                    notify('Produto(s) do tipo "Preparo" não podem ser adicionado unidades', template_warning);

                } else {
                    console.log(dados);

                    notify('Produto adicionado com sucesso!', template_success);

                    TabelaProduto.ajax.reload();

                    // Para fechar o modal e voltar ao default
                    $('#add-produto').removeClass('was-validated');
                    $('#modalAdicionar').modal('hide');

                    $('#btnAlterarProd, #btnDeletarProd').fadeOut();
                    $('#qtdSelecionadoProd').text('').fadeOut();


                    $('#add-produto').each(function () {
                        this.reset();
                    });
                }

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
    $('#altera-produto').on('submit', function () {

        // Verifica inputs vazios e se inputs com valores válidos
        for (i = 0; i < this.length; i++) {
            if ((this[i].value == "" && this[i].type !== 'file') || (Number(this[i].value) < 0)) {

                notify(`Campo "${this[i].title}" vazio ou inválido, tente novamente ...`, template_danger);

                return false;  // Impede submit
            }
        }


        // Itera sobre os dados dos inputs e os dados selecionados, para fins de validação        
        if (TabelaProduto.rows('.selected').data().length == 1) {
           
            // Valores válidos
            const tipo = { 1: 'Comum', 2: 'Preparo' }

            let iguais = 0;

            for (i = 0; i < this.length - 2; i++) {

                // Verifica se foi realizada alguma modificação, acrescentando 1 à variável 'iguais' caso verdadeiro
                if (i === 3) {
                    if (tipo[this[i].value] === TabelaProduto.rows('.selected').data()[0][i]) {
                        iguais += 1;
                    }
                } else {
                    if (this[i].value === TabelaProduto.rows('.selected').data()[0][i]) {
                        iguais += 1;
                    }
                }
            }


            // Verifica se tem alteração, é decrescido 1 em length para eliminar o input de imagem
            if (iguais === this.length - 2 && this[8].files.length === 0) {
                notify(`Não foi realizada nenhuma alteração ...`, template_info);

                return false;
            }
        }



        const sizeDefault = 2097152; // 2 Mb em Bytes
        let file_alt = $('#id-alt-imagem-produto')[0]
        if (file_alt.value !== "") {
            if (file_alt.files[0].size > sizeDefault) {
                notify(`Arquivo muito grande. Tente novamente ... <br />Tamanho maxímo permitido: 2Mb (2097152 Bytes)`, template_warning);

                return false
            } else if (file_alt.files[0].type !== "image/jpeg" && file_alt.files[0].type !== "image/png") {
                notify(`Arquivo não compatível.<br />Tipo do seu arquivo: ${file_alt.files[0].type}<br />Tipos aceitos: "image/jpeg" e "image/png"`, template_warning);

                return false
            }
        }


        // Preparando dados para request
        const dadosForm = $(this).serialize();

        const formData = new FormData();

        const formImg = document.getElementById('id-alt-imagem-produto');

        // Todos os dados que vão ser utilizados, dentro do formData
        formData.append('data', dadosForm)
        formData.append('alt-imagem-produto', formImg.files[0])

        // Ajax para alterar produto
        $.ajax({
            url: "../../php/controller/produto/produto.Atualizar.php",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: "POST",
            success: function (dados) {

                console.log(dados);

                notify('Produto alterado com sucesso!', template_success);

                TabelaProduto.ajax.reload();

                // Para resetar fechar o modal e resetar os botões
                $('#altera-produto').removeClass('was-validated');
                $('#modalAlterar').modal('hide');
                $('#btnAlterarProd, #btnDeletarProd').fadeOut();
                $('#qtdSelecionadoProd').text('').fadeOut();

                // Anti-falha para o botão de adicionar aparecer após muitas deleções
                $('#btnAdicionarProd').fadeIn();

            },
            error: function (request, status, error) {

                const caracteristicas_popup = select_template_status_code(request.status);

                notify(caracteristicas_popup.msg, caracteristicas_popup.template);

            }
        });

        return false;  // Impede redirecionamento

    });

    // ####################### FIM ALTERAR #############################




    // ####################### INICIO DELETAR #############################

    // Pegando evento submit
    $('#deleta-produto').on('submit', function () {

        const registros = $('#tabelaProdutos').DataTable().rows('.selected').data();

        // Verifica inputs vazios
        for (i = 0; i < registros.length; i++) {

            if (registros[i][0].value == "") {

                notify('Ocorreu um erro, tente novamente ...', template_danger);

                return false;  // Impede submit
            }

            // Verifica se o input está vazio ou desativado
            if ((this[1].value === '' || this[1].value === '0') && this[1].disabled != true) {

                notify(`Informe quantas unidades de ${registros[0][1]} para finalizar`, template_danger);

                return false;
            }

        }

        // Verifica se a quantidade informada é maior que a quantidade atual do registro, se verdadeiro, será levantado uma notificação
        if (Number(this[1].value) > Number(registros[0][4]) || Number(this[1].value) < 0) {
            notify(`Ação inválida.<br />O produto tem ${registros[0][4]} unidades.`, template_warning);

            return false;
        }


        // Serializando ids de todos os registros selecionados
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

        // Recebe valor que está dentro do input
        const qtd_para_deletar = this[1].value;

        // Para verificar se foi passado uma quantidade para deletar, caso tenha, será armazenado o valor 'true' na variável
        const existe_qtd = qtd_para_deletar !== '' && qtd_para_deletar !== '0' && qtd_para_deletar !== undefined && qtd_para_deletar !== null

        // Será setado um objeto correspondente a id e quantidadde se a quantidade existir, senão somente os id's serializados
        let dados = existe_qtd ? { 'id_produto': ids[0], 'quantidade_a_deletar': qtd_para_deletar } : dados_serializados

        // Caso selecionado, será trocado a quantidade a deletar pela informação de desativação
        if (this[3].checked) {
            dados = { 'id_produto': ids[0], 'desativar_produto': true }
        }


        // Ajax para deletar produto
        $.ajax({
            type: "POST",
            url: "../../php/controller/produto/produto.Deletar.php",
            data: dados,
            success: function (dados) {

                console.log(dados);

                if (dados === '#DeletarInvalidoPreparo#') {
                    notify('Produto(s) do tipo "Preparo" não podem ter suas unidade deletada', template_warning);

                } else {

                    notify('Produto(s) deletado(s) com sucesso!', template_success);

                    // Dando refresh na tabela e desmarcando e removendo todas linhas marcadas
                    TabelaProduto.rows('.selected').remove();
                    TabelaProduto.ajax.reload();

                    // Para resetar fechar o modal e resetar os botões
                    $('#modalDeletar').modal('hide');
                    $('#btnAlterarProd, #btnDeletarProd').fadeOut();
                    $('#qtdSelecionadoProd').text('').fadeOut();

                    // Anti-falha para o botão de adicionar aparecer após muitas deleções
                    $('#btnAdicionarProd').fadeIn();

                    // TEMPORARIO - DELETAR
                    // Para resetar inputs ao finalizar com sucesso
                    // $('#id-deletar-unid-produto').attr('disabled', true);
                    // $('#plus-unid').attr('disabled', true);
                    // $('#minus-unid').attr('disabled', true);
                }

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
