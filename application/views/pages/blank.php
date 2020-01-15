<br>
<br>
<br>
<center>
    <b>
        <font size="4">
            <?php if($this->session->flashdata('message')): ?>
                <?php echo $this->session->flashdata('message'); ?>
            <?php endif; ?>   
            
            <?php if($this->session->flashdata('spinner')): ?>
                <br/>
                <br/>
                <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                <span class="sr-only">กำลังโหลด...</span>
            <?php endif; ?>   
        </font>
    </b>
</center>
<br>
<br>
<br>