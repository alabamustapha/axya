  $(document).ready(function () {


    //   NAVIGATION TOGGLE 
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active'),
                $('#content').toggleClass('active');
            });

            let $excessNav = $('.xs-nav');
            let $buttomNav = $('#extra-buttom-nav');
            let $buttomBtnToggler = $('.buttom-nav-toggler');

            
            if(document.body.scrollWidth <= 992){
                $excessNav.hide();
                $buttomNav.addClass('collapse ');
                $('.navbar-brand img').attr('src', '../images/axya-logo-mini.svg').css('margin', '0'),
                $('.main-nav').find('.search-form').css('padding','.25rem'),
                $('.notification-count').css('borderColor','#147ba7');
                // alert("yes");      
                
            }else{
                $excessNav.show(),
                $buttomNav.show();
                // alert("nont");      
            }

            $buttomBtnToggler.click(function () {
                $('#buttom-nav').append($buttomNav),
                $('#content').toggleClass('active-buttom'),
                $('#sidebar').toggleClass('active-buttom'),0
                $buttomNav.find('.nav-avatar').hide();
                $buttomNav.toggleClass('active');
            });
            

    // SEARCH SCRIPT
            // GLOBALS
            let $searchForm = $('.search-form'),
                $searchComponents = $('.search-component'),
                $searchOption= $('.search-options'),
                $ssDisplay = $('.search-select-display'),
                $searchItem = $('.search-item'),
                $filterItem = $('.filter .dropdown-item'),
                $profileContainer = $('.profile-container');
               

            // show the search-components
           
            
            function openAction() {
                $searchComponents.show().css('z-index', '3'),
                $searchOption.css('z-index', '10'),
                $ssDisplay.css('opacity', '1');
                $('.crumb').hide();
                $('.wrapper-content .content').hide();

            }

            function closeAction() {
                $searchComponents.hide().css('z-index', '-10'),
                $ssDisplay.css('opacity', '0');
                $('.crumb').show();
                $('.wrapper-content .content').show();

            }

            $searchForm.keypress(openAction);
          
            $searchForm.keyup(function(){
                if($searchForm.val() == ""){
                   closeAction();
                    $ssDisplay.find('.display-wrapper').hide();
                }

            });


            // DISPLAY FILTER LIST AND TYPE
            
                
            if ($filterItem.hasClass('active')){
                $('.filter-type').text($('.filter .dropdown-item.active').text());
            }
            $filterItem.click(function () {
               $filterItem.removeClass('active');
               $(this).addClass('active');  
               
               let filterText = $(this).text();
               $('.filter-type').text(filterText);
            })


            // GET SERACH RESULT INFO 

            $searchItem.click(function(){
                    $ssDisplay.find('.display-wrapper').show();

                let name =       $(this).find('#p-d').find('.name').text(),
                    speciality = $(this).find('#p-d').find('.speciality').text(),
                    workName =   $(this).find('#w-d').find('.name').text(),
                    fee =        $(this).find('#w-d').find('.fee strong').text(),
                    imgSrc=      $(this).find('.doc-img').attr('src');

                    
                    $ssDisplay.find('.user-img img').attr('src', imgSrc);
                    $ssDisplay.find('.details .name').text(name);
                    $ssDisplay.find('.details .speciality').text(speciality);

                    $profileContainer.find('.profile-img img').attr('src', imgSrc),
                    $profileContainer.find('.profile-details .category .name').text(name),
                    $profileContainer.find('.profile-details .category .office-name').text(workName),
                    $profileContainer.find('.profile-details .fee').text(fee);


              
            });

});