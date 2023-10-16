<script>
    $(document).ready(function() {

        uploadFile();
        textNameButtonName();

    });


    function textNameButtonName(){
            const fileInput = $('#importedFile');
            const fileLabel = $('label[for="importedFile"]');
            const fileName = $('#file-name');

            $(document).on('change', '#importedFile', function(){
                if (fileInput[0].files.length > 0) {
                $('#uploadButton').prop('disabled', false);
                const selectedFile = fileInput[0].files[0];
                fileName.text('File Name: ' + selectedFile.name); 
                } else {
                    fileName.text('');
                }
                    
            })
            if (!fileInput[0].files.length) {
                    $('#uploadButton').prop('disabled', true);
                } 
            

    }

    function uploadFile(){
        $(document).on('submit', '#upload_excel', function(e){

            e.preventDefault();
            const fd = new FormData(this);
            $('#loading_overlay').removeClass('d-none');
            $('#spinner_upload').removeClass('d-none');
            $.ajax({

                url: "{{ route('import.post') }}",
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                cache: false,
                success: function(res){

                    if(res == "success"){

                        $.ajax({
                            url: "{{ route('insertStudent.post') }}",
                            method: "get",
                            success: function(res){
                                console.log(res);
                                if(res == 'success'){
                                    $('#loading_overlay').addClass('d-none');
                                    $('#spinner_border').addClass('d-none');
                                    Swal.fire('Success!', 
                                    'Students imported successfully.', 
                                    'success')
                                    $('#file-name').text('');
                                    $('#upload_excel').trigger('reset');
                                    $('#uploadButton').prop('disabled', true);

                                }
                            },
                            error: function(err){
                                console.log(err);
                            }
                        })
                    } else {
                        $('#file-name').text('');
                            Swal.fire(
                            'Error!',
                            `${res.error}`,
                            'error'); 
                    }
                }, 
                error: function(err){
                    console.log(err);
                }
            })
        })
        
    }

</script>