<!-- The Alarm Modal -->
<div class="modal" id="AlarmModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <h4 class="modal-title text-center">Alarm Alert</h4>
            <form action="" method="post">
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="container-fluid text-center" style="padding-top: 5%; padding-bottom: 5%;">
                        <div class="form-group p-1">
                            <input type="hidden" class="form-control" name="box_id" value="<?php echo isset($boxData['id']) ? $boxData['id'] :  '';  ?>">
                        </div>
                        <div class="form-group p-1">
                            <button type="button" id="alarm_off_btn" class="btn btn-danger">Switch Off</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<!-- The Alarm Modal -->
<div class="modal" id="loadingModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <h4 class="modal-title text-center">Fetching Namaz Time</h4>
            <form action="" method="post">
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                      <div class="spinner-grow" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="container">
    <p class="float-end"><a href="#">Back to top</a></p>
    <p>&copy; 2017–2024 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
</footer>
</main>

<script type="text/javascript">
  $(document).ready(function() {
    console.log(localStorage.getItem("namaz_name"));

  <?php if ($user->isLoggedIn() && !empty(Session::get('subscription_data'))) { ?>


    var alarmTime, isAlarmSet,
        ringtone = new Audio("<?php echo "./" . Session::get('subscription_data')['azan_path']; ?>");

    var currentDate = new Date();
    var formattedDate = currentDate.getFullYear() + '-' + ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' + ('0' + currentDate.getDate()).slice(-2);

    var h = currentDate.getHours();
    var m = currentDate.getMinutes();

    h = ('0' + h).slice(-2);
    m = ('0' + m).slice(-2);

    getAlarmTime();

    function getAlarmTime() {

      

      if (!localStorage.getItem("namaz_name") || alarmTime <= `${h}:${m}`) {

        $.ajax({
          url: "sync-namaz-time.php", //the page containing php script
          type: "post", //request type,
          dataType: 'json',
          data: {
              get_namaz_time: "1",
              c_date: formattedDate
          },
        }).done(function(res) {

          let namazDetail = JSON.parse(res);

          if (namazDetail) {

            let namazName = namazDetail['namaz'].charAt(0).toUpperCase() + namazDetail['namaz'].slice(1)

            localStorage.setItem("namaz_name", namazName);

            $('#namaz_name').html(namazName);

            // Split the datetime string into date and time components
            let [datePart, timePart] = namazDetail['datetime'].split(' ');

            localStorage.setItem("namaz_time", timePart);

            setAlarm();

            $('#hour').html(hours);
            $('#minutes').html(minutes);

          }else{

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

          }

        });

      } else {

        $('#namaz_name').html(localStorage.getItem("namaz_name").charAt(0).toUpperCase() + localStorage.getItem("namaz_name").slice(1));

        setAlarm();
      }

    }

    if(alarmTime <= `${h}:${m}`){
      getAlarmTime();
    }

    function setAlarm() {

      // Split the time part into hours, minutes, and seconds
      [hours, minutes, seconds] = localStorage.getItem("namaz_time").split(':');

      alarmTime = `${hours}:${minutes}`;

      $('#hour').html(hours);
      $('#minutes').html(minutes);

    }

    function playAlarm() {

      if (alarmTime === `${h}:${m}`) {

        $("#AlarmModal").modal('show');

        ringtone.play();
        ringtone.loop = true;
      }
    }

    $('#alarm_off_btn').click(function () {

      location.reload();

    });

    setInterval(() => {
      let date = new Date();
      h = date.getHours();
      m = date.getMinutes();


      h = ('0' + h).slice(-2);
      m = ('0' + m).slice(-2);

      console.log(`${h}:${m}`);
      console.log(alarmTime);

      playAlarm();

    }, 60000);

  <?php } ?>


  });
</script>

</body>

</html>