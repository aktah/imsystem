<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">สถานที่จัดเก็บเครื่องมือวิจัย</h1>
<p class="mb-4">คุณสามารถเรียกดูรายชื่อสถานที่จัดเก็บเครื่องมือวิจัยและรายชื่อเครื่องมือวิจัยที่เกี่ยวข้องทั้งหมดได้ที่นี่</p>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">รายชื่อสถานที่จัดเก็บเครื่องมือวิจัย</h6>

        <div class="d-flex align-items-right justify-content-end">
            <a href="<?php echo base_url(); ?>storage/create" class="btn btn-primary ml-2"><i class="fas fa-plus-circle"></i> เพิ่ม</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="instrumentsTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>#</th>
                <th>ชื่อ</th>
                <th>จำนวนเครื่องมือวิจัย</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>#</th>
                <th>ชื่อ</th>
                <th>จำนวนเครื่องมือวิจัย</th>
            </tr>
            </tfoot>
            <tbody>
            <?php foreach($storages as $storage) : ?>
            <tr>
            <td><?php echo $storage['storage_id']; ?></td>
            <td><a href="<?php echo base_url(); ?>storage/<?php echo $storage['storage_id']; ?>"><?php echo $storage['storage_name']; ?></a></td>
            <td><?php echo $storage['instrument_count']; ?></td>
            </tr>
            <?php endforeach;?>

            </tbody>
        </table>
        </div>
    </div>
</div>