<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">โปรไฟล์</h1>

<?php 
$user["token"] = substr($user["member_profile"], 15, 32);

if ($user["token"] != NULL) {
  $imageToken = $this->user_model->getImageToken($user["token"]);
  $profilePath = $imageToken["image_path"]."/".$imageToken["image_rawname"].$imageToken["image_ext"];
}
?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">ข้อมูลส่วนตัว</h6>
    </div>

    <?php echo form_open_multipart('imsystem/updateProfile');?>

    <input type="hidden" id="uploadUrl" name="uploadUrl" value="<?php echo base_url();?>imsystem/uploadimage" />
    <input type="hidden" id="token" name="token" value="<?php echo $this->util_model->getToken(32); ?>" />
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
                    <label class="col-sm-2 col-form-label text-md-right"><b>ชื่อผู้ใช้:</b></label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm" value="<?php echo $user["member_name"]; ?>" disabled>
                        </div>
                    </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-sm-2 col-form-label text-md-right"><b>รหัสผ่าน: </b></label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <input type="password" class="form-control form-control-sm" name="password" value="">
                        </div>
                    </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-sm-2 col-form-label text-md-right"><b>ยืนยันรหัสผ่าน: </b></label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <input type="password" class="form-control form-control-sm" name="confpassword" value="">
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

                    <input type="hidden" name="roles" value="<?php echo $user["member_role"]; ?>">

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-md-right"></label>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-outline-secondary mb-2 mr-sm-2">บันทึกการเปลี่ยนแปลง</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    
</form>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">ประวัติการจอง</h6>
    </div>
    <div class="card-body">
    </div>
</div>