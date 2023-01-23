
$('.w-max-content tbody').on('click', 'tr', function () {
    let $tr = $(this);
    let $allTr = $tr.parent().find('tr');

    $allTr.removeClass('table-success');
    $tr.addClass('table-success');
});
