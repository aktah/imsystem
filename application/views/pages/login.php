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
                <div class="alert alert-<?php echo $this->session->flashdata('type'); ?>"><?php echo $this->session->flashdata('message'); ?></div>
              <?php endif; ?>  
              <?php if (validation_errors()) : ?>
              <ul class="list-group my-3">
                <?php echo validation_errors('<li class="list-group-item list-group-item-danger">', '</li>'); ?>
              </ul>
              <?php endif; ?>
              <?php echo form_open('imsystem/frmLogin'); ?>
                  <div class="form-group">
                    <input 
                      type="text" 
                      class="form-control form-control-user" 
                      name="username" 
                      value="<?php if(get_cookie('member_login') != NULL) { echo get_cookie('member_login'); } ?>"
                      placeholder="ชื่อผู้ใช้">
                  </div>
                  <div class="form-group">
                    <input 
                      type="password" 
                      class="form-control form-control-user" 
                      name="password" 
                      <?php if(get_cookie('member_password') != NULL) { echo get_cookie('member_password'); } ?>
                      placeholder="รหัสผ่าน">
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                    <input type="checkbox" class="custom-control-input" id="remember-me" name="remember"
                      <?php if(get_cookie('member_login') != NULL) { ?> checked
                      <?php } ?> /> <label class="custom-control-label" for="remember-me">จดจำฉัน</label>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    เข้าสู่ระบบ
                  </button>
                </form>
              <hr>
              <div class="text-center">
                <a class="small" href="forgot-password.html">ลืมรหัสผ่าน?</a>
              </div>
              <div class="text-center">
                <a class="small" href="<?php echo base_url(); ?>imsystem/register">สร้างบัญชีผู้ใช้!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


