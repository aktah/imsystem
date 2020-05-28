 <!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">จัดการเครื่องมือ</h1>
<p class="mb-4">คุณสามารถเรียกดูเครื่องมือที่ใช้ในงานวิจัยและจัดการได้ที่หน้านี้</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">รายชื่อเครื่องมือวิจัย</h6>

    <div class="d-flex align-items-right">

      <a href="<?php echo base_url(); ?>instruments/create" class="btn btn-secondary ml-2"><i class="fas fa-plus-circle"></i> เพิ่มเครื่องมือ</a>

      <div class="dropdown ml-2">
        <a class="dropdown-toggle btn btn-secondary" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">เพิ่มเติม</a>
        <div class="dropdown-hover dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
          <a class="dropdown-item" href="#"><i class="fas fa-toggle-on text-xs"></i> เปิดใช้งาน</a>
          <a class="dropdown-item item-danger" href="#"><i class="fas fa-toggle-off mr-2 text-xs"></i> ปิดใช้งาน</a>
        </div>
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
            <th></th>
            <th>ชื่อ</th>
            <th>ผู้รับผิดชอบ</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th></th>
            <th>ชื่อ</th>
            <th>ผู้รับผิดชอบ</th>
          </tr>
        </tfoot>
        <tbody>
        <?php foreach($instruments as $instrument) : ?>
          <tr>
            <td><div class="form-check text-center"><input class="form-check-input" type="checkbox"></div></td>
            <td><i class="fas fa-eye<?php echo $instrument["ins_unactive"] ? '-slash' : '';?> text-xs"></i> <a href="<?php echo base_url();?>instruments/view/<?php echo $instrument["ins_id"];?>"><?php echo $instrument["ins_name"];?></a>
            
            <?php if ($instrument["ins_status"]) : ?>
                (อยู่ในระหว่างบำรุงรักษา)
            <?php endif; ?>
            
            </td>
            <?php 
                  $attData = $this->instrument_model->getAttendantData($instrument["ins_id"]); 
                  
                  if($attData != NULL) : 
            ?>
            <td><a href="<?php echo base_url();?>users/view/<?php echo $attData["member_id"];?>"><?php echo $attData["member_fullname"];?></a></td>
              <?php else: ?>
            <td><i>ไม่มี</i></td>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
