jQuery('.custom_media_upload').click(function (e) {
    e.preventDefault();

    var custom_uploader = wp.media({
        title: 'Choose Logo Image',
        button: {
            text: 'Set Logo'
        },
        multiple: false  // Set this to true to allow multiple files to be selected
    })
        .on('select', function () {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery('.custom_media_image').attr('src', attachment.url);
            jQuery('.custom_media_url').val(attachment.url);
            //jQuery('.custom_media_id').val(attachment.id);
        })
        .open();
});