function csDeliveryNotify(message, type) {
    $.notify({
        // options
        message: message
    },{
        // settings
        type: type,
        z_index: 2000,
    });
}

function csDeliveryPreloader(action) {
    switch (action) {
        case 'hide':
            $('.csDelivery-preloader').hide();
            break;
        case 'show':
            $('.csDelivery-preloader').show();
            break;
        default:
            break;
    }
}