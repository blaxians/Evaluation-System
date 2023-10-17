<script>
    $(document).ready(function() {
        // Call the functions directly
        uploadFile();
        textNameButtonName();
    });

    function textNameButtonName() {
        const fileInput = $('#importedFile');
        const fileLabel = $('label[for="importedFile"]');
        const fileName = $('#file-name');

        // Use 'change' event handler directly
        fileInput.on('change', function() {
            const selectedFile = fileInput[0].files[0];
            if (selectedFile) {
                $('#uploadButton').prop('disabled', false);
                fileName.text('File Name: ' + selectedFile.name);
            } else {
                fileName.text('');
                $('#uploadButton').prop('disabled', true);
            }
        });
    }

    function uploadFile() {
        $('#upload_excel').submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $('#loading_overlay, #spinner_upload').removeClass('d-none');

            $.ajax({
                url: "{{ route('import.post') }}",
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                cache: false,
                success: function(res) {
                    if (res === 'success') {
                        $.ajax({
                            url: "{{ route('insertStudent.post') }}",
                            method: 'get',
                            success: function(response) {
                                if (response === 'success') {
                                    $('#loading_overlay, #spinner_border').addClass('d-none');
                                    Swal.fire('Success!', 'Students imported successfully.', 'success');
                                    $('#file-name').text('');
                                    $('#upload_excel').trigger('reset');
                                    $('#uploadButton').prop('disabled', true);
                                }
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        });
                    } else {
                        $('#file-name').text('');
                        Swal.fire('Error!', res.error, 'error');
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
    }
</script>
