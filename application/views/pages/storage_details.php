<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">สถานที่จัดเก็บเครื่องมือวิจัย</h1>
<p class="mb-4">คุณสามารถเรียกดูรายชื่อสถานที่จัดเก็บเครื่องมือวิจัยและรายชื่อเครื่องมือวิจัยที่เกี่ยวข้องทั้งหมดได้ที่นี่</p>

<?php echo form_open_multipart('storage/update', array('id' => 'formStorage'));?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">รายละเอียดของสถานที่จัดเก็บเครื่องมือวิจัย</h6>
    </div>
    <div class="card-body">

        <?php if (isset($storage)): ?>
        <input type="hidden" class="form-control" name="id" value="<?php echo $storage['id'] ?>" />
        <?php endif; ?>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-md-right">ชื่อสถานที่จัดเก็บ</label>
          <div class="col-sm-10 col-form-label"><input type="text" class="form-control" name="name" value="<?php echo isset($storage) ? $storage['name'] : "" ?>" /></div>
        </div>

        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-md-right">เครื่องมือวิจัย</label>

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
            <option value='0'>— เลือกเครื่องมือที่ต้องการเพิ่ม —</option>
            <?php foreach($this->instrument_model->notStoreList() as $ins) : ?>
            <option value='<?php echo $ins["ins_id"]; ?>'><?php echo $ins["ins_name"]; ?></option>
            <?php endforeach; ?>
          </select>
          <div class="form-group">
            <button type="button" class="btn btn-primary btn-sm" id="addStorage">เพิ่ม</button>
          </div>
          </div>
          </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-lg-12">
    <?php if (isset($storage)): ?>
        <div class="text-center"><button name="updateStorage" type="submit" class="btn btn-outline-secondary mb-2 mr-sm-2">บันทึก</button> <button name="delStorage" type="submit" class="btn btn-outline-danger mb-2 mr-sm-2">ลบ</button></div>
    <?php else:?>
        <div class="text-center"><button name="createStorage" type="submit" class="btn btn-outline-primary mb-2 mr-sm-2">สร้าง</button>
    <?php endif; ?>
    </div>
</div>

</form>