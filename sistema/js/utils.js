$(document).ready(function () {

    /**
     *  Sessão para tratar a pre-visualização das imagens antes de upload
     */
    function mostraPreviewImg(id, id_btn, previewImg) {

        const sizeDefault = 2097152; // 2 Mb em Bytes

        // Preview de imagem do produto
        $(id).on('change', function (event) {

            if (event.target.files[0].type !== "image/png" && event.target.files[0].type !== "image/jpeg" || Number(event.target.files[0].size) > sizeDefault) {
                return false
            }

            if (previewImg[0].src === '') {
                previewImg[0].src = window.URL.createObjectURL(this.files[0]);

                previewImg.show().animate({
                    opacity: '1',
                    height: '150px',
                    width: '150px'
                });
            } else if (previewImg[0].src !== '') {
                previewImg.show().animate({
                    opacity: '0.0',
                    height: '0px',
                    width: '0px'
                });


                previewImg.show().animate({
                    opacity: '1',
                    height: '150px',
                    width: '150px'
                });

                // Para dar o efeito de troca
                setTimeout(() => { previewImg[0].src = window.URL.createObjectURL(this.files[0]) }, 200);

            }
        });

        // Resetar a imagem e fecha-lá ao clicar
        $('#reseta_modal_add_prod, #fechar-add-prod, #fechar-alt-prod').on('click', function () {

            try {
                if (previewImg[0].src !== '') {
                    previewImg.show().animate({
                        opacity: '0.0',
                        height: '0px',
                        width: '0px'
                    }).fadeOut(250, () => previewImg.removeAttr('src'));
                }
            } catch (e) {
                return
            }

        });

        // Caso a foto fique aberta, será fechada após clicar no botão adicionar
        $(document).on('click', id_btn, function () {
            if (previewImg[0].src !== '') {
                previewImg.hide();
                previewImg[0].src = ''
            }
        });

    }

    // Tela produto
    mostraPreviewImg('#id-add-imagem-produto', '#btnAdicionarProd', $('#preview-image-add-produto').hide())
    mostraPreviewImg('#id-alt-imagem-produto', '#btnAlterarProd', $('#preview-image-alt-produto').hide())

    // Tela estoque
    mostraPreviewImg('#id-add-imagem-estoque', '#btnAdicionarEst', $('#preview-image-add-estoque').hide())
    mostraPreviewImg('#id-alt-imagem-estoque', '#btnAlterarEst', $('#preview-image-alt-estoque').hide())



    /**
     * Sessão para tratar os dados que são setados no sistema.
     * 
     */

    // VALIDANDO OS INPUTS DE IMAGENS, E MOSTRANDO AVISO CASO ESTEJA INVÁLIDO

    // Valida quando tiver alguma mudança de imagem
    const sizeDefault = 2097152; // 2 Mb em Bytes
    $('input[type="file"]').on('change', (event) => {
        let dataImg = event.target.files[0];

        if ($(dataImg)[0].size > sizeDefault) {
            notify(`Arquivo muito grande. Tente novamente ... <br />Tamanho maxímo permitido: 2Mb (2097152 Bytes)`, template_warning);
        } else if ($(dataImg)[0].type !== "image/jpeg" && $(dataImg)[0].type !== "image/png") {
            notify(`Arquivo não compatível.<br />Tipo do seu arquivo: ${$(dataImg)[0].type} <br />Tipos aceitos: "image/jpeg" e "image/png"`, template_warning);
        }

    });


    /**
     * Sessão de animações, efeitos e tratativa de alguns inputs 
     */

    // Dicas ao passar o mouse
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });


    function setaValorInput(element, operacao) {

        // Para correção inicial
        if (element.value === "" && operacao === 'plus') {
            element.value = 1

            element.classList.remove('text-danger');
            element.classList.add('text-success');

        } else if (element.value === "" && operacao === 'minus') {
            element.value = 0

            element.classList.remove('text-success');
            element.classList.add('text-danger');

        } else {

            // Modificação dos valores do input
            if (operacao === 'plus' && Number(element.value) + 1 <= 255 && Number(element.value) + 1 <= Number(element.max)) {
                element.value = Number(element.value) + 1

                element.classList.remove('text-danger');
                element.classList.add('text-success');

            } else if (operacao === 'minus' && Number(element.value) - 1 >= 0 && Number(element.value) - 1 >= Number(element.min)) {


                element.value = Number(element.value) - 1

                element.classList.remove('text-success');
                element.classList.add('text-danger');

            }
        }

    }

    // Para controlar valores em inputs por unidade e aceitando limites, isso com alguns efeitos
    // Deletar
    $('#plus-del-unid').on('click', () => { setaValorInput($('#id-deletar-unid-produto')[0], 'plus') });
    $('#minus-del-unid').on('click', () => { setaValorInput($('#id-deletar-unid-produto')[0], 'minus') });

    // Adicionar
    $('#plus-add-unid').on('click', () => { setaValorInput($('#id-add-mais-unid-produto')[0], 'plus') });
    $('#minus-add-unid').on('click', () => { setaValorInput($('#id-add-mais-unid-produto')[0], 'minus') });


    // Efeito girar o icone de refresh ao passar o mouse e parar de girar ao tirar o mouse
    $('#refresh-table').on('mouseover', () => { $('#icon-refresh')[0].classList.add('fa-spin') });
    $('#refresh-table').on('mouseout', () => { $('#icon-refresh')[0].classList.remove('fa-spin') });


    // Não visível como default
    $('#corpo-input-id-cliente').hide();
    $('#aviso-pesquisa-cliente').hide();
    $('#corpo-input-nome-cliente').hide();
    $('#corpo-filtro-pesquisa').hide();
    $('#filtroFuncionario, #filtroCliente').attr('disabled', true);
    

    $('#pagarDepois').on('change', function (e) {
        if (e.target.checked) {

            $('#corpo-input-id-cliente').fadeIn();
            $('#corpo-filtro-pesquisa').fadeIn();
            $('#filtroFuncionario, #filtroCliente').attr('disabled', false);
            $('#pesquisa-id-cliente').attr('disabled', false);

        }
    })

    $('#pagarAgora').on('change', function (e) {
        if (e.target.checked) {

            $('#corpo-filtro-pesquisa').fadeOut();
            $('#filtroFuncionario, #filtroCliente').attr('disabled', true);
            $('#corpo-input-id-cliente').fadeOut();
            $('#pesquisa-id-cliente').attr('disabled', true);
            $('#corpo-input-nome-cliente').fadeOut();
            $('#nome-cliente').attr('disabled', true).val('');
            $('#aviso-pesquisa-cliente').fadeOut();

        }
    })

    // Setando o valor com 2 casas decímais após tirar o foco do input
    $('#id-quantia-pagar-divida').on('focusout', function(e){

        if (e.target.value !== '' && e.target.value.match(/[^+-/*%=e]+/g) ){
            e.target.value = Number(e.target.value).toFixed(2);
        }

    });

    // Tratando os limites dos valores inseridos no input
    $('#id-quantia-pagar-divida').on('input', function(e){

        const valorTotalDivida = $('#tabelaClientes').DataTable().rows('.selected').data()[0][3];

        if (Number(e.target.value.length) >= valorTotalDivida.length ){
            e.target.value = Number(e.target.value).toFixed(2);
        }

        if (Number(e.target.value) > Number(e.target.max) && e.target.value !== '' ){
            e.target.value = Number(e.target.max).toFixed(2);
        } else if (Number(e.target.value) < Number(e.target.min) && e.target.value !== '' ){
            e.target.value = Number(e.target.min).toFixed(2);
        }
        
    });

    $('#check-pagar-toda-divida').on('change', function(e){

        const valorTotalDivida = $('#tabelaClientes').DataTable().rows('.selected').data()[0][3];

        if (e.target.checked){
            $('#id-quantia-pagar-divida').val( valorTotalDivida ).attr('readonly', true);
        } else {
            $('#id-quantia-pagar-divida').val( 0.05 ).attr('readonly', false);
        }

    });


});