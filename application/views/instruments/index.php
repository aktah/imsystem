 <!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">จัดการเครื่องมือ</h1>
<p class="mb-4">คุณสามารถเรียกดูเครื่องมือที่ใช้ในงานวิจัยและจัดการได้ที่หน้านี้</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">รายชื่อเครื่องมือวิจัย</h6>

    <div class="d-flex align-items-right">

      <a href="<?php echo base_url(); ?>instruments/create" class="btn btn-secondary ml-2"><i class="fas fa-plus-circle"></i> เพิ่มเครื่องมือ</a>

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
            <th>#</th>
            <th>ชื่อ</th>
            <th>ผู้ดูแล</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>#</th>
            <th>ชื่อ</th>
            <th>ผู้ดูแล</th>
          </tr>
        </tfoot>
        <tbody>
        <?php foreach($instruments as $instrument) : ?>
          <tr>
            <td><?php echo $instrument["ins_id"];?></td>
            <td><i class="fas fa-eye<?php echo $instrument["ins_unactive"] ? '-slash' : '';?> text-xs"></i> <a href="<?php echo base_url();?>instruments/view/<?php echo $instrument["ins_id"];?>"><?php echo $instrument["ins_name"];?></a>
            
            <?php if ($instrument["ins_status"]) : ?>
                (อยู่ในระหว่างบำรุงรักษา)
            <?php endif; ?>
            
            </td>
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
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
