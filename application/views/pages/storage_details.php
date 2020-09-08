<?php echo form_open_multipart('storage/update', array('id' => 'formStorage'));?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('warehouse'); ?></h6>
    </div>
    <div class="card-body">

        <?php if (isset($storage)): ?>
        <input type="hidden" class="form-control" name="id" value="<?php echo $storage['id'] ?>" />
        <?php endif; ?>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-md-right"><?php echo $this->lang->line('warehouse'); ?></label>
          <div class="col-sm-10 col-form-label"><input type="text" class="form-control" name="name" value="<?php echo isset($storage) ? $storage['name'] : "" ?>" /></div>
        </div>

        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-md-right"><?php echo $this->lang->line('instrument'); ?></label>

          <div class="col-sm-10 col-form-label">
          <ul id="storage" style="list-style-type:none;">
            <?php if (isset($storage['instruments'])) : ?>
              <?php foreach ($storage['instruments'] as $ins) : ?>
                </li><li id="insList" data-id="<?php echo $ins["id"]; ?>"><i name="removeStorage<?php echo $ins["id"]; ?>" class="fa fa-trash fa-xs mr-2"></i> <?php echo $ins["name"]; ?>
              <?php endforeach; ?>
            <?php endif; ?>
          </ul> 

          <hr>
          <div class="form-inline">
          <select class="form-control form-control-sm mr-2" id="store_instrument">
            <option value='0'>— <?php echo $this->lang->line('select_instrument_for_store'); ?> —</option>
            <?php foreach($this->instrument_model->notStoreList() as $ins) : ?>
            <option value='<?php echo $ins["ins_id"]; ?>'><?php echo $ins["ins_name"]; ?></option>
            <?php endforeach; ?>
          </select>
          <div class="form-group">
            <button type="button" class="btn btn-primary btn-sm" id="addStorage"><?php echo $this->lang->line('add'); ?></button>
          </div>
          </div>
          </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-lg-12">
    <?php if (isset($storage)): ?>
        <div class="text-center"><button name="updateStorage" type="submit" class="btn btn-outline-secondary mb-2 mr-sm-2"><?php echo $this->lang->line('save'); ?></button> <button name="delStorage" type="submit" class="btn btn-outline-danger mb-2 mr-sm-2"><?php echo $this->lang->line('remove'); ?></button></div>
    <?php else:?>
        <div class="text-center"><button name="createStorage" type="submit" class="btn btn-outline-primary mb-2 mr-sm-2"><?php echo $this->lang->line('create'); ?></button>
    <?php endif; ?>
    </div>
</div>

</form>