<script>
    $(document).ready(function(){
        showSetYear();
        addYear();
        viewSemester();
        createInitialBarGraph();
        initializeCharts();
        

    })
    function createInitialBarGraph() {
        var staticData = {
            labels: ['CA', 'IAS', 'IEAT', 'IED', 'IM'],
            datasets: [{
                label: 'Number of Faculty',
                data: [0, 0, 0, 0, 0], 
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)'
                ],
                borderWidth: 1
            }]
        };

        var ctx = document.getElementById('facultyChart').getContext('2d');
        var facultyChart = new Chart(ctx, {
            type: 'bar',
            data: staticData, 
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });
    }



    function loadDataAndInitialize() {
        chart(0, 0, 0, 0);

        createInitialBarGraph();
        $.ajax({
            url: "{{ route('statistic') }}",
            method: 'get',
            success: function (res) {
                if (res) {
                    updateTotalCounts(res.total_student, res.total_faculty);

                    updateDoughnutCharts(res.dean, res.student);

                    updateBarChart(res.total_institute);
                }
            },
            error: function (error) {
                console.log("Error:", error);
            }
        });
    }


    function updateTotalCounts(totalStudent, totalFaculty) {
        $('#dashboard_total_students').text(totalStudent);
        $('#dashboard_total_faculties').text(totalFaculty);
    }

    // Update the doughnut charts
    function updateDoughnutCharts(deanData, studentData) {
        if (deanData && studentData) {
            chart(deanData[0], deanData[1], studentData[0], studentData[1]);
        }
    }

    function chart(deansDoneCount, deansNotDoneCount, studentsDoneCount, studentsNotDoneCount) {
        var deansData = getChartData(deansDoneCount, deansNotDoneCount, "#004225", "#AEC3AE");
        var studentsData = getChartData(studentsDoneCount, studentsNotDoneCount, "#952323", "#EEE2DE");

        createOrUpdateChart('deansCanvas', deansData, 55);
        createOrUpdateChart('studentsCanvas', studentsData, 55);
    }

    function createOrUpdateChart(canvasId, chartData, cutoutPercentage) {
        var canvas = $('#' + canvasId);
        var existingChart = canvas.data('chart');

        if (existingChart) {
            existingChart.data = chartData;
            existingChart.update();
        } else {
            var newChart = new Chart(canvas, {
                type: 'doughnut',
                data: chartData,
                options: {
                    cutoutPercentage: cutoutPercentage,
                }
            });

            canvas.data('chart', newChart);
        }
    }

    function getChartData(doneCount, notDoneCount, doneColor, notDoneColor) {
        return {
            labels: ["Done", "Pending"],
            datasets: [
                {
                    data: [doneCount, notDoneCount],
                    backgroundColor: [doneColor, notDoneColor],
                },
            ],
        };
    }

    function updateBarChart(data) {
        if (data && data.length >= 5) {
            var facultyData = {
                labels: ['CA', 'IAS', 'IEAT', 'IED', 'IM'],
                datasets: [{
                    label: 'Number of Faculty',
                    data: data.slice(0, 5),
                    backgroundColor: [
                        'rgba(0, 255, 0, 0.2)',
                        'rgb(54, 162, 235, 0.2)',
                        'rgb(149, 35, 35, 0.2)',
                        'rgba(83, 112, 252, 0.2)',
                        'rgba(139, 80, 253, 0.2)'
                    ],
                    borderColor: [
                        'rgb(0, 255, 0)',
                        'rgb(54, 162, 235)',
                        'rgb(149, 35, 35)',
                        'rgb(83, 112, 252)',
                        'rgb(139, 80, 253)'
                    ],
                    borderWidth: 1
                }]
            };

            updateBarGraphWithData(facultyData);
        }
    }

    function updateBarGraphWithData(data) {
        var ctx = document.getElementById('facultyChart').getContext('2d');
        var facultyChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });
    }

    function initializeCharts() {
        loadDataAndInitialize();
    }


    
    function addYear(){
        $(document).on('click', '#btn_update_year', function(e){
            e.preventDefault();

            const currentYear = new Date().getFullYear();
            const nextYear = currentYear + 1;
            const academicYearNow = `${currentYear}-${nextYear}`;

            $.ajax({
                url: "{{ route('post.dashboard') }}",
                method: 'post',
                data:{_token: "{{ csrf_token() }}",
                year:academicYearNow},
                success: function(res){
                    if(res == 'success'){
                        Swal.fire('Updated!',
                        'Academic Year updated successfully.',
                        'success');
                        showSetYear();  

                    } else {
                        Swal.fire('Up to Date!',
                        'Academic Year is already updated.',
                        'success');
                        showSetYear();
                    }
                }
            })
        })
    }


    
    
    //show on set year
    function showSetYear(){
        $.ajax({
            url: "{{ route('show.dashboard') }}",
            method: 'get',
            success: function(res){
                if(Object.keys(res).length > 0){
                    $('#academic_year').text(res.year);
                    currentYear = res.year;
                    if(res.semester == 1){
                        $('#semester').text(`${res.semester}st semester`);
                    } else {
                        $('#semester').text(`${res.semester}nd semester`);
                    }
                } else {
                    $('#academic_year').text('---');
                    $('#semester').text('---');
                }
                
                
            }
        })

    }

    //view semester
    function viewSemester() {
        $(document).on('submit', '#update_sem', function (e) {
            e.preventDefault();
            $('#btn_update_sem').text('Updating...');
            const fd = new FormData(this);

            $.ajax({
                url: "{{ route('edit.dashboard') }}",
                method: 'post',
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res == 'success') {
                        Swal.fire('Updated!',
                            'Semester updated successfully.',
                            'success');
                        $('#btn_update_sem').text('Update Sem');
                        $('#edit_sem').modal('hide');
                        showSetYear();
                    } else {
                        $('#btn_update_sem').text('Update Sem');
                        Swal.fire('Error!',
                        'Semester cant back set.',
                        'error')
                    }
                }
            });
        });

        $(document).on('shown.bs.modal', '#edit_sem', function () {
            $.ajax({
                url: "{{ route('show.dashboard') }}",
                method: 'get',
                success: function (res) {
                    $('#semester_id').val(res.id);
                }
            });
        });
}

</script>