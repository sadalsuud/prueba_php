$(function () {
    $('body').on('click', '.btn-submit', function (e) {
        e.preventDefault();
        const $form = $(this).closest('.filter-form');
        const target = $form.data('target') || '.filter-results';
        const $resContainer = $(target).empty().hide();

        asyncLoad($form.attr('action'), $form.serialize(), $resContainer);
    });

    $('body').on('click', '.btn-clear', function (e) {
        e.preventDefault();

        const $form = $(this).closest('.filter-form');

        $form.find('input:text, select').each(function () {
            $(this).val('');
        });

        $form.find('.btn-submit').trigger('click');
    });

    $('body').on('click', '.btn-load-async', function () {
        const $btn = $(this);
        const data = $btn.data() || {};

        if (!('params' in data)) {
            data.params = {};
        }

        if (!('type' in data.params)) {
            data.params.type = data.type;
        }

        asyncLoad(data.action, data.params, $(data.target));
    });

    $('body').on('click', '.btn-form-async', function (e) {
        e.preventDefault();
        const $this = $(this);
        const $form = $this.closest('form');

        $.ajax({
            type: 'POST',
            url: $form.attr('action'),
            dataType: 'JSON',
            data: $form.serialize(),
        }).then(function (response) {
            asyncLoad($form.attr('action'), {type: $this.data('action')}, $($this.data('target')));
            return response;
        }).catch(function (xhr, status, error) {
            console.error(xhr, status, error);
        });
    });
});

const asyncLoad = (action, data, $resContainer) => {
    $.ajax({
        type: 'POST',
        url: action,
        dataType: 'HTML',
        data: data,
    }).then(function (response) {
        if (response) {
            $resContainer.html(response).show();
        }
        return true;
    }).catch(function (xhr, status, error) {
        console.error(xhr, status, error);
    });
};