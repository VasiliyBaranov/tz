$(document).ready(function () {

    $('.btn-preview-show').click(function(event) {
        event.preventDefault();
        var clickedbtn = $(this);
        var modalContainer = $('#preview-modal');
        var modalBody = modalContainer.find('.modal-body');
        modalBody.html('<img src="'+clickedbtn.attr('href')+'"/>');
        modalContainer.modal({show:true});

    });

    $('.btn-view-show').click(function(event){
        event.preventDefault();

        var url = '?r=book/view-ajax';
        var clickedbtn = $(this);
        var book_id = clickedbtn.attr("data-id");
        var modalContainer = $('#view-modal');
        var modalBody = modalContainer.find('.modal-body');
        modalContainer.modal({show:true});
        $.ajax({
            url: url,
            type: "GET",
            data: {'id':book_id},
            success: function (data) {
                modalBody.html(data);
                modalContainer.modal({show:true});
            }
        });
    });

});