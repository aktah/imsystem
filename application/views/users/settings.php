<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('settings'); ?></h6>
    </div>

    <?php echo form_open_multipart('users/settingsupdate');?>

    <input type="hidden" id="id" name="id" value="<?php echo $user["member_id"]; ?>" />

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
        
        <div class="form-group">
            <div class="form-group row">
                <div class="col-lg">

                    <div class="form-group row">
                    <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('username'); ?>:</b></label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm" value="<?php echo $user["member_name"]; ?>" disabled>
                        </div>
                    </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('oldpassword'); ?>: </b></label>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-sm" name="oldpassword" value="">
                                </div>
                            </div>
                        </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('password'); ?>: </b></label>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-sm" name="password" value="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('confirmpassword'); ?>: </b></label>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-sm" name="confpassword" value="">
                                </div>
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-md-right"></label>
                        <div class="col-sm-10">
                            <button type="submit" name="settings" class="btn btn-outline-secondary mb-2 mr-sm-2"><?php echo $this->lang->line('change_password'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    
</form>