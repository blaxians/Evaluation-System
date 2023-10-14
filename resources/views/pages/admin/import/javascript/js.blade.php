<script>
    $(document).ready(function() {

        loading();
        uploadFile();

    });


    function loading(){
            const fileInput = $('#importedFile');
            const fileLabel = $('label[for="importedFile"]');
            const fileName = $('#file-name');

            fileInput.change(function() {
                $('#loading-overlay').removeClass('d-none');
                $('#spinner-upload').removeClass('d-none');

                if (fileInput[0].files.length > 0) {
                    $('#uploadButton').prop('disabled', false);
                    $('#loading-overlay').addClass('d-none');
                    $('#spinner-upload').addClass('d-none');
                    const selectedFile = fileInput[0].files[0];
                    fileName.text('File Name: ' + selectedFile.name); 
                } else {
                    fileName.text('');
                }
            });

            if (!fileInput[0].files.length) {
                   $('#uploadButton').prop('disabled', true);
            } 

    }

    function uploadFile(){
        $(document).on('submit', '#upload_excel', function(e){
            e.preventDefault();
            const fd = new FormData(this);
            $.ajax({
                url: "{{ route('import.post') }}",
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                cache: false,
                success: function(res){
                    if(res.message == 'success'){
                        if(res.count != '0'){
                            $('#file-name').text('');
                            Swal.fire(
                            'Success!',
                            `${res.count} Student record imported successfully.`,
                            'success'); 
                        } else {
                            $('#file-name').text('');
                            Swal.fire(
                            'Success!',
                            `Student record updated successfully.`,
                            'success'); 
                        }
                                                                                                                                                                    
                    }
                }, 
                error: function(err){
                    console.log(err);
                }
            })
        })
    }

</script>