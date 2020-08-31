 <!-- Page Heading -->
 <h1 class="h3 mb-2 text-gray-800">จองใช้เครื่องมือวิจัย</h1>
<p class="mb-4">คุณสามารถเรียกดูรายละเอียดเครื่องมือที่ใช้ในงานวิจัยและจองใช้ได้ที่หน้านี้</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex flex-row justify-content-between">
  <div class="d-flex align-items-start">
    <h6 class="m-0 p-2 font-weight-bold text-primary d-flex align-items-start" style="border-right: 1px solid #e3e6f0;">รายชื่อเครื่องมือวิจัย</h6>
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
      <em>ขณะนี้มีเครื่องมือวิจัย <span class="badge p-2 my-1 badge-success"><?php echo $active; ?> พร้อมใช้งาน</span> <span class="badge p-2 my-1 badge-secondary"><?php echo $inactive; ?> ไม่พร้อมใช้งาน</span> และ <span class="badge p-2 my-1 badge-warning"><?php echo $maintenance; ?> อยู่ในระหว่างบำรุงรักษา</span></em>
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
            <th>ชื่อ</th>
            <th>สถานะ</th>
            <!--<th>ผู้ดูแล</th>-->
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>ชื่อ</th>
            <th>สถานะ</th>
            <!--<th>ผู้ดูแล</th>-->
          </tr>
        </tfoot>
        <tbody>
        <?php foreach($instruments as $instrument) : ?>

          <tr>
            <td><a href="<?php echo base_url();?>booking/instrument/<?php echo $instrument["ins_id"];?>"><?php echo $instrument["ins_name"];?></a>
            <?php if ($instrument["ins_maintenance"]) : ?>
                (อยู่ในระหว่างบำรุงรักษา)
            <?php endif; ?>
            </td>

            <td class="text-center" style="vertical-align: middle;">

            <div class="row justify-content-center my-auto">
            <?php if ($instrument["ins_maintenance"]) : ?>
              <h6 ><span class="badge p-2 m-1 badge-warning">อยู่ในระหว่างบำรุงรักษา</span></h6>
            <?php elseif ($instrument["ins_inactive"]):?>
              <h6 ><span class="badge p-2 m-1 badge-secondary">ไม่พร้อมใช้งาน</span></h6>
            <?php else:?>
            
              <h6><span class="badge p-2 m-1 badge-success">พร้อมใช้งาน</span></h6>
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
