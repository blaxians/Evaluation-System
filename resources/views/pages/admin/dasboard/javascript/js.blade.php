<script>
    $(document).ready(function(){
        showSetYear();
        addYear();
        viewSemester();
        chart();
        bargraph();

        
        
    })
    //charts function

    function getDeansData() {
        //data ng downut
            var deansDoneCount = 20;
            var deansNotDoneCount = 5;

            return {
                labels: ["Done", "Pending"],
                datasets: [
                    {
                        data: [deansDoneCount, deansNotDoneCount],
                        backgroundColor: ["#36A2EB", "#FFCE56"], //kulay nung downut
                         
                    },
                ],
            };
        }

    function getStudentsData() {
        //data ng downut
        var studentsDoneCount = 35;
        var studentsNotDoneCount = 10;

        return {
            labels: ["Done", "Pending"],
            datasets: [
                {
                    data: [studentsDoneCount, studentsNotDoneCount],
                    backgroundColor: ["#1BC500", "#FF5733"], //kulay nung downut
                     
                },
            ],
        };
    }

    Chart.plugins.register({
        afterDraw: function(chart) {
            if (chart.config.type === 'doughnut') {
            var ctx = chart.chart.ctx;
            var width = chart.chart.width;
            var height = chart.chart.height;
            var total = 0;
            
            chart.data.datasets[0].data.forEach(function (value) {
                total += value;
            });

            var donePercentage = ((chart.data.datasets[0].data[0] / total) * 100).toFixed(2) + '%';

            //format nung text percentage
            ctx.restore();
            ctx.font = "18px Arial";
            ctx.textBaseline = "middle";
            ctx.fillStyle = "#000";
            
            //alignment nung text percentage
            var text = donePercentage;
            var textX = Math.round((width - ctx.measureText(text).width) / 2);
            var textY = height / 1.8;
            
            ctx.fillText(text, textX, textY);
            ctx.save();
            }
        }
        });

    function chart() {
        var deansData = getDeansData();

        new Chart($('#deansCanvas'), {
            type: 'doughnut',
            data: deansData,
            options: {
            cutoutPercentage: 55, //kapal nung downut
            }
        });

        var studentsData = getStudentsData();

        new Chart($('#studentsCanvas'), {
            type: 'doughnut',
            data: studentsData,
            options: {
            cutoutPercentage: 55, //yung kapal nung downut
            }
        });
    }

    //bargraph
    function bargraph(){
        var facultyData = {
        labels: ['CA', 'IAS', 'IEAT', 'IED', 'IM'],
            datasets: [{
                label: 'Number of Faculty',
                data: [25, 30, 15, 20, 18], 
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
            data: facultyData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });
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