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

          <div class="col-lg-12 text-center">
                <h3><?php echo $instruments['ins_name']; ?></h3>
                <p><?php echo $instruments['ins_description']; ?></p>
          </div>

          </div>

          <div class="col-lg-6">
            <div id='calendar'></div>
          </div>

          <div class="col-lg-6">
            <div id='external-events'>
              <p>
                <h2>Drag & Drop</h2>
              </p>
              <div class='fc-event' data-event='{"title": "จองใช้เครื่องมือวิจัย #<?php echo $instruments['ins_id']; ?>"}'><?php echo $instruments['ins_name']; ?></div>
            </div>
            <button type="button" id="rentConfirm" class="btn btn-primary">ยืนยัน</button>
          </div>

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

  var calendar = new Calendar(calendarEl, {
    plugins: [ 'interaction', 'dayGrid' ],
    timeZone: 'Asia/Bangkok',
    locale: 'th',
    editable: true,
    droppable: true,
    eventOverlap: false,
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
    eventClick: function(info) {
      console.log(info);
      /*var event = calendar.getEventById(info.event.id);
      event.remove();*/
    },
    eventSources: [
    // your event source
    {
      url: '<?php echo base_url(); ?>instruments/ins_fetch',
      method: 'POST',
      extraParams: {
        ins_id: <?php echo $instruments['ins_id']; ?>
      },
      failure: function() {
        alert('เกิดข้อผิดพลาดในขณะที่ดึงข้อมูล!');
      },
      color: 'tomato',   // a non-ajax option
      textColor: 'tomato' // a non-ajax option
    },
    ]
  });

  calendar.render();

  /*
  // ดึง event ทั้งหมด
  console.log(calendar.getEvents());
  */

  $("#rentConfirm").on("click", function (e) {
    console.log(calendar.getEvents());
  });
});
/*
function selectEvent(selectionInfo) {

  let currentDate = new Date();
  let startDate = document.getElementById('startDate');
  let endDate = document.getElementById('endDate');

  console.log(selectionInfo);

  if (new Date(selectionInfo.startStr) >= currentDate && new Date(selectionInfo.endStr) >= currentDate) {
    startDate.valueAsDate = new Date(selectionInfo.startStr);
    endDate.valueAsDate = new Date(selectionInfo.endStr);
  }
  else {
    Swal.fire({
      icon: 'error',
      title: 'ตรวจสอบข้อผิดพลาด',
      text: 'ระยะเวลาต้องเป็นวันที่ล่วงหน้าอย่างน้อย 1 วัน!'
    })
  }
}*/

    /*
    // แสดงวันที่ตาม format thai
    const event = new Date(currentDate.getTime() + 86400000);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    event.toLocaleDateString('th-TH', options)*/
</script>



