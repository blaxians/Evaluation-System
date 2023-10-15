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
                    $('#loading_overlay').addClass('d-none');
                    $('#spinner_border').addClass('d-none');
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