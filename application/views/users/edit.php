<?php 

$user["token"] = substr($user["member_profile"], 15, 32);

if ($user["token"] != NULL) {
  $imageToken = $this->user_model->getImageToken($user["token"]);
  $profilePath = $imageToken["image_path"]."/".$imageToken["image_rawname"].$imageToken["image_ext"];
}
?>


<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">ข้อมูลสมาชิก</h1>

<?php echo form_open_multipart('users/update');?>

<input type="hidden" id="uploadUrl" name="uploadUrl" value="<?php echo base_url();?>users/uploadimage" />
<input type="hidden" id="token" name="token" value="<?php echo $this->util_model->getToken(32); ?>" />
<input type="hidden" id="id" name="id" value="<?php echo $user["member_id"]; ?>" />

<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">ข้อมูลสมาชิก</h6>
  </div>

  <div class="card-body">

    <?php if($this->session->flashdata('message')): ?>
      <div class="form-group">
      <div class="alert alert-danger"><?php echo $this->session->flashdata('message'); ?></div>
      </div>
      <?php endif; ?>   
      <?php if (validation_errors()) : ?>
        <div class="form-group">
      <ul class="list-group my-3">
        <?php echo validation_errors('<li class="list-group-item list-group-item-danger mb-1">', '</li>'); ?>
      </ul>
      </div>
    <?php endif; ?>
    
      <div class="form-group">
        <div class="form-group row">
            <div class="col-lg-3">
              <div class="form-group text-center">
                <?php if ($user["token"] == NULL) : ?>
                  <img id="uploadImage" class="mmn-dropzone img-fluid" src="<?php echo base_url();?>assets/images/NO_IMG_600x600.png" />
                <?php else: ?>
                  <img id="uploadImage" class="mmn-dropzone img-fluid" src="<?php echo base_url();?>assets/uploads<?php echo $profilePath; ?>" />
                <?php endif;?>
                <!-- Progress Bar -->
                <div class="progress bg-light mmn-progress">
                  <div class="progress-bar bg-success mmn-progress-bar" role="progressbar" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
              <input type="file" id="uploadImage" name="uploadImage" style="display: none;" />
            </div>
            <div class="col-lg">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right"><b>ชื่อผู้ใช้: <span class="text-danger">*</span></b></label>
                  <div class="col-sm-10">
                      <div class="form-group">
                          <input type="text" class="form-control form-control-sm" name="username" value="<?php echo $user["member_name"]; ?>">
                      </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right"><b>รหัสผ่าน: <span class="text-danger">*</span></b></label>
                  <div class="col-sm-10">
                      <div class="form-group">
                          <input type="password" class="form-control form-control-sm" name="password" value="">
                      </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right"><b>อีเมล: <span class="text-danger">*</span></b></label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" name="email" placeholder="ต.ย. name@mydomain.com" value="<?php echo $user["member_email"]; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right">ชื่อ-นามสกุล</label>
                  <div class="col-sm-10">
                      <div class="form-group">
                          <input type="text" class="form-control form-control-sm" name="fullname" value="<?php echo $user["member_fullname"]; ?>">
                      </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right">สังกัด (หน่วยงาน)</label>
                  <div class="col-sm-10">
                      <div class="form-group">
                          <input type="text" class="form-control form-control-sm" name="affiliation" value="<?php echo $user["member_affiliation"]; ?>">
                      </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right">เบอร์โทรศัพท์</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" name="phonenumb" value="<?php echo $user["member_phonenumb"]; ?>">
                  </div>
                </div>
            </div>
          </div>
        </div>
      
        <div class="form-group">

              <div class="form-group row" style="border-bottom: 1px dotted #777;">
                  <h4>สถานะและตั้งค่า</h4>
              </div>
              <?php if ($this->auth_model->hasFlags($this->auth_model->getMemberRoleByID($this->session->userdata('member_id')), USER_ROLES['ADMIN'])) : ?>
              <div class="form-group row">
                <div class="col-sm-2">บทบาท</div>
                <div class="col-sm-10">
                  <div class="form-check disabled">
                    <input class="form-check-input" type="checkbox" checked disabled>
                    <label class="form-check-label">
                      ผู้ใช้
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="roles_mod" name="roles_mod" <?php echo ($user["member_role"] & USER_ROLES['MOD']) ? ("checked") : (""); ?>>
                    <label class="form-check-label" for="roles_mod">
                      ผู้ดูแลเครื่องมือ
                    </label>
                  </div>
  
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="roles_staff" name="roles_staff" <?php echo ($user["member_role"] & USER_ROLES['STAFF']) ? ("checked") : (""); ?>>
                    <label class="form-check-label" for="roles_staff">
                      เจ้าหน้าที่
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="roles_admin" name="roles_admin" <?php echo ($user["member_role"] & USER_ROLES['ADMIN']) ? ("checked") : (""); ?>>
                    <label class="form-check-label" for="roles_admin">
                      ผู้ดูแลระบบ
                    </label>
                  </div>

                </div>
              </div>
              <?php endif;?>
        </div>

        <div class="form-group">
          
          <div class="form-group row">
            <div class="col-sm-2">การตั้งค่า</div>
            <div class="col-sm-10">
            <?php if ($this->auth_model->hasFlags($this->auth_model->getMemberRoleByID($this->session->userdata('member_id')), USER_ROLES['ADMIN'])) : ?>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="user_active" name="user_active" <?php echo ($user["member_active"]) ? ("checked") : (""); ?>>
                <label class="form-check-label" for="user_active">
                  เปิดใช้งาน
                </label>
              </div>
            <?php endif; ?>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="user_changepass" name="user_changepass" <?php echo ($user["member_changepass"]) ? ("checked") : (""); ?>>
                <label class="form-check-label" for="user_changepass">
                  เปลี่ยนรหัสผ่านหลังเข้าสู่ระบบ
                </label>
              </div>
            </div>
          </div>
          
      </div>
  </div>
</div>

<div class="form-group row">
    <div class="col-lg-12">
        <div class="text-center"><button type="submit" class="btn btn-outline-secondary mb-2 mr-sm-2">บันทึก</button> <button type="reset" class="btn btn-outline-secondary mb-2 mr-sm-2">รีเซ็ต</button> <button class="btn btn-outline-secondary mb-2 mr-sm-2">ยกเลิก</button></div>
    </div>
</div>

</form>