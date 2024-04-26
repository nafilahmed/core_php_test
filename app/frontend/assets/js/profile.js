$(document).ready(function() {
    var panels = $('.user-infos');
    var panelsButton = $('.dropdown-user');
    panels.hide();

    //Click dropdown
    panelsButton.click(function() {
        //get data-for attribute
        var dataFor = $(this).attr('data-for');
        var idFor = $(dataFor);

        //current button
        var currentButton = $(this);
        idFor.slideToggle(400, function() {
            //Completed slidetoggle
            if(idFor.is(':visible'))
            {
                currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
            }
            else
            {
                currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
            }
        })
    });


    $('[data-toggle="tooltip"]').tooltip();

    $('#sync_prayer_time').click(function() {

        $("#loadingModal").modal('show');

        $.ajax({
          url:"sync-namaz-time.php",    //the page containing php script
          type: "post",    //request type,
          dataType: 'json',
          data: {sync_name_time: "1"},
          complete : function(res) {
            location.reload();
          }
        });
    });


    $('#logout').click(function() {

        localStorage.clear();
    });
});