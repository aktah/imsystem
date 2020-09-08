    </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; IM System 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><?php echo $this->lang->line('logout_model_title') ?></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"><?php echo $this->lang->line('logout_model_body') ?></div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal"><?php echo $this->lang->line('cancel') ?></button>
          <a class="btn btn-primary" href="<?php echo base_url();?>imsystem/logout"><?php echo $this->lang->line('logout'); ?></a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/jquery-ui/jquery-ui.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url(); ?>assets/js/sb-admin-2.js"></script>

  <!-- Page level plugins -->
  <script src="<?php echo base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/datatables/datatables-custom.js"></script>

  <script src='<?php echo base_url(); ?>assets/vendor/fullcalendar/core/main.js'></script>
  <script src='<?php echo base_url(); ?>assets/vendor/fullcalendar/interaction/main.js'></script>
  <script src='<?php echo base_url(); ?>assets/vendor/fullcalendar/daygrid/main.js'></script>
  <script src='<?php echo base_url(); ?>assets/vendor/fullcalendar/timegrid/main.js'></script>
  <script src='<?php echo base_url(); ?>assets/vendor/fullcalendar/core/locales/th.js'></script>


  <script src='<?php echo base_url(); ?>assets/vendor/lightbox/ekko-lightbox.min.js'></script>

  <!-- Sweet Alert 2 -->  
  <script src="<?php echo base_url(); ?>assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
  
</body>

</html>