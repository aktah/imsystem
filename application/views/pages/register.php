

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-title">
      <div class="float-right">
        <a class="nav-link" href="<?php echo $this->session->userdata('site_lang') && $this->session->userdata('site_lang') != 'thai' ? base_url("imsystem/switchLang/thai") : base_url("imsystem/switchLang/english"); ?>"><i class="fas fa-globe fa-fw"></i>EN/TH</a>
      </div>
      </div>
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row d-flex justify-content-center">
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4"><?php echo $this->lang->line('create_account'); ?></h1>
              </div>
              <?php if($this->session->flashdata('message')): ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('message'); ?></div>
              <?php endif; ?>   
              <?php if (validation_errors()) : ?>
              <ul class="list-group my-3">
                <?php echo validation_errors('<li class="list-group-item list-group-item-danger mb-1">', '</li>'); ?>
              </ul>
              <?php endif; ?>
              <?php echo form_open('imsystem/frmRegister'); ?>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" name="username" placeholder="<?php echo $this->lang->line('username'); ?>">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-user" name="email" placeholder="<?php echo $this->lang->line('email_address'); ?>">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" name="password" placeholder="<?php echo $this->lang->line('password'); ?>">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" name="repassword" placeholder="<?php echo $this->lang->line('confirmpassword'); ?>">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                <?php echo $this->lang->line('register'); ?>
                </button>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="forgot-password.html"><?php echo $this->lang->line('forgot_password'); ?>?</a>
              </div>
              <div class="text-center">
                <a class="small" href="<?php echo base_url(); ?>imsystem/login"><?php echo $this->lang->line('already_have_account'); ?>!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


