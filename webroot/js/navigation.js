$(document).ready(function() {
    $('.dd-item.placeholder .dd-handle').click(function(event) {
        event.preventDefault();
        return false;
    });

    $('#nestable').nestable({
        group: 1,
        maxDepth: 3
    });
    $('#nestable2').nestable({
        group: 1,
        maxDepth: 1
    });

    $('div#nestable-menu button[type="submit"]').click(function(event) {
        if($('#nestable-output').val() == '') {
            var errorMsg = '<div class="alert alert-danger" role="alert" onclick="this.remove();">No changes were made.</div>';
            $('div#subHeader').after(errorMsg);
            event.preventDefault();
        }
    });

    $('#nestable').on('change', function(e) {
        var list = e.length ? e : $(e.target);
        var output = list.data('output');
        var serialized = list.nestable('serialize');

        $('input#nestable-output').val(JSON.stringify(serialized));
    });

    $('#nestable-menu').on('click', function(e) {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

    // $('#nestable2').on('change', updateOutput);
    // updateOutput($('#nestable2').data('output', $('#nestable2-output')));
});