// Template de todas as notificações
const template_success = '\
<div data-notify="container" class="col-11 col-md-4 alert alert-with-icon text-white bg-success font-weight-bold" role="alert" data-notify-position="top-right"`>' +
    '<button type="button" aria-hidden="true" class="close close-pop-up" data-notify="dismiss">' +
    '<i class="fas fa-times"></i>' +
    '</button>' +
    `<span data-notify="message">{2}</span>` +
    '</div>';

const template_danger = '\
<div data-notify="container" class="col-11 col-md-4 alert alert-with-icon text-white bg-danger font-weight-bold" role="alert" data-notify-position="top-right"`>' +
    '<button type="button" aria-hidden="true" class="close close-pop-up" data-notify="dismiss">' +
    '<i class="fas fa-times"></i>' +
    '</button>' +
    `<span data-notify="message">{2}</span>` +
    '</div>';

const template_info = '\
<div data-notify="container" class="col-11 col-md-4 alert alert-with-icon text-white bg-info font-weight-bold" role="alert" data-notify-position="top-right"`>' +
    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">' +
    '<i class="fas fa-times"></i>' +
    '</button>' +
    `<span data-notify="message">{2}</span>` +
    '</div>';

const template_warning = '\
<div data-notify="container" class="col-11 col-md-4 alert alert-with-icon text-white bg-warning font-weight-bold" role="alert" data-notify-position="top-right"`>' +
    '<button type="button" aria-hidden="true" class="close close-pop-up" data-notify="dismiss">' +
    '<i class="fas fa-times"></i>' +
    '</button>' +
    `<span data-notify="message">{2}</span>` +
    '</div>';


/**
 * Função para verificar o status da request HTTP.
 * 
 * @example 
 *   select_template_status_code(404);
 * 
 * @param   {Number}    status_code Recebe o código correspondente a requisição HTTP.
 * @returns {JSON}    Retorna um Json com o template da notificação e sua mensagem, conforme o status code da requisição
 */
function select_template_status_code(status_code) {
    if (status_code >= 100 && status_code <= 199) {

        return { "template": template_info, "mensagem": `Código ${status_code}: Information. Consulte a lista de códigos de erros para mais informações <a href="../../html/pages/codigos_de_erro.html#${status_code}" class="text-gray-900">clicando aqui.</a>` };
    }

    else if (status_code >= 300 && status_code <= 399) {

        return { "template": template_warning, "msg": `Código ${status_code}: Redirection. Consulte a lista de códigos de erros para mais informações <a href="../../html/pages/codigos_de_erro.html#${status_code}" class="text-gray-900">clicando aqui.</a>` };
    }

    else if (status_code >= 400 && status_code <= 499) {

        return { "template": template_danger, "msg": `Código ${status_code}: Client Error. Consulte a lista de códigos de erros para mais informações <a href="../../html/pages/codigos_de_erro.html#${status_code}" class="text-gray-900">clicando aqui.</a>` };
    }

    else if (status_code >= 500 && status_code <= 599) {

        return { "template": template_danger, "msg": `Código ${status_code}: Server Error. Consulte a lista de códigos de erros para mais informações <a href="../../html/pages/codigos_de_erro.html#${status_code}" class="text-gray-900">clicando aqui.</a>` };
    }

    else {
        return { "template": template_danger, "msg": "Ocorreu um erro, tente novamente..." };
    }
}


/**
 * Função para exibir uma nofiticação com informações conforme passadas nos parâmetros.
 * 
 * @example 
 *   notify('Erro no campo XYZ', template_danger);
 * 
 * @param   {Text}      msg Recebe a mensagem informando o que tem de errado no formulário
 * @param   {Template}  type_template Recebe o template que será utilizado para geração da notificação.
 * @returns {null}      Sem retorno.
 */
function notify(msg = `Campo vazio ou inválido, tente novamente ...`, type_template = template_info) {

    $.notify({
        // options
        message: msg,
    }, {
        // settings
        element: 'body',
        newest_on_top: true,

        placement: {
            from: "top",
            align: "right"
        },
        offset: 20,
        spacing: 10,
        z_index: 1060,
        delay: 6000,
        timer: 1000,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        template: type_template
    });

}
