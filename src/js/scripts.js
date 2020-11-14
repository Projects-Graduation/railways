function readImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $($(input).closest('.image-wrapper').find('.image-previewer')).css("background-image", "url(" + e.target.result + ")")
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

function sweet(title, text, icon = 'info'){
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'حسنا',
    })
}
$(function () {
    let table_attachments = $('.table-attachments')
    if (table_attachments.length) {
        table_attachments.closest('form').attr('enctype', "multipart/form-data")
    }
    let input_file = $('input[type=file]')
    if (input_file.length) {
        input_file.closest('form').attr('enctype', "multipart/form-data")
    }
    $(document).on('change', '.image-wrapper input[type=file]', function () {
        readImage(this);
    });

    $(document).on('click', '.goback', function(e){
        e.preventDefault();
        window.history.go(-1);
    });

    $(document).on('keyup', '#form-search-by-id input[name=model_id]', function(e){
        e.preventDefault();
        if(e.which == 13) {
            gotoModel();
        }
    });

    $(document).on('click', '#form-search-by-id #btn-search-by-id', function(e){
        e.preventDefault();
        gotoModel();
    });
    
})

function gotoModel(){
    let field_model_id = $('#form-search-by-id input[name=model_id]');
    let field_model_url = $('#form-search-by-id select[name=model_url]');
    if (field_model_id.val()) {
        let model_url = field_model_url.val() + '';
        let url = model_url.replace(':model_id', field_model_id.val());
        // similar behavior as an HTTP redirect
        // window.location.replace(url);

        // similar behavior as clicking on a link
        window.location.href = url;
    }else{
        sweet('عذرا', 'يجب إدخال الرقم', 'warning')
    }
}