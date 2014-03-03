/**
 * Created with JetBrains PhpStorm.
 * User: nester_a
 * Date: 28.01.14
 * Time: 15:18
 * To change this template use File | Settings | File Templates.
 */

function saveOrder(listID)
{
    $("#"+listID+"-result").slideDown().addClass('saving').text('Saving...');

    $.ajax({
        url: $("#" + listID).attr('action'),
        type: 'post',
        data: $("#" + listID).serialize()
    })
    .done(function() {
        $("#"+listID+"-result").removeClass('saving').addClass('success').text('Successfully saved');
        setTimeout(function(){
            $("#"+listID+"-result").slideUp().removeClass('success').html('');
        }, 2000);
    })
    .fail(function() {
        $("#"+listID+"-result").removeClass('saving').addClass('error').text('Error while saving');
        setTimeout(function(){
            $("#"+listID+"-result").slideUp().removeClass('error').html('');
        }, 2000);
    });
}
