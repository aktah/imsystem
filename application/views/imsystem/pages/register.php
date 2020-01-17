

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row d-flex justify-content-center">
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">สร้างบัญชีผู้ใช้</h1>
              </div>
              <?php if($this->session->flashdata('message')): ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('message'); ?></div>
              <?php endif; ?>   
              <?php if (validation_errors()) : ?>
              <ul class="list-group my-3">
                <?php echo validation_errors('<li class="list-group-item list-group-item-danger">', '</li>'); ?>
              </ul>
              <?php endif; ?>
              <?php echo form_open('imsystem/frmRegister'); ?>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" name="username" placeholder="ชื่อผู้ใช้">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-user" name="email" placeholder="ที่อยู่อีเมล">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" name="password" placeholder="รหัสผ่าน">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" name="repassword" placeholder="ยืนยันรหัสผ่าน">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                  ลงทะเบียน
                </button>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="forgot-password.html">ลืมรหัสผ่าน?</a>
              </div>
              <div class="text-center">
                <a class="small" href="<?php echo base_url(); ?>imsystem/login">มีบัญชีผู้ใช้อยู่แล้ว? เข้าสู่ระบบ!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


