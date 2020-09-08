<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary"><?php echo $instruments['ins_name']; ?></h6>
    </div>
    <div class="card-body">
      <div class="row justify-content-center">
          <div class="col-md-8">
          <?php
                $count = 0; 
                foreach($images as $image) : ?>
                <?php if ($count % 3 == 0) : ?>
                  <div class="row my-4 justify-content-center text-center">
                <?php endif; ?>
                <a href="<?php echo base_url(); ?>assets/uploads<?php echo $image["image_path"]; ?>/<?php echo $image['image_rawname'].$image['image_ext']; ?>" data-toggle="lightbox" data-gallery="instrument-gallery" class="col-sm-4">
                    <img src="<?php echo base_url(); ?>assets/uploads<?php echo $image["image_path"]; ?>/<?php echo $image['image_rawname'].$image['image_ext']; ?>" class="img-fluid" style="height: 250px;">
                </a>
            <?php 
            
                $count++;

                if ($count % 3 == 0) {
                  ?>
                    </div>
                  <?php
                }
                
                endforeach; 
            ?>

          </div>


          <div class="form-group">
            <div class="form-group row">
                <div class="col-lg">
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('device_code'); ?></b></label>
                      <div class="col-sm-10 col-form-label">
                              <?php echo $instruments["ins_device"]; ?>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('name'); ?> (TH)</b></label>
                      <div class="col-sm-10 col-form-label">
                            <?php echo $instruments["ins_name"]; ?>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('name'); ?> (EN)</b></label>
                      <div class="col-sm-10 col-form-label">
                              <?php echo $instruments["ins_name_en"]; ?>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('abbreviation'); ?></b></label>
                      <div class="col-sm-10 col-form-label">
                          <?php echo $instruments["ins_abbre"]; ?>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('model'); ?></b></label>
                      <div class="col-sm-10 col-form-label">
                          <?php echo $instruments["ins_model"]; ?>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('description'); ?></b></label>
                      <div class="col-sm-10 col-form-label">
                        <?php echo $instruments["ins_description"]; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?php if($instruments['ins_maintenance'] == 0 && $instruments['ins_inactive'] == 0) : ?>

          <div class="col-lg-6 ">
            <div id='calendar'></div>
          </div>

          <div class="col-lg-6">
            <div class="form-group col-lg-12 my-5">
              <div class="text-center" id='external-events'>
                <p>
                  <h2><?php echo $this->lang->line('drag_and_drop'); ?></h2>
                </p>
                <p class="text-left"><?php echo $this->lang->line('events'); ?></p>
                <div class='text-left fc-event' data-event='{"title": "<?php echo $instruments['ins_name']; ?> #<?php echo $instruments['ins_id']; ?>"}'><?php echo $instruments['ins_name']; ?></div>
              </div>
              <small class="text-info"><?php echo $this->lang->line('event_book_info'); ?></small>
            </div>
            <div class="form-group col-lg-12 my-5">
              <h4><?php echo $this->lang->line('information'); ?></h4>
              <ul class="list-group">
                <li class="list-group-item"><div style="padding:5px;margin:5px;background-color:lightgray;display:inline;"></div> <?php echo $this->lang->line('event_book_failed'); ?></li>
                <li class="list-group-item"><div style="padding:5px;margin:5px;background-color:#3788d8;display:inline;"></div> <?php echo $this->lang->line('event_book_available'); ?></li>
                <li class="list-group-item"><div style="padding:5px;margin:5px;background-color:indianred;display:inline;"></div> <?php echo $this->lang->line('event_book_error'); ?></li>
                <li class="list-group-item"><div style="padding:5px;margin:5px;background-color:goldenrod;display:inline;"></div> <?php echo $this->lang->line('event_book_edit'); ?></li>
              </ul>
            </div>
          </div>
          
          <div class="my-3 justify-content-center">
            <button type="button" id="rentConfirm" class="btn btn-primary">จองใช้เครื่องมือ</button>
          </div>

          <?php endif; ?>
      </div>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function() {

  var Calendar = FullCalendar.Calendar;
  var Draggable = FullCalendarInteraction.Draggable;

  var containerEl = document.getElementById('external-events');
  var calendarEl = document.getElementById('calendar');
  var checkbox = document.getElementById('drop-remove');

  var eventId = 0;

  var data = [];
  // initialize the external events
  // -----------------------------------------------------------------

  new Draggable(containerEl, {
    itemSelector: '.fc-event',
    eventData: function(eventEl) {
      return {
        id: eventId++,
        title: $( eventEl ).data('event').title
      };
    }
  });

  // initialize the calendar
  // -----------------------------------------------------------------
  const lang = "<?php echo $this->session->userdata('site_lang'); ?>";

  var calendar = new Calendar(calendarEl, {
    plugins: [ 'interaction', 'dayGrid' ],
    timeZone: 'Asia/Bangkok',
    locale: lang == 'thai' ? 'th' : 'en',
    editable: true,
    droppable: true,
    eventOverlap: false,
    allDayDefault: false,
    events: data,
      /*{ // this object will be "parsed" into an Event Object
        title: 'The Title', // a property!
        start: '2020-01-01', // a property!
        end: '2020-01-28' // a property! ** see important note below about 'end' **
      }*/
    eventAllow: function(dropInfo, draggedEvent) {
      if (dropInfo.start >= new Date()) {
        return true;
      }
      else {
        return false;
      }
    },
    drop: function(info) {
      console.log(info);

      // info.draggedEl.parentNode.removeChild(info.draggedEl);
    },
    eventResize: function(info) {
      calendar.refetchEvents();
      let targetEvent = calendar.getEventById(info.event.id);
      if (targetEvent.extendedProps.overlap) {
        targetEvent.setProp("title", "<?php echo $instruments['ins_name']; ?> #<?php echo $instruments['ins_id']; ?>");
        targetEvent.setProp("backgroundColor", "goldenrod");
        targetEvent.setProp("borderColor", "goldenrod");
      }
    },
    eventDrop: function(info) {
      calendar.refetchEvents();
      let targetEvent = calendar.getEventById(info.event.id);
      if (targetEvent.extendedProps.overlap) {
        targetEvent.setProp("title", "<?php echo $instruments['ins_name']; ?> #<?php echo $instruments['ins_id']; ?>");
        targetEvent.setProp("backgroundColor", "goldenrod");
        targetEvent.setProp("borderColor", "goldenrod");
      }
    },
    eventClick: function(info) {
      if (info.event.id == -1)
        return;
      var event = calendar.getEventById(info.event.id);
      event.remove();
    },
    eventSources: [
    //
    {
      url: '<?php echo base_url(); ?>instruments/ins_fetch',
      method: 'POST',
      extraParams: {
        ins_id: <?php echo $instruments['ins_id']; ?>
      },
      failure: function() {
        alert('Error!');
      },
      color: 'lightgray',   // a non-ajax option
    },
    ]
  });

  calendar.render();

  /*
  // ดึง event ทั้งหมด
  console.log(calendar.getEvents());
  */

  $("#rentConfirm").on("click", function (e) {
    // console.log(calendar.getEvents());
    //for(let i = 0; i != calendar.getEvents().length; i++) {
    //  if (calendar.getEvents()[i].id != -1) {
    //    console.log(calendar.getEvents()[i].start, calendar.getEvents()[i].end);
    //  }
    //}

    /* 
    
      var d = new Date(targetEvent.end);
      d.setDate(d.getDate() - 1);
      d = new Date(d.setHours(23, 59, 59));
      targetEvent.setDates(targetEvent.start, d, true);
    */
    let data = calendar.getEvents().filter(c => {
      return c.id != -1;
    }).map(c => {

      var d = new Date(c.end);
      d.setDate(d.getDate() - 1);
      d = new Date(d.setHours(23, 59, 59));
      c.setDates(c.start, d, true);

      return { start: c.start.toISOString(), end: c.end != null ? c.end.toISOString() : c.start.toISOString(), id: c.id };
    });

    var monthNamesThai = ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤษจิกายน","ธันวาคม"];
    var dayNames = ["วันอาทิตย์ที่","วันจันทร์ที่","วันอังคารที่","วันพุทธที่","วันพฤหัสบดีที่","วันศุกร์ที่","วันเสาร์ที่"];
    var monthNamesEng = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var dayNamesEng = ['Sunday','Monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

    let msg = "";

    data.forEach((e) => {

      let start = new Date(e.start);

      if (e.start != e.end) {
        let end = new Date(e.end);
        msg += dayNames[start.getDay()]+" "+start.getDate()+" "+monthNamesThai[start.getMonth()]+" "+ start.getFullYear()+" - "+ dayNames[end.getDay()]+" "+ end.getDate()+" "+monthNamesThai[end.getMonth()]+" "+ end.getFullYear() + "\n";
      }
      else {
        msg += dayNames[start.getDay()]+" "+start.getDate()+" "+monthNamesThai[start.getMonth()]+" "+ start.getFullYear() + "\n";
      }
    });

    if (data.length == 0)
      return;

    if (!confirm("คุณแน่ใจแล้วใช่ไหมที่จะจองใช้เครื่องมือวิจัยนี้ ?\n\nรายละเอียด:\n" + msg))
      return;

    // แสดงเฉพาะวันจอง (ไม่นับรวม Events ที่ถูกจองแล้ว)
    // DEBUG
    /*data.forEach((d) => {
      console.log("เริ่ม", d.start, "จบ", d.end);
    });*/

    $.ajax({
      url: '<?php echo base_url(); ?>instruments/ins_insert', 
      method: 'POST',
      data: 
      'data=' + JSON.stringify(data) + '&' +
      'ins_id=' + <?php echo $instruments['ins_id']; ?>,
      success: function(result) {

        let msg = JSON.parse(result);

        if (!msg.success) {
          let eventData = msg.data;
          eventData.forEach(e => {
            let targetEvent = calendar.getEventById(e.id);
            targetEvent.setProp("backgroundColor", "indianred");
            targetEvent.setProp("borderColor", "indianred");
            targetEvent.setProp("title", e.status);
            targetEvent.setExtendedProp("overlap", true);
            calendar.refetchEvents();
          });
        } else {
          window.location.replace("<?php echo base_url(); ?>");
        }
      }
    });

  });
});

</script>



