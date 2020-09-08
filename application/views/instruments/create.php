
<?php echo form_open_multipart('instruments/add', array('id' => 'formInstrument'));?>

<input type="hidden" id="uploadUrl" name="uploadUrl" value="<?php echo base_url();?>instruments/uploadimage" />
<input type="hidden" id="unloadUrl" name="unloadUrl" value="<?php echo base_url();?>instruments/unloadimage" />
<input type="hidden" id="token" name="token" value="<?php echo $this->input->post("token") == NULL ? $this->util_model->getToken(32) : $this->input->post("token"); ?>" />


<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('instrument'); ?></h6>
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
                  <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('device_code'); ?>: <span class="text-danger">*</span></b></label>
                  <div class="col-sm-10">
                      <div class="form-group">
                          <input type="text" class="form-control form-control-sm" name="device" value="<?php echo $this->input->post("device"); ?>">
                      </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('name'); ?> (TH): <span class="text-danger">*</span></b></label>
                  <div class="col-sm-10">
                      <div class="form-group">
                          <input type="text" class="form-control form-control-sm" name="name" value="<?php echo $this->input->post("name"); ?>">
                      </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('name'); ?> (EN): <span class="text-danger">*</span></b></label>
                  <div class="col-sm-10">
                      <div class="form-group">
                          <input type="text" class="form-control form-control-sm" name="name_en" value="<?php echo $this->input->post("name_en"); ?>">
                      </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('abbreviation'); ?>:</b></label>
                  <div class="col-sm-10">
                      <div class="form-group">
                          <input type="text" class="form-control form-control-sm" name="abbre" value="<?php echo $this->input->post("abbre"); ?>">
                      </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('model'); ?>:</b></label>
                  <div class="col-sm-10">
                      <div class="form-group">
                          <input type="text" class="form-control form-control-sm" name="model" value="<?php echo $this->input->post("model"); ?>">
                      </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right"><b><?php echo $this->lang->line('description'); ?>:</b></label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <textarea class="form-control" name="details"><?php echo $this->input->post("details"); ?></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right"><?php echo $this->lang->line('warehouse'); ?>:</label>
                  <div class="col-sm-10">
                    <select id="storagePick" class="form-control form-control-sm" name="instrument_storage">
                    <option value='0'>— <?php echo $this->lang->line('select_storage'); ?> —</option>
                    <?php foreach($this->storage_model->storageList() as $storage) : ?>
                    <option value='<?php echo $storage["storage_id"]; ?>'><?php echo $storage["storage_name"]; ?></option>
                    <?php endforeach; ?>
                    <option value='-1'>— <?php echo $this->lang->line('addnew'); ?> —</option>
                    </select>
                  </div>
                </div>


                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-md-right"><?php echo $this->lang->line('mod'); ?>:</label>
                  <div class="col-sm-10">
                  <div class="col-lg-12"><?php echo $this->lang->line('instrument_manage_mod_info'); ?></div>
                  <div class="col-lg-3">
                  <ul id="staff" style="list-style-type:none;">
                  </ul> 
                  </div>
                  <hr>
                  <div class="form-inline">
                  <select class="form-control form-control-sm mr-2" id="instrument_attendant">
                    <option value='0'>— <?php echo $this->lang->line('choose_mod_for_instrument'); ?> —</option>
                    <?php foreach($this->user_model->list() as $member) : ?>

                      <?php if ($this->auth_model->hasFlags($this->auth_model->getMemberRole($member["member_name"]), USER_ROLES['MOD'])) : ?> <!-- ผู้ใช้ต้องมีบทบาทเป็นผู้ดูแลเครื่องมือเท่านั้น -->
                          <option value='<?php echo $member["member_id"]; ?>'><?php echo (!empty($member["member_fullname"])) ? $member["member_fullname"]. " (". $member["member_name"] .")" : $member["member_name"];?></option>
                      <?php endif;?>
                    <?php endforeach; ?>
                  </select>
                  <div class="form-group">
                    <button type="button" class="btn btn-primary btn-sm" id="addStaff"><?php echo $this->lang->line('add'); ?></button>
                  </div>
                  </div>
                  </div>
                </div>

            </div>
          </div>
        </div>
      
        <div class="form-group">
          <div class="col-lg-12">
              <div class="form-group row" style="border-bottom: 1px dotted #777;">
                  <h4><?php echo $this->lang->line('options_and_settings'); ?></h4>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="status" name="status" <?php echo $this->input->post("status") ? ("checked") : (""); ?>>
                <label class="form-check-label" for="status">
                  <?php echo $this->lang->line('active'); ?>
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="unactive" name="unactive" <?php echo $this->input->post("unactive") ? ("checked") : (""); ?>>
                <label class="form-check-label" for="unactive">
                <?php echo $this->lang->line('inactive'); ?>
                </label>
              </div>
          </div>
        </div>

        <hr class="mb-5">

        <div class="form-group">
        <div class="col-lg-12">
              <div class="form-group text-center">
                <div class="mmn-dropzones">
                  <?php echo $this->lang->line('drag_and_drop_images'); ?>
                </div>
                <small><?php echo $this->lang->line('drag_and_drop_image_info'); ?></small>
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
        <div class="text-center"><button id="saveIntrument" type="submit" class="btn btn-outline-secondary mb-2 mr-sm-2"><?php echo $this->lang->line('create'); ?></button> <button type="reset" class="btn btn-outline-secondary mb-2 mr-sm-2"><?php echo $this->lang->line('reset'); ?></button> <button type="submit" name="cancel" class="btn btn-outline-secondary mb-2 mr-sm-2"><?php echo $this->lang->line('cancel'); ?></button></div>
    </div>
</div>
</form>

<form id="addStorageForm">
<!-- Modal -->
<div class="modal fade" id="addStorageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
        <div class="modal-header">
          <h2 class="modal-title"><?php echo $this->lang->line('warehouse'); ?></h2>
          <button type="button" class="close close-modal" aria-label="Close" (click)="modal.dismiss()">
              <i class="fa fa-window-close-o" aria-hidden="true"></i>
          </button>
        </div>
        <div class="modal-body">

          <div class="alert d-none"></div>

          <input type="hidden" class='form-control' name="url" value="<?php echo base_url(); ?>"/>     
                   
          <div class="form-group">
            <input type="text" class='form-control' name="storage_name" placeholder="<?php echo $this->lang->line('name'); ?>" /> 
          </div>

        </div>
        <div class="modal-footer" style="display: block;">
          <div>
              <button type="reset" class="btn btn-outline-secondary mr-2"><?php echo $this->lang->line('reset'); ?></button>
              <button type="button" class="btn btn-outline-secondary close-modal" (click)="modal.dismiss()"><?php echo $this->lang->line('cancel'); ?></button>
              <div class="float-right">
                  <button type="submit" class="btn text-white btn-secondary btn-outline-dark" ngbAutofocus><?php echo $this->lang->line('addnew'); ?></button>
              </div>
          </div>
        </div>
    </div>
  </div>
</div>
</form>
