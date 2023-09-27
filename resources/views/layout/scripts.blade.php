{{-- Bootstrap Cdn --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- Font Awesome --}}
<script src="https://kit.fontawesome.com/54bcf78a4d.js" crossorigin="anonymous"></script>
{{-- Jquery --}}
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
    integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- Datatables --}}
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

{{-- Sweet Alert --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
{{-- Sweet Alert Header --}}
<script>
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success mx-1",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    });

    $(document).ready(function() {
        $("#table").DataTable();

        //function to collapse sidebar
        $(document).on('click', '#menu-toggle', () => {
            $('#wrapper').toggleClass('toggled');
        });

    });
</script>

@include('layout.sweet_alert')
