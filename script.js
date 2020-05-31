$('#seed-form').bind('submit', function(e) {

    e.preventDefault();

    // console.log(formData);

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        beforeSend: function() {
            $('#response').html('<p>Loading</p>')
        },
        success: function(data) {
           $('#response').html(data);
        },
        complete: function(data) {
           
        }
    });
    e.stopImmediatePropagation();
    return false;

});