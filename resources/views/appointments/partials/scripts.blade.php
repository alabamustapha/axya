  <script src="{{asset('js/vendor/jquery.timepicker.min.js')}}"></script>

  <script>
    $('#timepicker .time').timepicker({
      'showDuration': true,
      'timeFormat': 'h:i A',
      'scrollDefault': 'now',
      // 'step': 10,
      'show2400': true,
    });
  </script>

  <script>
    $(document).ready(function () {
      /**
       * Home visitation field hidden by default
      /******************************************************/
      $('#type').on('change',function(e){
          console.log(e);
          var type = e.target.value;

          if (type == 'Home') {
            $('#home-visitation').css('display', 'block');
            $('#address').attr('required', true);
            $('#phone').attr('required', true);
          } else { 
            $('#address').val('').attr('required', false);
            $('#phone').val('').attr('required', false);
            $('#home-visitation').css('display', 'none');
          }
      });

      // If End time is behind start time or fee is negative, reject input and hide.
      $('#type').prop('checked',function(e){
        if ($('#type').val() == 'Home') {
          $('#home-visitation').css('display', 'block');
        } else {
          $('#home-visitation').css('display', 'none');
        }
      });

      /**
       * Calculate consultation fee and display to patient
      /******************************************************/
      $('#to,#from').on('blur',function(e){
        var to            = $('#to').val();
        var from          = $('#from').val();
        var doctor_session= $('#session').val();
        var doctor_rate   = $('#rate').val();

        // Convert Start and End time to moment format.
        var mmfrom = moment(from,"HH:mm a");
        var mmto   = moment(to,"HH:mm a");

        // Calculate duration, no of sessions and consultation fee.
        var duration_basic = mmto.diff(mmfrom, 'minutes');
        var no_of_sessions = Math.ceil(duration_basic / doctor_session);
        var duration       = mmto.diff(mmfrom, 'minutes') +"minutes";
        var cost           = no_of_sessions * doctor_rate;

        // Display calculated appointment deal section with user interaction.
        // If Start and End time is selected, display deal else hide.
        if ((from != undefined && from.length) && (to != undefined && to.length)) {
          $('#deal').css('display', 'block');
          $('#no_of_sessions').html(no_of_sessions);
          $('#duration').html(duration); 
          $('#cost').html(cost); 
        } else { 
          $('#duration').val('');
          $('#cost').val('');
          $('#deal').css('display', 'none');
        }

        // If End time is behind start time or fee is negative, reject input and hide.
        if (cost <= 0 || mmto <= mmfrom) {
          $('#to').css('borderColor', 'red');
          $('#to').val('');
          $('#deal').css('display', 'none');
        } else {
            $('#to').css('borderColor', '');
        }
      });
      
    });
  </script>