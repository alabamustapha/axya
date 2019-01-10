    <script src="{{asset('js/app.js')}}"></script>

    <script src="{{asset('js/vendor/moment.min.js')}}"></script>
    <script src="{{asset('js/vendor/pikaday.js')}}"></script>
    <!-- full Calender js -->
    <script src="{{asset('js/vendor/fullcalendar.min.js')}}"></script>
    
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

    @auth
      @if (Auth::user()->is_doctor)
        <!-- New Subscription SCRIPT -->
        <script>
            $(document).ready(function () {  
              /**
               * Get the values of the appropriate fields
              /******************************************************/
              $('#type,#multiple').on('change',function(e){
                var type            = $('#type').val();
                var multiple        = $('#multiple').val();
                // hexdec
                // var weekly_rate     = parseInt($('#weekly_rate').val(), 16); hidden field
                // var monthly_rate    = parseInt($('#monthly_rate').val(), 16);
                // var yearly_rate     = parseInt($('#yearly_rate').val(), 16);

                if (type != '3' && type != '2' && type != '1') {
                  $('#type').attr('autofocus', true);
                  $('#type').val('1');
                }

                var type_text= type == '3' ? 'year(s)' :(type == '2' ? 'month(s)' : 'week(s)');
                var type_fee = type == '3' ? 4500      :(type == '2' ? 390        : 100);
                console.log(type_fee);

                var calc_amount     = type_fee * multiple;

                // Display selection section
                if ((type != undefined && type.length) && (multiple != undefined && multiple.length)) {
                  $('#selection').css('display', 'block');
                  $('#sel_type').html(type_text);
                  $('#sel_multiple').html(multiple);
                  $('#amount').html(calc_amount);
                } else { 
                  $('#sel_type').val();
                  $('#sel_multiple').val();
                  $('#amount').val();
                  $('#selection').css('display', 'none');
                }
              });
            });
        </script>
      @endif
    @endauth

    @yield('scripts')