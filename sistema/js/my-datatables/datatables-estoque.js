
$(document).ready(function () {

  // --------------- Alterando o comportamento do DataTables ---------------------

  // Chamada para o dataTables da tabela produto
  $('#tabelaEstoque').DataTable({
    processing: true,
    ajax: {
      type: "POST",
      url: "../../php/controller/estoque/estoque.Listar.php",
      data: { data: 0 },
      dataType: "json",

      error: function (request, status, error) {

        notify(`Ocorreu um erro ${request.status}, consulte a lista de códigos de erros para mais informações <a href="../../html/pages/codigos_de_erro.html#${request.status}" class="text-gray-900">clicando aqui.</a>`, template_danger);
      }
    },

    // Estilo e visualização de todos os componentes ao redor da tabela
    dom:
      "<'row'<'col-sm-12 col-md-6 mb-2'B><'col-sm-12 col-md-6 mt-2'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'>>",

    // Ativando scroll, limita quantidade de registro e desativa paginação
    scrollY: '50vh',
    iDisplayLength: 10,
    paging: false,

    // Alterando a linguagem dos príncipais retornos
    oLanguage: {
      sProcessing: "Carregando ...<br /><i class='fas fa-spinner fa-spin'></i>",
      sLengthMenu: "Mostrar _MENU_ produtos em estoque",
      sZeroRecords: "<div style='height:46.8vh; transform: translateY(30%)'>Não existe registro no banco de dados. <br /> <a href='#' id='cliqueAqui' data-toggle='modal' data-target='#modalAdicionar'>Clique aqui para adicionar</a></div>",
      sInfoEmpty: "Registro 0 a 0 de 0",
      sInfo: "Quantidade de produto(s) em estoque: _TOTAL_ registros",
      sInfoFiltered: "( busca feita em _MAX_ registros )",
      sSearch: "Buscar por:",
      oPaginate: {
        sFirst: "Primeiro",
        sPrevious: "Anterior",
        sNext: "Próximo",
        sLast: "Último"
      }
    },

    buttons: [
      {
        text: 'Adicionar',
        className: 'btn btn-outline-success font-weight-bold mt-2 pt-1 pb-1 pl-3 pr-3 btn-adicionar'
      },
      {
        text: 'Deletar',
        className: 'btn btn-outline-danger font-weight-bold mt-2 d-none pt-1 pb-1 pl-4 pr-4 btn-deletar'
      },
      {
        text: 'Alterar',
        className: 'btn btn-outline-info font-weight-bold mt-2 d-none pt-1 pb-1 pl-4 pr-4 btn-alterar'
      },
      {
        text: '',
        className: 'btn btn-white-info font-weight-bold mt-2 pt-1 pb-1 pl-4 pr-4 qtd-selecionados'
      }
    ]

  });




  $('#tabelaEstoque tbody').on('click', 'tr', function () {

    $(this).toggleClass('selected text-gray-100');

    const registro = $('#tabelaEstoque').DataTable().rows('.selected').data();

    // Mostra quantidade de registros selecionados
    const qtd_selecionada = $('#qtdSelecionadoEst');
    if (registro.length > 0) {
      qtd_selecionada.removeClass('d-none');
      qtd_selecionada.fadeIn();
      qtd_selecionada.text(registro.length + ' Selecionado(s)');
    } else {
      qtd_selecionada.fadeOut();
    }


    // Para sumir o botão adicionar quando não for necessário sua utilidade
    const btn_adicionar = $('#btnAdicionarEst');

    if (registro.length == 1) {
      btn_adicionar.fadeIn();
    }
    else if (registro.length > 1) {
      btn_adicionar.fadeOut();
    }


    // Mostra botão de alterar quando um unico registro estiver selecionado
    const btn_alterar = $('#btnAlterarEst');
    if (registro.length === 1) {

      btn_alterar.removeClass('d-none');
      btn_alterar.fadeIn();

    } else {
      btn_alterar.fadeOut();
    }


    // Mostra / Desaparecer botão Deletar conforme necesário
    const btn_deletar = $('#btnDeletarEst');
    if (registro.length > 0) {
      btn_deletar.removeClass('d-none');
      btn_deletar.fadeIn();

    } else {
      btn_deletar.fadeOut();
    }


    if (registro.length == 1) {
      $('#id-deletar-unid-produto').attr({ 'disabled': false })
      $('#check-desativar-produto').attr({ 'disabled': false })
      $('#corpo-quantidade-a-deletar').show()
      $('#corpo-check-desativar').show()


    } else {
      $('#id-deletar-unid-produto').attr({ 'disabled': true })
      $('#check-desativar-produto').attr({ 'disabled': true })
      $('#corpo-quantidade-a-deletar').hide()
      $('#corpo-check-desativar').hide()

    }

  });


  // Resetando campos do modal quando clicar em "Limpar" ou "X"
  $('#reseta_modal_add_est, #fechar-add-est, #fechar-alt-est, #canc_delete').on('click', function () {

    $('#add-estoque, #altera-estoque, #deleta-estoque').each(function () {
      this.reset();
    });

    const form_alterar = $('#altera-estoque')[0];
    $(form_alterar[4]).removeClass('readonly');

    // Reseta msg de info status e todos inputs marcados como ínvalidos
    $('#add-estoque, #altera-estoque').removeClass('was-validated');
  });

  // deixa invisível o label e input para adicionar mais unidades ao produto
  $('label[for="id-add-mais-unid-estoque"], #id-add-mais-unid-estoque').attr({ 'disabled': false }).hide()



  /* Botão Adicionar ------------------------------------------------------------------------------
  *
  * Captando evento de click no botão Adicionar, e acionando o callback que tem como funcionalidade 
  * setar os dados nos inputs do formulário e também apaga-los quando necessário.  
  */
  $(document).on('click', '#btnAdicionarEst, #cliqueAqui', function () {

    const registro = $('#tabelaEstoque').DataTable().rows('.selected').data();

    const form_adicionar = $('#add-estoque')[0];

    $('#add-estoque').each(function () {
      this.reset();
    });

    $('#add-estoque').removeClass('was-validated');


    // Seta os dados da linha nos inputs do formulário
    if (registro.length == 1) {

      for (index = 0; index < 8; index++) {

        // if (index == 7) index += 1;

        // if (index >= 3 ) form_adicionar[index].value = registro[0][index + 2];
        // else 
        
        form_adicionar[index].value = registro[0][index + 1];  // Seta os dados do registro nos respectivos inputs do modal


        $(form_adicionar[index]).attr({ 'readonly': true });

      }

      // Seta o tipo do produto selecionado nas opções contidas no select
      $('#id-add-tipo-estoque').val($(`option:contains("${registro[0][3].trim()}")`).val());     // tipo estoque
      $('#id-add-status-estoque').val($(`option:contains("${registro[0][4].trim()}")`).val());     // tipo estoque

      form_adicionar[4].min = form_adicionar[4].value;
      $('#reseta_modal_add_est').hide();

      // Deixa visível o label e input add mais unidades
      $('#corpo-add-mais-unid, #id-add-mais-unid-produto').attr({ 'disabled': false }).show()

      // Desativa adição de imagem e seu label
      $('label[for="id-add-imagem-estoque"], #id-add-imagem-estoque').attr({ 'disabled': true }).hide()

    }

    // Apaga os dados que estão no formulário 
    else {

      $('#add-estoque').each(function () {
        this.reset();
      });

      for (index = 0; index < 8; index++) {
        $(form_adicionar[index]).removeAttr('readonly');
      }

      form_adicionar[3].min = 0

      $('#reseta_modal_add_est').show();

      // Deixa invisível o label e input add mais unidades 
      $('#corpo-add-mais-unid, #id-add-mais-unid-produto').attr({ 'disabled': true }).hide()

      // Ativa adição de imagem e seu label
      $('label[for="id-add-imagem-estoque"], #id-add-imagem-estoque').attr({ 'disabled': false }).show()


    }

  });


  /* Botão Alterar ------------------------------------------------------------------------------
    *
    * Captando evento de click no botão Alterar, e acionando o callback que tem como funcionalidade 
    * setar os dados nos inputs do formulário e também apaga-los quando necessário.  
    */
  $(document).on('click', '#btnAlterarEst', function () {

    $('#altera-estoque').removeClass('was-validated');

    const registro = $('#tabelaEstoque').DataTable().rows('.selected').data();
    const form_alterar = $('#altera-estoque')[0];

    for (index = 0; index < 9; index++) {

      // if (index >= 4) form_alterar[index].value = registro[0][index + 1].trim();
      // else 
      form_alterar[index].value = registro[0][index]; // Seta os valores do registro selecionado nos respectivos inputs do modal

    }

    // Seta o tipo do produto selecionado nas opções contidas no select 
    $('#id-alt-tipo-estoque').val($(`option:contains("${registro[0][3].trim()}")`).val());     // tipo estoque
    $('#id-alt-status-estoque').val($(`option:contains("${registro[0][4].trim()}")`).val());     // status estoque

    $(form_alterar[5]).attr('readonly', 'readonly');

  });


  /* Botão Deletar ------------------------------------------------------------------------------
 *
 * Captando evento de click no botão Alterar, e acionando o callback que tem como funcionalidade 
 * mostrar a quantidade de registros selecionados para deleção 
 */
  $(document).on('click', '#btnDeletarEst', function () {
    const registro = $('#tabelaEstoque').DataTable().rows('.selected').data();

    $('#deleta-estoque').each(function () {
      this.reset();
    });


    if (registro.length == 1) {
      $('#aviso-qtd-selecionado').html(' o produto <b>' + registro[0][1] + '</b>. <br /> selecione a quantidade abaixo <br /> e confirme a ação para finalizar.');

      // Ativa todos as opções dentro do modal para manipulação da quantidade
      $('#id-deletar-unid-produto').attr('disabled', false).val('');
      $('#plus-del-unid').attr('disabled', false);
      $('#minus-del-unid').attr('disabled', false);

    } else {
      $('#aviso-qtd-selecionado').html(registro.length + ' produtos. <br /> confirmar está ação ?');
    }

  });

  // Desativando input de quantidade a deletar ao clicar no checkbox
  $('#check-desativar-estoque').on('click', (e) => {

    if (e.target.checked === true) {
      $('#id-deletar-unid-produto').attr('disabled', true).val('');
      $('#plus-del-unid').attr('disabled', true);
      $('#minus-del-unid').attr('disabled', true);

    } else if (e.target.checked === false) {
      $('#id-deletar-unid-produto').attr('disabled', false);
      $('#plus-del-unid').attr('disabled', false);
      $('#minus-del-unid').attr('disabled', false);
    }

  });



  // ------------- Modificando elementos ----------------

  // Alterando os atributos dos botões para trabalhar com o modal
  $('.btn-adicionar').attr({
    title: 'Adicione novos produtos a sua tabela',
    id: 'btnAdicionarEst',
    "data-toggle": 'modal',
    "data-target": '#modalAdicionar',
  });

  $('.btn-alterar').attr({
    title: 'Altere as informações do produto selecionado',
    id: 'btnAlterarEst',
    "data-toggle": 'modal',
    "data-target": '#modalAlterar'
  });

  $('.btn-deletar').attr({
    title: 'Delete quantidade ou desative o produto selecionado',
    id: 'btnDeletarEst',
    "data-toggle": 'modal',
    "data-target": '#modalDeletar'
  });

  $('.qtd-selecionados').attr({
    title: 'Número de registro selecionado',
    id: 'qtdSelecionadoEst',
    disabled: 'disabled'
  });

});



