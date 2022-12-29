
$(document).ready(function () {

  // --------------- Alterando o comportamento do DataTables ---------------------

  // Chamada para o dataTables da tabela produto
  $('#tabelaClientes').DataTable({
    processing: true,
    ajax: {
      type: "POST",
      url: "../../php/controller/cliente/cliente.Listar.php",
      data: { data: 0 },
      dataType: "json",

      error: function (request, status, error) {

        notify(`Ocorreu um erro ${request.status}, consulte a lista de códigos de erros para mais informações <a href="../../html/pages/codigos_de_erro.html#${request.status}" class="text-gray-900">clicando aqui.</a>`, template_danger);
      }
    },

    // Estilo e visualização de todos os componentes ao redor da tabela
    dom:
      "<'row'<'col-sm-12 col-md-8 mb-2'B><'col-sm-12 col-md-4 mt-2'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'>>",

    // Limitando quantidade de registros
    iDisplayLength: 10,

    paging: false,
    scrollY: '50vh',

    // Alterando a linguagem dos príncipais retornos
    oLanguage: {
      sProcessing: "Carregando ...<br /><i class='fas fa-spinner fa-spin'></i>",
      sLengthMenu: "Mostrar _MENU_ produtos",
      sZeroRecords: "<div style='height:46.8vh; transform: translateY(30%)'>Não existe registro no banco de dados. <br /> <a href='#' id='cliqueAqui' data-toggle='modal' data-target='#modalAdicionar'>Clique aqui para adicionar</a></div>",
      sInfoEmpty: "Registro 0 a 0 de 0",
      sInfo: "Mostrando _TOTAL_ clientes cadastrados",
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
        text: 'Desativar',
        className: 'btn btn-outline-danger font-weight-bold d-none mt-2 pt-1 pb-1 pl-4 pr-4 btn-desativar'
      },
      {
        text: 'Alterar',
        className: 'btn btn-outline-info font-weight-bold d-none mt-2 pt-1 pb-1 pl-4 pr-4 btn-alterar'
      },
      {
        text: 'Pagar divida',
        className: 'btn btn-outline-warning font-weight-bold d-none mt-2 pt-1 pb-1 pl-4 pr-4 btn-pagar-divida'
      },
      {
        text: '',
        className: 'btn btn-white-info font-weight-bold mt-2 pt-1 pb-1 pl-4 pr-4 qtd-selecionados'
      }
    ]
  });


  // ------------- Interatividade com a tabela ----------------

  $('tr td').addClass('cursor');

  // Para selecionar uma linha ( registro ) especifica e acionar botões de ação
  $('#tabelaClientes tbody').on('click', 'tr', function () {

    $(this).toggleClass('selected text-gray-100');

    const registro = $('#tabelaClientes').DataTable().rows('.selected').data();


    // Mostra quantidade de registros selecionados
    const qtd_selecionada = $('#qtdSelecionadoCli');
    if (registro.length > 0) {
      qtd_selecionada.removeClass('d-none');
      qtd_selecionada.fadeIn();
      qtd_selecionada.text(registro.length + ' Selecionado(s)');
    } else {
      qtd_selecionada.fadeOut();
    }


    const btn_alterar = $('#btnAlterarCli');

    // Mostra botão de alterar quando um unico registro estiver selecionado
    if (registro.length == 1) {
      btn_alterar.removeClass('d-none');
      btn_alterar.fadeIn();

    } else {
      btn_alterar.fadeOut();
    }

    const btn_pagar_divida = $('#btnPagarDividaCli');

    // Mostra botão de pagar divida somente para os devedores e somente 1 por vez
    if (registro.length == 1 && (registro[0][2] === 'Em aberto' || registro[0][2] === 'Em débito')) {
      btn_pagar_divida.removeClass('d-none');
      btn_pagar_divida.fadeIn();

    } else {
      btn_pagar_divida.fadeOut();
    }


    // Mostra botão de deletar em uma e multiplas registros selecionados
    const btn_adicionar = $('#btnAdicionarCli');
    const btn_deletar = $('#btnDesativarCli');
    if (registro.length > 0) {
      btn_deletar.removeClass('d-none');
      btn_deletar.fadeIn();
      btn_adicionar.fadeOut();

    } else {
      btn_deletar.fadeOut();
      btn_adicionar.fadeIn();
    }

  });


  $(document).on('click', '#btnAdicionarCli, #cliqueAqui', function () {

    // Limpar dados que permanecem no formulário
    $('#add-cliente').each(function () {
      this.reset();
    });

    const date = new Date();

    $('#id-add-data-cliente').attr('value', date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate());
  })



  // Resetando campos do modal quando clicar em "Limpar" ou "X"
  $('#reseta_modal_add_cli, #fechar-add-cli, #fechar-alt, #canc_desativar, #canc_pagamento').on('click', function () {

    $('#add-cliente, #altera-cliente, #pagar-divida').each(function () {
      this.reset();
    });


    // Reseta msg de info status e todos inputs marcados como ínvalidos
    $('#add-cliente, #altera-cliente').removeClass('was-validated');
  });


  /* Botão de alterar cliente
  *
  * Seta todos os dados do registro selecionado nos respectivos inputs do formulário correspondente.
  */
  $(document).on('click', '#btnAlterarCli', function () {

    const registro = $('#tabelaClientes').DataTable().rows('.selected').data();
    const form_alterar = $('#altera-cliente')[0];

    form_alterar[0].value = (registro[0][0]);                                                  // id
    form_alterar[1].value = (registro[0][1].trim());                                           // nome
    $('#id-alt-situacao-cliente').val($(`option:contains("${registro[0][2]}")`).val());        // situação
    $('#id-alt-tipo-cliente').val($(`option:contains("${registro[0][4].trim()}")`).val());     // tipo
    $('#id-alt-status-cliente').val($(`option:contains("${registro[0][5].trim()}")`).val());   // status
    $('#id-alt-data-cliente')[0].value = registro[0][6].split('/').reverse().join('-');        // data
    form_alterar[6].value = (registro[0][7].trim());                                           // alterar

  });


  $(document).on('click', '#btnPagarDividaCli', function () {

    // Limpar dados que permanecem no formulário
    $('#id-quantia-pagar-divida').attr('readonly', false);
    $('#check-pagar-toda-divida').attr('checked', false);
    $('#pagar-divida').each(function () {
      this.reset();
    });



    const registro = $('#tabelaClientes').DataTable().rows('.selected').data();
    const form_pagar_divida = $('#pagar-divida')[0];

    form_pagar_divida[0].value = registro[0][0];         // id
    form_pagar_divida[1].value = registro[0][1].trim();  // nome
    form_pagar_divida[2].max = registro[0][3].trim();    // valor
    
  });


  /* Botão de alterar cliente
  *
  * Seta a contagem de registros selecionados no formulário correspondente para informar o usuário.
  */
  $(document).on('click', '#btnDesativarCli', function () {
    const registro = $('#tabelaClientes').DataTable().rows('.selected').data();

    $('#aviso-qtd-selecionado').text(registro.length);
  });



  // ------------- Modificando elementos ----------------

  // Alterando os atributos dos botões para trabalhar com o modal
  $('.btn-adicionar').attr({
    title: 'Adicione um novo cliente a sua tabela',
    id: 'btnAdicionarCli',
    "data-toggle": 'modal',
    "data-target": '#modalAdicionar'
  });

  $('.btn-alterar').attr({
    title: 'Altere os dados do cliente selecionado',
    id: 'btnAlterarCli',
    "data-toggle": 'modal',
    "data-target": '#modalAlterar'
  });

  $('.btn-desativar').attr({
    title: 'Desative todos os clientes selecionado',
    id: 'btnDesativarCli',
    "data-toggle": 'modal',
    "data-target": '#modalDesativar'
  });

  $('.btn-pagar-divida').attr({
    title: 'Pague a divida do cliente selecionado',
    id: 'btnPagarDividaCli',
    "data-toggle": 'modal',
    "data-target": '#modalPagarDivida'
  });

  $('.qtd-selecionados').attr({
    title: 'Número de registro selecionado',
    id: 'qtdSelecionadoCli',
    disabled: 'disabled'
  });

});

