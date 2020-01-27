<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">จัดการผู้ใช้</h1>
<p class="mb-4">คุณสามารถเรียกดูรายละเอียดผู้ใช้และจัดการได้ที่หน้านี้</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">รายชื่อผู้ใช้งานระบบ</h6>

    <div class="d-flex align-items-right">

      <a href="#" class="btn btn-secondary ml-2"><i class="fas fa-plus-circle"></i> เพิ่มผู้ใช้</a>

      <div class="dropdown ml-2">
        <a class="dropdown-toggle btn btn-secondary" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">เพิ่มเติม</a>
        <div class="dropdown-hover dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
          <a class="dropdown-item" href="#"><i class="fas fa-lock mr-2 text-xs"></i> ล็อก</a>
          <a class="dropdown-item" href="#"><i class="fas fa-unlock mr-2 text-xs"></i> ปลดล็อก</a>
          <a class="dropdown-item item-danger" href="#"><i class="fas fa-trash mr-2 text-xs"></i> ลบ</a>
        </div>
      </div>

    </div>

  </div>
  <div class="card-body">
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
        <?php foreach($users as $user) : ?>
          <tr>
            <td><div class="form-check text-center"><input class="form-check-input" type="checkbox"></div></td>
            <td><a href="<?php echo base_url();?>users/view/<?php echo $user["member_id"];?>"><?php echo (!empty($user["member_fullname"])) ? $user["member_fullname"]. " (". $user["member_name"] .")" : $user["member_name"];?></a></td>
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
