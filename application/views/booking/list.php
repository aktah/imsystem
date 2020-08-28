 <!-- Page Heading -->
 <h1 class="h3 mb-2 text-gray-800">จองใช้เครื่องมือวิจัย</h1>
<p class="mb-4">คุณสามารถเรียกดูรายละเอียดเครื่องมือที่ใช้ในงานวิจัยและจองใช้ได้ที่หน้านี้</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">รายชื่อเครื่องมือวิจัย</h6>
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
            <th>ชื่อ</th>
            <th>ผู้ดูแล</th>
            <th></th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>ชื่อ</th>
            <th>ผู้ดูแล</th>
            <th></th>
          </tr>
        </tfoot>
        <tbody>
        <?php foreach($instruments as $instrument) : ?>

          <?php if ($instrument["ins_unactive"]) continue; ?>

          <tr>
            <td><a href="<?php echo base_url();?>booking/instrument/<?php echo $instrument["ins_id"];?>"><?php echo $instrument["ins_name"];?></a>
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

            <td class="text-center">
                  <a href="<?php echo base_url();?>booking/instrument/<?php echo $instrument["ins_id"];?>" class="btn btn-primary <?php echo $instrument["ins_status"] ? 'btn-secondary' : ''?>">จองใช้บริการ</a>
            </td>

          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
