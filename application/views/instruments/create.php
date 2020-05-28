<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">เพิ่มเครื่องมือ</h1>

<?php echo form_open_multipart('instruments/add');?>

<input type="hidden" id="uploadUrl" name="uploadUrl" value="<?php echo base_url();?>instruments/uploadimage" />
<input type="hidden" id="unloadUrl" name="unloadUrl" value="<?php echo base_url();?>instruments/unloadimage" />
<input type="hidden" id="token" name="token" value="<?php echo $this->input->post("token") == NULL ? $this->util_model->getToken(32) : $this->input->post("token"); ?>" />


<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">รายละเอียดเครื่องมือวิจัย</h6>
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

      <div class="form-group">
        <div class="form-group row">
            <div class="col-lg">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right"><b>ชื่อ: <span class="text-danger">*</span></b></label>
                  <div class="col-sm-10">
                      <div class="form-group">
                          <input type="text" class="form-control form-control-sm" name="name" value="<?php echo $this->input->post("name"); ?>">
                      </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right"><b>รายละเอียด: <span class="text-danger">*</span></b></label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <textarea class="form-control" name="details"><?php echo $this->input->post("details"); ?></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right">สถานที่จัดเก็บ:</label>
                  <div class="col-sm-10">
                    <select id="storagePick" class="form-control form-control-sm" name="instrument_storage">
                    <option value='0'>— เลือกสถานที่จัดเก็บ —</option>
                    <?php foreach($this->instrument_model->storageList() as $storage) : ?>
                    <option value='<?php echo $storage["storage_id"]; ?>'><?php echo $storage["storage_name"]; ?></option>
                    <?php endforeach; ?>
                    <option value='-1'>— เพิ่มใหม่ —</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right">เลือกผู้รับผิดชอบ:</label>
                  <div class="col-sm-10">
                  <select class="form-control form-control-sm" name="instrument_attendant">
                    <option value='0'>— ไม่มี —</option>
                    <?php foreach($this->user_model->list() as $member) : ?>
                      <?php if ($this->auth_model->hasFlags($this->auth_model->getMemberRole($member["member_name"]), USER_ROLES['STAFF'])) : ?> <!-- ผู้ใช้ต้องมีบทบาทเป็นเจ้าหน้าที่เท่านั้น -->
                          <option value='<?php echo $member["member_id"]; ?>'><?php echo (!empty($member["member_fullname"])) ? $member["member_fullname"]. " (". $member["member_name"] .")" : $member["member_name"];?></option>
                      <?php endif;?>
                    <?php endforeach; ?>
                  </select>
                  </div>
                </div>

            </div>
          </div>
        </div>
      
        <div class="form-group">
          <div class="col-lg-12">
              <div class="form-group row" style="border-bottom: 1px dotted #777;">
                  <h4>สถานะและตั้งค่า</h4>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="status" name="status" <?php echo $this->input->post("status") ? ("checked") : (""); ?>>
                <label class="form-check-label" for="status">
                  เปิดใช้งาน
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="unactive" name="unactive" <?php echo $this->input->post("unactive") ? ("checked") : (""); ?>>
                <label class="form-check-label" for="unactive">
                  ปิดการใช้งาน
                </label>
              </div>
          </div>
        </div>

        <hr class="mb-5">

        <div class="form-group">
        <div class="col-lg-12">
              <div class="form-group text-center">
                <div class="mmn-dropzones">
                  วางไฟล์รูปภาพที่นี่เพื่ออัปโหลด
                </div>
                <!-- Progress Bar -->
                <div class="progress bg-light mmn-progress">
                  <div class="progress-bar bg-success mmn-progress-bar" role="progressbar" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <input type="file" id="uploadImage" name="uploadImage" style="display: none;" />
              
            </div>
            <div class="col-lg-12">
              <div id="mmn-image-template">
                    <div id="mmn-thumbnail" class="mmn-thumbnail form-inline" style="display: none;">
                        <img src="#" alt=""/>
                        <span></span>
                    </div>
                </div>
            </div>
            </div>
  </div>
</div>

<div class="form-group row">
    <div class="col-lg-12">
        <div class="text-center"><button type="submit" class="btn btn-outline-secondary mb-2 mr-sm-2">เพิ่ม</button> <button type="reset" class="btn btn-outline-secondary mb-2 mr-sm-2">รีเซ็ต</button> <button class="btn btn-outline-secondary mb-2 mr-sm-2">ยกเลิก</button></div>
    </div>
</div>
</form>

<form id="addStorageForm">
<!-- Modal -->
<div class="modal fade" id="addStorage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      

        <div class="modal-header">
          <h2 class="modal-title">เพิ่มสถานที่จัดเก็บใหม่</h2>
          <button type="button" class="close close-modal" aria-label="Close" (click)="modal.dismiss()">
              <i class="fa fa-window-close-o" aria-hidden="true"></i>
          </button>
        </div>
        <div class="modal-body">

          <div class="alert d-none"></div>

          <div class="form-group">
            <input type="text" class='form-control' name="storage_name" placeholder="ชื่อสถานที่" /> 
          </div>

        </div>
        <div class="modal-footer" style="display: block;">
          <div>
              <button type="reset" class="btn btn-outline-secondary mr-2">รีเซ็ต</button>
              <button type="button" class="btn btn-outline-secondary close-modal" (click)="modal.dismiss()">ยกเลิก</button>
              <div class="float-right">
                  <button type="submit" class="btn text-white btn-secondary btn-outline-dark" ngbAutofocus>สร้าง</button>
              </div>
          </div>
        </div>
    </div>
  </div>
</div>
</form>
