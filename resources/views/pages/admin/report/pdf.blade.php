{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
    
</head>

<body>

    {{ $type }}
    {{ $faculties->last_name }}
    @foreach ($computation as $key => $item)
        <p>{{ $key }}</p>
        <p>{{ $item[0] }}</p>
        <p>{{ $item[1] }}</p>
        <p>{{ $item[2] }}</p>
        <p>{{ $item[3] }}</p>
    @endforeach
    <div class="container-fluid border border-dark p-5">

    </div>
    @dump($faculties)
    @dump($type)
    @dump($final_average)
    @dump($new_year_sem)



</body>

</html> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-container{
            width:720px ;
        }
        table.custom-table {
        border-collapse: collapse;
        width: 100%;
        }

        table.custom-table thead td {
            border: 1px solid #000; /* 1px solid black border */
            padding: 2px;
            text-align: center;
            vertical-align:top;
            font-size:15px;
            font-weight:600;
        }
        table.custom-table tbody td {
            border: 1px solid #000; /* 1px solid black border */
            padding: 2px;
            text-align: center;
            vertical-align: middle;
            font-size:15px;
            font-weight:normal;
           
        }

      
        /* Styling for the overlay */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            display: flex; 
            justify-content: center; 
            align-items: center; 
        }


        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
</head>
<body class="d-flex justify-content-center bg-dark ">
    <div id="loading-overlay">
        <div class="loader"></div>
    </div>
    
    <div class="main-container bg-white">
        <div class="container-fluid px-5">
            <div class="row mt-3">
                <div class="col-2">
                    <img src="/assets/img/main/basc.png" class="img-fluid rounded-circle" width="150">
                </div>
                <div class="col-8">
                        <div class="my-2 text-center">
                            <p class="m-0 p-0 fs-6">Republic of the Philippines</p>
                            <h5 class="m-0 p-0 fw-bold text-success">BULACAN AGRICULTURAL STATE COLLEGE</h5>
                            <p class="m-0 p-0 fs-6">Pinaod, San Ildefonso, Bulacan, Philippines 3010</p>
                    </div>
                </div>
            </div>
            <hr class="border border-success border-2 m-0 opacity-75">
    
            <div class="row mt-2 ">
                <p class="mt-2">20 July 2023</p>
                <h2 class="text-center my-2 fw-bold text-uppercase">CERTIFICATION</h1>
            </div>
            @php 
                $text_base = ($type == 'student') ?
                 'This is to certify that the faculty listed below obtained the indicated average student evaluation
                    in the specified term: ' : 'This is to certify that the faculty listed below obtained the indicated supervisor evaluation
                    in the specified term: ';
                $roles = ($type == 'student' ? 'average student' : 'supervisor')
            @endphp
            <div class="row mt-4">
                <p class="fw-bold p-1">To whom it may concern:</p>
                <p class="m-0 p-1">
                    {{ $text_base }}
                </p>
            </div>
    
            <div class="row mt-3">
                <table class="table custom-table">
                    <thead>
                        <tr class="text-center">
                            <td style="width: 250px;">Faculty Name</td>
                            <td class="text-capitalize">{{ $roles }} Evaluation</td>
                            <td>Equivalent</td>
                            <td>Term</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td class="text-capitalize">{{ $faculties->first_name.' '.$faculties->middle_name.' '.$faculties->last_name }}</td>
                            <td>{{ $final_average['total'] }}%</td>
                            <td>{{ $final_average['equivalent'] }}</td>
                            <td id="year_sem">{{ $new_year_sem }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="  text-capitalize" id="type_js">{{ $type }}</p>
            <div class="row mt-2">
                <p class="m-0 p-1">This certificate is being issued for faculty reclassification purposes under DBM-CHED Joint 
                    Circular No.3, s.2023.
                </p>
            </div>
    
            <div class="row mt-5 pb-2 text-center">
                <p class="text-uppercase fw-bold mb-0 pb-0">Eiffel n. marcelo</p>
                <p class="m-0">Institute QCE Coordinator, Insitute of Arts and Sciences</p>
            </div>
            <div class="row mt-5 text-center">
                <p class="text-uppercase fw-bold mb-0 pb-0">esmeraldo jr. dc. valmores</p>
                <p class="m-0">Institute QCE Coordinator, Insitute of Arts and Sciences</p>
            </div>
            <div class="row mt-5 text-center">
                <p class="mt-3">Review by:</p>
                <p class="text-uppercase fw-bold mb-0 pb-0">robert a. capalad</p>
                <p class="m-0">Head, QCE Evaluation Committee</p>
            </div>
    
    
        </div>    
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>

        $(document).ready(function() {
            generatePDF();
        });
        

        function generatePDF() {
            const { jsPDF } = window.jspdf;
            const element = document.querySelector('.main-container');
            const scale = 2; 

            $('#loading-overlay').show();

            html2canvas(element, { scale: scale }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4');
                pdf.addImage(imgData, 'PNG', 0, 0, 210, 250); 

                let file_name = $('#type_js').text();
                var up_file_name = file_name[0].toUpperCase() + file_name.slice(1);
                up_file_name = up_file_name + '-Evaluation [' + $('#year_sem').text() + ']';
                pdf.save(up_file_name); 
                $('#loading-overlay').hide();
                window.location.href = "/report";
            });
        }

    </script>
      
      
</body>
</html>
