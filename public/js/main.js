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
                $('#sidebar').toggleClass('active-buttom'),
                $buttomNav.find('.nav-avatar').hide();
                $buttomNav.toggleClass('active');
            });
});