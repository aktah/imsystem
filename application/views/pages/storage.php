<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('warehouse'); ?></h6>

        <div class="d-flex align-items-right justify-content-end">
            <a href="<?php echo base_url(); ?>storage/create" class="btn btn-primary ml-2"><i class="fas fa-plus-circle"></i> <?php echo $this->lang->line('add'); ?></a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="instrumentsTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('name'); ?></th>
                <th><?php echo $this->lang->line('instrument'); ?></th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('name'); ?></th>
                <th><?php echo $this->lang->line('instrument'); ?></th>
            </tr>
            </tfoot>
            <tbody>
            <?php foreach($storages as $storage) : ?>
            <tr>
            <td><?php echo $storage['storage_id']; ?></td>
            <td><a href="<?php echo base_url(); ?>storage/<?php echo $storage['storage_id']; ?>"><?php echo $storage['storage_name']; ?></a></td>
            <td><?php echo $storage['instrument_count']; ?></td>
            </tr>
            <?php endforeach;?>

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