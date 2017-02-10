var wsURL;

var WS;
var WSConnectionOpened;

function initWebSocket(onOpenCallback, onMessageCallback, onCloseCallback) {
    WS = new WebSocket(wsURL);

    WS.onmessage = onMessageCallback;
    WS.onopen = onOpenCallback;
    WS.onclose = onCloseCallback;
}

initWebSocket(function () {
    WSConnectionOpened = true;

    $('#loader, .linear-loader').fadeOut(function () {
        $('main').fadeIn();
    });
}, onMessage, function () {
    if (WSConnectionOpened) {
        $('main').fadeOut(function () {
            $('#loader').fadeIn().addClass('error');
        });
    } else {
        $('#loader').addClass('error');
        $('.linear-loader').fadeOut();
    }

    WSConnectionOpened = false;
});

function onMessage(e) {
    try {
        var data = JSON.parse(e.data);

        console.log(data);

        switch (data.type) {
            case 'init':
                $.each(data.items, function (key, value) {
                    updateItemValue(value.id, value.type, value.value)
                });

                afterConnected();

                break;
            case 'value':
                updateValue(data);
                break;
            case 'error':
                showErrorMessage(data.message);
                break;
        }
    } catch (e) {
        showErrorMessage('Ошибка обработки ответа от сервера');
        console.log("Error: " + e);
    }
}

function afterConnected() {
    WSConnectionOpened = true;

    $('#loader').fadeOut(function () {
        $('.control-panel').fadeIn();
    });
}

function send(msg) {
    if (typeof msg != "string") {
        msg = JSON.stringify(msg);
    }

    if (WS && WS.readyState == 1) {
        WS.send(msg);
    }
}

function updateValue(data) {
    updateItemValue(data.item_id, data.item_type, data.value);
}

function itemSwitchOn(itemId) {
    var $item = $('.panel-item-switch[data-item-id="' + itemId + '"]');
    $item.removeClass('off');
}

function itemSwitchOff(itemId) {
    var $item = $('.panel-item-switch[data-item-id="' + itemId + '"]');
    $item.addClass('off');
}

function itemSetValue(itemId, value) {
    console.log(itemId, value);
    $('.panel-item-variable[data-item-id="' + itemId + '"] > .item-variable-value').html(value);
}

function updateItemValue(id, type, value) {
    type = parseInt(type);

    switch (type) {
        case 10:    // Switch
            if (Boolean(value)) {
                itemSwitchOn(id);
            } else {
                itemSwitchOff(id);
            }

            break;
        case 20:    // Variable
            itemSetValue(id, value);
            break;
        case 21:    // Variable Temperature
            itemSetValue(id, value + ' °C');
            break;
        case 22:    // Variable Humidity
            itemSetValue(id, value + '%');
            break;
        case 25:    // Variable boolean
            value = Boolean(value) ? 'да' : 'нет';

            itemSetValue(id, value);

            break;
        case 26:    // Variable boolean door
            if (value) {
                value = 'открыто';
            } else {
                value = 'закрыто';
            }

            itemSetValue(id, value);

            break;
        case 30:    // RGB
            // TODO
            if (typeof value === 'string') {
                $('.item-rgb[data-item-id="' + id + '"]')
                    .find('.rgb-mode[data-mode="' + value + '"]')
                    .addClass('active');
            } else {
                var $colorPicker = $('#colorpicker-' + id);

                $colorPicker.spectrum('set', 'rgb(' + value[0] + ', ' + value[1] + ', ' + value[2] + ')');

                $('.item-rgb .rgb-mode').removeClass('active');
            }

            break;
    }
}

$(document).ready(function () {

    $('body').addClass('loaded');

    // Event listeners
    $('.panel-item-switch').click(function (e) {
        e.preventDefault();

        var item_id = $(this).data('item-id');
        var action = $(this).hasClass('off') ? 'turnON' : 'turnOFF';

        send({
            "type": action,
            "item_id": item_id
        });

        return false;
    });

    // TODO:
    // $('.rgb-colorpicker').spectrum({
    //     showInput: true,
    //     showButtons: false,
    //     preferredFormat: 'rgb',
    //     change: function (color) {
    //         var item_id = $(this).data('item-id');
    //         var red = Math.round(color._r);
    //         var green = Math.round(color._g);
    //         var blue = Math.round(color._b);
    //
    //         var fade = ($('.fade-checkbox[data-item-id="' + item_id + '"]:checked').length > 0);
    //
    //         send({
    //             'type': 'rgb',
    //             'item_id': item_id,
    //             'fade': fade,
    //             'red': red,
    //             'green': green,
    //             'blue': blue
    //         });
    //     }
    // });

    // $('.fade-checkbox').each(function () {
    //     var localStorageValue = window.localStorage.getItem('fade-checkbox-' + $(this).data('item-id'));
    //
    //     console.log(localStorageValue);
    //
    //     this.checked = localStorageValue != null && localStorageValue != 'false';
    // });

    // initWebSocket(function () {
    // $('input[type="checkbox"].item-switch-checkbox').click(function (e) {
    //     e.preventDefault();
    //
    //     var item_id = $(this).data('item-id');
    //     var action = $(this).prop('checked') ? 'turnON' : 'turnOFF';
    //
    //     send({
    //         "type": action,
    //         "item_id": item_id
    //     });
    // });

    // Delegate click on block to checkbox
    // $('.item-switch .info-box').click(function (e) {
    //     e.preventDefault();
    //
    //     if ($(e.target).is('.item-switch-checkbox')) {
    //         return false;
    //     }
    //
    //     $(this).find('.item-switch-checkbox').click();
    // });

    // $('.rgb-mode').click(function (e) {
    //     e.preventDefault();
    //
    //     var mode = $(this).data('mode');
    //     var start = true;
    //     var item_id = $(this).parents('.item-rgb').data('item-id');
    //
    //     if ($(this).hasClass('active')) {
    //         start = false
    //     }
    //
    //     send({
    //         "type": "rgbMode",
    //         "item_id": item_id,
    //         "mode": mode,
    //         "start": start
    //     });
    // });

    // $('.fade-checkbox').change(function (e) {
    //     window.localStorage.setItem('fade-checkbox-' + $(this).data('item-id'), this.checked);
    // });
    // });
});
