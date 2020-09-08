<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('users'); ?></h6>

    <div class="d-flex align-items-right">
      <a href="<?php echo base_url(); ?>users/create" class="btn btn-secondary ml-2"><i class="fas fa-plus-circle"></i> <?php echo $this->lang->line('add'); ?></a>
    </div>

  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('name'); ?></th>
            <th><?php echo $this->lang->line('organization'); ?></th>
            <th><?php echo $this->lang->line('created_at'); ?></th>
            <th><?php echo $this->lang->line('updated_at'); ?></th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th><?php echo $this->lang->line('name'); ?></th>
            <th><?php echo $this->lang->line('organization'); ?></th>
            <th><?php echo $this->lang->line('created_at'); ?></th>
            <th><?php echo $this->lang->line('updated_at'); ?></th>
          </tr>
        </tfoot>
        <tbody>
        <?php foreach($users as $user) : ?>
          <tr>
            <td><a class="nav-link" href="<?php echo base_url();?>users/view/<?php echo $user["member_id"];?>">
                <?php if (!empty($user["member_profile"])) : ?>
                <img style="height: 2rem;width: 2rem;" class="img-profile rounded-circle" src="<?php echo base_url() . "assets/uploads" . $user["member_profile"]; ?>" onerror="this.onerror=null; this.src='<?php echo base_url() ?>assets/images/NO_IMG_600x600.png'">
                <?php endif; ?>
                <?php echo (!empty($user["member_fullname"])) ? $user["member_fullname"]. " (". $user["member_name"] .")" : $user["member_name"];?>
              </a>
            </td>
            <td><?php echo (!empty($user["member_affiliation"])) ? $user["member_affiliation"] : "<i>ยังไม่มีข้อมูล</i>";?></td>
            <td><?php echo $user["created_at"];?></td>
            <td><?php echo (!empty($user["updated_at"])) ? $user["updated_at"] : "<i>ยังไม่มีการอัปเดตข้อมูล</i>";?></td>
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

  $('#usersTable').dataTable(dataTable_Lang);

});

</script>
