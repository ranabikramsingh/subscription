<textarea id="summernote" class="summernote-textarea" name="{{ $name }}"></textarea>

@push('js')
<script>
    $('#summernote').summernote({
        toolbar: [
            // ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            // ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['codeview','fullscreen']]
        ],
        callbacks: {
        onInit: function() {
            // Your additional script to modify modal header
            $('.note-editor').find('.modal-header').each(function(){
                var title = $(this).find('.modal-title');
                var close = $(this).find('.close');
                $(this).html(title);
                $(this).append(close);
                close.on('click',function(){
                    $(this).closest('.modal').modal('toggle');
                });
            });
            $('.btn-fullscreen').on('click',function()
            {
                if($(this).hasClass('active')){
                    $('.modal').css('z-index','2000');
                }
                else
                {
                    $('.modal').css('z-index','20');
                }
            })
        }
    }
    });
</script>
@endpush
