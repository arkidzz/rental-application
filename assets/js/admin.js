jQuery(document).ready(function($) {

    //tabs
    $('.tabs__item').each(function(){

        $(this).on('click', function(e){
            e.preventDefault();
            var $id = $(this).data('id');
            var tabelement = $('#'+$id);

            //remove all active class
            $('.tabs__item').removeClass('active');

            //remove all hide class
            $('.tabs__content').addClass('hide');

            if( tabelement.hasClass('hide') ) {
                tabelement.removeClass('hide');
            }

            if( $(this).hasClass('active') ) {
                $(this).removeClass('active');
            }else {
                $(this).addClass('active');
            }

        });

    });

})