<div class="card shadow mb-4">
  <div class="card-body">
    <div class="row">
    <div class="col-lg-6">
      <div class="table-responsive">
        <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th></th>
              <th>ชื่อ</th>
              <th>คณะ/หน่วยงาน</th>
              <th>ลงทะเบียนเมื่อ</th>
              <th>อัปเดตล่าสุด</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th></th>
              <th>ชื่อ</th>
              <th>คณะ/หน่วยงาน</th>
              <th>ลงทะเบียนเมื่อ</th>
              <th>อัปเดตล่าสุด</th>
            </tr>
          </tfoot>
          <tbody>
          <?php foreach($instruments as $instrument) : ?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div id='external-events'>
      <p>
        <strong>Draggable Events</strong>
      </p>
      <div class='fc-event' data-event='{"title": "เครื่องมือวิจัย #1451"}'>เครื่องมือวิจัย #1451</div>
    </div>
    </div>
    <div class="col-lg-6">
      <div id='calendar'></div>
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
    plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
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

      info.draggedEl.parentNode.removeChild(info.draggedEl);
    },
    eventClick: function(info) {
      console.log(info);
      /*var event = calendar.getEventById(info.event.id);
      event.remove();*/
    }
  });

  calendar.render();

  /*
  // ดึง event ทั้งหมด
  console.log(calendar.getEvents());
  */

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


