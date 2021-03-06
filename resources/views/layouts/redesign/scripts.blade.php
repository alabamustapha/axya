    <script src="{{asset('js/app.js')}}"></script>

    @if (app()->environment('production'))
      {{-- Get all vendor scripts from CDN --}}
      <script src="{{asset('js/vendor/moment.min.js')}}"></script>
      <script src="{{asset('js/vendor/pikaday.js')}}"></script>
      <script src="{{asset('js/vendor/fullcalendar.min.js')}}"></script>
    @else
      <script src="{{asset('js/vendor/moment.min.js')}}"></script>
      <script src="{{asset('js/vendor/pikaday.js')}}"></script>
      <!-- full Calender js -->
      <script src="{{asset('js/vendor/fullcalendar.min.js')}}"></script>
      <script src="{{asset('js/vendor/shuffle.min.js')}}"></script>
    @endif
    
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script> $('div.alert').not('.alert-important').delay(7000).fadeOut(350); </script>

    <script>
      // https://github.com/Pikaday/Pikaday ..Customization..
      var picker = new Pikaday({ 
        field: document.getElementById('datepicker'),
        format: 'Y-M-D',
        onSelect: function() {
          console.log(this.getMoment().format('Y-M-D'));
        }
      });
      picker.gotoToday();
      // Fix repetition by regex match (datepicker + anything) and add programatically if necessary.  
      
      var picker = new Pikaday({ 
        field: document.getElementById('datepicker2'),
        format: 'Y-M-D',
        onSelect: function() {
          console.log(this.getMoment().format('Y-M-D'));
        }
      });
      picker.gotoToday();

      var picker = new Pikaday({ 
        field: document.getElementById('datepicker3'),
        format: 'Y-M-D',
        onSelect: function() {
          console.log(this.getMoment().format('Y-M-D'));
        }
      });
      picker.gotoToday();
    </script>


    <!-- inline scripts -->

    <!-- Full Calendar SCRIPT -->
    <script>
      $(document).ready(function () {

            // page is now ready, initialize the calendar...

           $('#calendar').fullCalendar({
             height: 500,
           
            dayClick: function (date, jsEvent, view) {
                
                   alert('Clicked on: ' + date.format());

               },
            events: [
                   {
                       title: 'Appointment',
                       start: '2019-01-03T13:13:55.008',
                       end: '2019-01-03T13:13:55.008'
                   },
                   {
                       title: 'Event Title2',
                       start: '2019-01-05T13:13:55-0400',
                       end: '2019-01-05T13:13:55-0400'
                   }
               ]
              
          });
            
        });
    </script>

    <!-- SEARCH RESULT SCRIPT -->
    <script>

        $(document).ready(function () {

            /**
            * SCRIPT TO SHOW THE SEARCH RESULT AREA
            */

            let $searchBox = $('#search');
            // create the overlay and append to body
            let $searchOverlay = $("<div id='search-overlay'></div>");
            $('body').append($searchOverlay);

            function removeSearchResult() {
                $('.search-container').removeClass('search-active'),
                    $('#search-result').fadeOut(500),
                    $('.search-close').fadeOut(500),
                    $searchOverlay.fadeOut(500),
                    $('.search-icon').removeClass('bg-white text-theme-blue'),
                    $searchBox.val("");
            }

            function showSearchResult() {
                $searchOverlay.fadeIn(500);

                // push search-container up wards
                $('.search-container').addClass('search-active');

                // display the search list and close btn

                $('#search-result').fadeIn(500);
                $('.search-close').fadeIn(500);

                // change search icon style
                $('.search-icon').addClass('bg-white text-theme-blue');
            }
            // show on keypress to search

            $searchBox.on('keypress', showSearchResult);
            $('button.search-icon').click(function (event) {
                event.preventDefault();
                showSearchResult();
            });
            $searchBox.click(function () {
                if ($searchBox.val() == "") {
                    console.log('empty');
                } else {
                    console.log('not empty');

                }

            });

            $('.s-close').click(removeSearchResult);

            $searchBox.on('keyup', function () {
                if ($(this).val() == "") {
                    removeSearchResult();
                }
            });


            /**
            * SCRIPT TO DISPLAY RESULTS
            */

            //search query

            $searchBox.on('keyup', function () {
                let searchQuery = $searchBox.val();
                $('.result-title').text('Search Result for ' + searchQuery);
            })

        });

    </script>

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