
    <!-- Optional JavaScript -->
    <script src="{{asset('js/vendors.js')}}"></script>
    
    <!-- jquery script -->
    <script src="{{asset('js/vendor/jquery-3.3.1.min.js')}}"></script>
    <!-- popper js -->
    <script src="{{asset('js/vendor/popper.min.js')}}"></script>    
    <!-- bootstrap js -->
    <script src="{{asset('js/vendor/bootstrap.min.js')}}"></script>    
    <!-- Main js -->
    <script src="{{asset('js/custom/main.js')}}"></script>


    @if (app()->environment('local'))
      <script src="{{asset('js/vendor/jquery.dataTables.min.js')}}"></script>
      <script src="{{asset('js/vendor/Chart.min.js')}}"></script>
    @else
      <!-- Datatable js -->
      <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

     <!-- CHART JS -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"
      integrity="sha256-oSgtFCCmHWRPQ/JmR4OoZ3Xke1Pw4v50uh6pLcu+fIc=" crossorigin="anonymous"></script>
    @endif

    <script> $('div.alert').not('.alert-important').delay(7000).fadeOut(350); </script>

    <script>

        // instantiating the chart class

        var ctx = document.getElementById("myChart").getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["sun", "mon", "tues", "wed", "thur", "fri", "sat"],
                datasets: [
                {
                    label: '# of appointments',
                    data: [500, 600, 100,350, 765, 98, 320],
                     backgroundColor: [
                        'rgba(18, 167, 255, 0.36)'

                    ],
                    borderColor: [
                        'rgba(24,199,132,1)'
                    ],
                    borderWidth: 1

                }
                
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>