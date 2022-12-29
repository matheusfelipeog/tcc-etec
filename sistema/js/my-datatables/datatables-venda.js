$(document).ready(function () {

    $('#listaDePedidos').DataTable({

        ajax: {
            type: "POST",
            url: "../../php/controller/venda/anti_bug_lista_pedidos.php",

            // É utilizado a opção error do ajax para manter o funcionamento do datatables, assim servindo de acumulador de linhas(pedidos)
            error: function (request, status, error) {

                console.log('Status DataTable --> OK');

            }
        },

        dom:
            "<'row'<'col-sm-12 col-md-6 mb-2'><'col-sm-12 col-md-6'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'B>>",

        scrollY: '27vh',
        iDisplayLength: 10,
        paging: false,

        oLanguage: {
            sZeroRecords: "Nenhum pedido feito",
            sInfoEmpty: "Não existe pedidos na lista",
            sInfo: "Quantidade de pedidos: _TOTAL_"
        },

        buttons: [

            {
                text: 'Deletar',
                className: 'btn btn-outline-danger float-right font-weight-bold m-1 d-none deletar-pedido'
            },

        ]

    });

    const table = $('#listaDePedidos').DataTable()

    // Deletar pedido da lista
    $('#listaDePedidos tbody').on('click', 'tr', function () {

        $(this).toggleClass('selected bg-secondary text-gray-100');

        if (table.rows('.selected').data().length >= 1) {
            $('#btnDeletarPedido').removeClass('d-none').fadeIn()
        } else {
            $('#btnDeletarPedido').fadeOut()
        }

    });

    // Quando clicar no btn
    $(document).on('click', '#btnDeletarPedido', function () {

        // Correnponde ao preço total de todos os produtos selecionados para deleção
        const preco_a_subtrair = table.rows('.selected').data()
            .map(
                (item) => item[item.length - 1]
            )
            .reduce(
                (acumulador, valor_atual) => (Number(acumulador) + Number(valor_atual)).toFixed(2)
            )


        table.rows('.selected').remove().draw(false);  // Deleta os pedidos selecionados da lista

        $('#valor-total-da-compra').val((Number($('#valor-total-da-compra').val()) - Number(preco_a_subtrair)).toFixed(2))

        $(this).fadeOut();

        // Desativa botões
        if (table.rows().data().length < 1) {
            $('#cancelar-compra').attr({'disabled': true, 'title': 'Não há compra para cancelar'}).removeClass('zoom').css('cursor', 'not-allowed')
            $('#finalizar-compra').attr({'disabled': true, 'title': 'Não há compra para finalizar'}).removeClass('zoom').css('cursor', 'not-allowed')
        }

    });


    $('#confirma-cancelar-compra').on('click', function (e) {

        if (table.rows().data().length > 0) {
            table.rows().remove().draw(false);
            $('#valor-total-da-compra').val('0.00')

            $('#cancelar-compra').attr({'disabled': true, 'title': 'Não há compra para cancelar'}).removeClass('zoom').css('cursor', 'not-allowed')
            $('#finalizar-compra').attr({'disabled': true, 'title': 'Não há compra para finalizar'}).removeClass('zoom').css('cursor', 'not-allowed')

            notify(`Compra cancelada com sucesso!`, template_info);
        } else {
            notify(`Não existe compra para cancelar!`, template_warning);
        }

    });


    // Modificando botão de deletar
    $('.deletar-pedido').attr({
        title: 'Delete os pedidos selecionados',
        id: 'btnDeletarPedido'
    });



});