/**
 * Created by user on 9/20/15.
 */
jQuery(document).ready(function($) {
    // people list activate
    var ac;
    $('.category-list li div').click(function() {
        ac = $(this).attr('class');
        $('.category-list li div').removeClass('active');
        $('.people-list li div').removeClass('active');
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('.people-list').removeClass('filter');
        }
        else {
            $(this).addClass('active');
            $('.people-list').addClass('filter');
            $('.people-list li div.'+ac).addClass('active');
        }
        console.log(ac);
    });
    $('.jcarousel').jcarousel({
        wrap: 'both'
    });

    $('.jcarousel-control-next')
        .on('jcarouselcontrol:active', function() {
            $(this).removeClass('inactive');
        })
        .on('jcarouselcontrol:inactive', function() {
            $(this).addClass('inactive');
        })
        .jcarouselControl({
            // Options go here
            target: '+=1'
        });
    $('.jcarousel-control-prev')
        .on('jcarouselcontrol:active', function() {
            $(this).removeClass('inactive');
        })
        .on('jcarouselcontrol:inactive', function() {
            $(this).addClass('inactive');
        })
        .jcarouselControl({
            // Options go here
            target: '-=1'
        });
});