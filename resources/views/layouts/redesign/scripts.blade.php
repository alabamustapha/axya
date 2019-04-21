 
    @if (app()->environment('local'))
        <script src="{{asset('js/vendors.js')}}"></script>
        <script src="{{asset('js/custom.js')}}"></script>
    @else
        <script src="{{asset('js/vendors.min.js')}}"></script>
        <script src="{{asset('js/custom.min.js')}}"></script>
    @endif

    <script> $('div.alert').not('.alert-important').delay(7000).fadeOut(350); </script>


    <script>
      // https://github.com/Pikaday/Pikaday ..Customization..
      var picker = new Pikaday({ 
        field: document.getElementById('datepicker'),
        format: 'Y-M-D',
        onSelect: function() {
          // console.log(this.getMoment().format('Y-M-D'));
        }
      });
      picker.gotoToday();
      // Fix repetition by regex match (datepicker + anything) and add programatically if necessary.  
      
      var picker = new Pikaday({ 
        field: document.getElementById('datepicker2'),
        format: 'Y-M-D',
        onSelect: function() {
          // console.log(this.getMoment().format('Y-M-D'));
        }
      });
      picker.gotoToday();

      var picker = new Pikaday({ 
        field: document.getElementById('datepicker3'),
        format: 'Y-M-D',
        onSelect: function() {
          // console.log(this.getMoment().format('Y-M-D'));
        }
      });
      picker.gotoToday();
    </script>


    <!-- inline scripts -->

    @guest
      <!-- SIGN UP SCRIPT -->
      <script>        
        $(document).ready(function(){
           let $docAcct = $('#doc-acct');
           let $patAcct = $('#pat-acct');
           let selectColor = "btn-theme-blue";

           function hasSelectedColor(theClass) {
               return theClass.hasClass(selectColor);
           }

           function toggleColorChange(theClass){
                if (hasSelectedColor(theClass)) {
                    theClass.removeClass(selectColor);

               } else {
                  
                   $('.acct-type').find('.btn-theme-blue').removeClass(selectColor); 

                   theClass.addClass(selectColor);
               }
           }

           $docAcct.click(function(){
               toggleColorChange($(this));               
           })
           $patAcct.click(function(){
               toggleColorChange($(this));               
           })
        });        
      </script>
    @endguest
    
    @if (Auth::check() && Auth::user()->is_doctor)
        <!-- New Subscription SCRIPT -->
        <script>
            $(document).ready(function () {  
              /**
               * Get the values of the appropriate fields
              /******************************************************/
              $('#type,#multiple').on('click change',function(e){
                var type            = $('#type').val();
                var multiple        = $('#multiple').val();
                // hexdec
                // var weekly_rate     = parseInt($('#weekly_rate').val(), 16); hidden field
                // var monthly_rate    = parseInt($('#monthly_rate').val(), 16);
                // var yearly_rate     = parseInt($('#yearly_rate').val(), 16);

                if ((type != '3' && type != '2' && type != '1') || isNaN(type)) {
                  $('#type').attr('autofocus', true);
                  $('#type').val('1');
                  var type = $('#type').val();
                }
                if (multiple < 1 || isNaN(multiple)) {
                  // Prevent negative numbers of non-number inputs.
                  $('#multiple').attr('autofocus', true);
                  $('#multiple').val('1');
                  var multiple = $('#multiple').val();
                }

                var pluralize= (multiple > 1) ? 's':'';
                var type_text= (type == '3') ? 'year'+ pluralize :(type == '2' ? 'month'+ pluralize : 'week'+ pluralize);
                // var type_fee = type == '3' ? 4500      :(type == '2' ? 390        : 100);
                // console.log(type_fee);

                // var calc_amount     = type_fee * multiple;


                var app_weekly_rate      = 100;
                var app_monthly_discount = 5; //5% Got from admin setting.
                var app_yearly_discount  = 8; //8% Got from admin setting. Cost higher for yearly discount...Ratify soon
                var monthly_discount     = (app_monthly_discount / 100); // = 0.05;
                var yearly_discount      = (app_yearly_discount / 100);  // = 0.08;
 
                var typeWeeksCount = type == '3' ?  48 : (type == '2' ?  4 : 1); // For Discount & fee Calculation (Adjusted: 48wks from 52wks based on discounting descrepancies).
                var typeDaysCount  = type == '3' ? 365 : (type == '2' ? 30 : 7); // For Sub start & end date Calculation.
                var typeDiscount   = type == '3' ? yearly_discount : (type == '2' ? monthly_discount : 0.0); // Yearly 8%, Monthly 5%, Weekly 0%.

                var discount       =  app_weekly_rate * typeWeeksCount * typeDiscount;
                var typeFee        = (app_weekly_rate * typeWeeksCount) - discount;
                console.log(typeFee);

                var discount_saved     = discount * multiple;
                var subscriptionAmount = typeFee * multiple;


                // Display selection section
                if ((type != undefined && type.length) && (multiple != undefined && multiple.length)) {
                  $('#selection').css('display', 'block');
                  $('#sel_type').html(type_text);
                  $('#sel_multiple').html(multiple);
                  $('#amount').html(subscriptionAmount);
                  $('#discounted').html(discount_saved);
                } else { 
                  $('#sel_type').val();
                  $('#sel_multiple').val();
                  $('#amount').val();
                  $('#discounted').val();
                  $('#selection').css('display', 'none');
                }
              });
            });
        </script>
    @endif

    @yield('scripts')