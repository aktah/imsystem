<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex flex-row justify-content-between">
  <div class="d-flex align-items-start">
    <h6 class="m-0 p-2 font-weight-bold text-primary d-flex align-items-start" style="border-right: 1px solid #e3e6f0;"><?php echo $this->lang->line('instrument'); ?></h6>
    <div class="ml-2 d-flex d-flex align-items-start">
    <?php 
    $inactive = 0;
    $active = 0;
    $maintenance = 0;

    foreach($instruments as $instrument) {
      if ($instrument["ins_maintenance"]) {
        $maintenance++;
        continue;
      }
      if ($instrument["ins_inactive"]) {
        $inactive++;
        continue;
      }
      $active++;
    }

    ?>
      <em><?php echo $this->lang->line('label_instrument'); ?> <span class="badge p-2 my-1 badge-success"><?php echo $active; ?> <?php echo $this->lang->line('instrument_active'); ?></span> <?php echo $this->lang->line('and'); ?> <span class="badge p-2 my-1 badge-secondary"><?php echo $inactive; ?> <?php echo $this->lang->line('instrument_inactive'); ?></span> <?php echo $this->lang->line('and'); ?> <span class="badge p-2 my-1 badge-warning"><?php echo $maintenance; ?> <?php echo $this->lang->line('instrument_maintenance'); ?></span></em>
    </div>
    </div>

  </div>
  <div class="card-body">

    <?php if($this->session->flashdata('message')): ?>
      <div class="form-group">
      <div class="alert alert-<?php echo $this->session->flashdata('type'); ?>"><?php echo $this->session->flashdata('message'); ?></div>
      </div>
      <?php endif; ?>   
      <?php if (validation_errors()) : ?>
        <div class="form-group">
      <ul class="list-group my-3">
        <?php echo validation_errors('<li class="list-group-item list-group-item-danger mb-1">', '</li>'); ?>
      </ul>
      </div>
    <?php endif; ?>

    <div class="table-responsive">
      <table class="table table-bordered" id="instrumentsTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('name'); ?></th>
            <th><?php echo $this->lang->line('abbreviation'); ?></th>
            <th><?php echo $this->lang->line('model'); ?></th>
            <th><?php echo $this->lang->line('status'); ?></th>
            <!--<th>ผู้ดูแล</th>-->
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th><?php echo $this->lang->line('name'); ?></th>
            <th><?php echo $this->lang->line('abbreviation'); ?></th>
            <th><?php echo $this->lang->line('model'); ?></th>
            <th><?php echo $this->lang->line('status'); ?></th>
            <!--<th>ผู้ดูแล</th>-->
          </tr>
        </tfoot>
        <tbody>
        <?php foreach($instruments as $instrument) : ?>

          <tr>
            <td><a href="<?php echo base_url();?>booking/instrument/<?php echo $instrument["ins_id"];?>"><?php echo $instrument["ins_name_en"];?></a></td>
            <td><?php echo $instrument["ins_abbre"];?></td>
            <td><?php echo $instrument["ins_model"];?></td>

            <td class="text-center" style="vertical-align: middle;">

            <div class="row justify-content-center my-auto">
            <?php if ($instrument["ins_maintenance"]) : ?>
              <h6 ><span class="badge p-2 m-1 badge-warning"><?php echo $this->lang->line('instrument_maintenance'); ?></span></h6>
            <?php elseif ($instrument["ins_inactive"]):?>
              <h6 ><span class="badge p-2 m-1 badge-secondary"><?php echo $this->lang->line('instrument_inactive'); ?></span></h6>
            <?php else:?>
            
              <h6><span class="badge p-2 m-1 badge-success"><?php echo $this->lang->line('instrument_active'); ?></span></h6>
            <?php endif; ?>
            </div>

            </td>

<!--
            <?php $attData = $this->instrument_model->getAttendant($instrument["ins_id"]); ?>
            <?php if($attData) : ?>
              <td>
              <?php foreach($attData as $att) : ?>
                <?php echo $att["member_fullname"];?><br>
              <?php endforeach; ?>
              </td>
            <?php else: ?>
            <td><i>ไม่มี</i></td>
            <?php endif; ?>
-->
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


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