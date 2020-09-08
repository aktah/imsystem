<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('booking_history'); ?></h6>
    </div>
    <div class="card-body">

        <div class="form-group row">
            <div class="col-lg-6"> 
                <div id='calendar'></div>
            </div>


            <div class="col-lg-6 mt-5">
            <h4><?php echo $this->lang->line('information'); ?></h4>
            <ul class="list-group">
                <li class="list-group-item"><div style="padding:5px;margin:5px;background-color:#6c757d;display:inline;"></div> <?php echo $this->lang->line('event_info_pending'); ?></li>
                <li class="list-group-item"><div style="padding:5px;margin:5px;background-color:#17a2b8;display:inline;"></div> <?php echo $this->lang->line('event_info_available'); ?></li>
                <li class="list-group-item"><div style="padding:5px;margin:5px;background-color:#dc3545;display:inline;"></div> <?php echo $this->lang->line('event_info_rejected'); ?></li>
            </ul>
            </div>
        </div>

        <div class="form-group row">
            <div class="table-responsive mt-5">
                <table class="table table-bordered" id="instrumentsTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('instrument'); ?></th>
                        <th><?php echo $this->lang->line('daterange_start') ?></th>
                        <th><?php echo $this->lang->line('daterange_end') ?></th>
                        <th><?php echo $this->lang->line('status'); ?></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('instrument'); ?></th>
                        <th><?php echo $this->lang->line('daterange_start') ?></th>
                        <th><?php echo $this->lang->line('daterange_end') ?></th>
                        <th><?php echo $this->lang->line('status'); ?></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach($rent as $r) : ?>
                        <tr>
                            <td><?php echo $r["id"]; ?></td>
                            <td><?php echo $r["ins_name"]; ?></td>
                            <td><?php echo $r["startDate"]; ?></td>
                            <td><?php echo $r["endDate"]; ?></td>
                            <?php 
                                switch($r["status"]) {
                                    case 1:
                                    $badge = "badge-info";
                                    $badgeText = "พร้อมใช้งาน";
                                    break;
                                    case 2:
                                    $badge = "badge-danger";
                                    $badgeText = "ถูกปฏิเสธ";
                                    break;
                                    default:
                                    $badge = "badge-secondary";
                                    $badgeText = "รอการยืนยัน";
                                }
                            ?>
                            <td><span class="badge <?php echo $badge; ?>"><?php echo $badgeText ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('job'); ?></h6>
    </div>
    <div class="card-body">

    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function() {

  var Calendar = FullCalendar.Calendar;
  var Draggable = FullCalendarInteraction.Draggable;
  var calendarEl = document.getElementById('calendar');

  // initialize the calendar
  // -----------------------------------------------------------------
  const lang = "<?php echo $this->session->userdata('site_lang'); ?>";

  var calendar = new Calendar(calendarEl, {
    plugins: [ 'interaction', 'dayGrid' ],
    timeZone: 'Asia/Bangkok',
    locale: lang == 'thai' ? 'th' : 'en',
    editable: false,
    droppable: false,
    eventOverlap: false,
    allDayDefault: false,

    eventClick: function(info) {

    },
    eventSources: [
    {
      url: '<?php echo base_url(); ?>instruments/ins_fetch_approve',
      method: 'POST',
      extraParams: {
        member_id: <?php echo $user["member_id"]; ?>,
        status: 0
      },
      failure: function() {
        alert('Error!');
      },
      color: '#6c757d',
    },
    {
      url: '<?php echo base_url(); ?>instruments/ins_fetch_approve',
      method: 'POST',
      extraParams: {
        member_id: <?php echo $user["member_id"]; ?>,
        status: 1
      },
      failure: function() {
        alert('Error!');
      },
      color: '#17a2b8',
    },
    {
      url: '<?php echo base_url(); ?>instruments/ins_fetch_approve',
      method: 'POST',
      extraParams: {
        member_id: <?php echo $user["member_id"]; ?>,
        status: 2
      },
      failure: function() {
        alert('Error!');
      },
      color: '#dc3545',
    }
    ]
  });

  calendar.render();
});

</script>

<script>

document.addEventListener('DOMContentLoaded', function() {

  let lang = "<?php echo $this->session->userdata('site_lang'); ?>";
  const dataTable_Lang = lang == 'thai' ? {
    "language": {
        "sEmptyTable":     "ไม่มีข้อมูลในตาราง",
        "sInfo":           "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
        "sInfoEmpty":      "แสดง 0 ถึง 0 จาก 0 แถว",
        "sInfoFiltered":   "(กรองข้อมูล _MAX_ ทุกแถว)",
        "sInfoPostFix":    "",
        "sInfoThousands":  ",",
        "sLengthMenu":     "แสดง _MENU_ แถว",
        "sLoadingRecords": "กำลังโหลดข้อมูล...",
        "sProcessing":     "กำลังดำเนินการ...",
        "sSearch":         "ค้นหา: ",
        "sZeroRecords":    "ไม่พบข้อมูล",
        "oPaginate": {
        "sFirst":    "หน้าแรก",
        "sPrevious": "ก่อนหน้า",
        "sNext":     "ถัดไป",
        "sLast":     "หน้าสุดท้าย"
        },
        "oAria": {
          "sSortAscending":  ": เปิดใช้งานการเรียงข้อมูลจากน้อยไปมาก",
          "sSortDescending": ": เปิดใช้งานการเรียงข้อมูลจากมากไปน้อย"
        }
    }
  } : {};

  $('#instrumentsTable').dataTable(dataTable_Lang);
  
});

</script>