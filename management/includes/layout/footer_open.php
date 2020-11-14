	<?php if(!isset($plain_layout)):?>
				</div>
            </div>
            <!-- content-wrapper ends -->
            <!-- footer starts here-->
            <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">حقوق الطبع والنشر © <<?= date('Y/m/d') ?>> <?= APP_NAME ?>. كل الحقوق محفوظة.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">نظام الإدارة</span>
            </div>
            </footer>
            <!-- ends here -->
        </div>
        <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
	<?php endif;?>
	<!-- Scripts -->
    <script src="<?= source('dashboard/js/vendor.bundle.base.js') ?>"></script>
    <!-- endinject -->
    <script src="<?= source('node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?= source('dashboard/js/off-canvas.js') ?>"></script>
    <script src="<?= source('dashboard/js/hoverable-collapse.js') ?>"></script>
    <script src="<?= source('dashboard/js/misc.js') ?>"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="<?= source('dashboard/js/dashboard.js') ?>"></script>
    <!-- End custom js for this page -->
	<script src="<?= plugin('sweetalert2/sweetalert2.all.min.js') ?>"></script>
	<script src="<?= plugin('parsleyjs/parsley.js') ?>"></script>
	<script src="<?= plugin('parsleyjs/i18n/ar.js') ?>"></script>
	<?php layout('alerts') ?>
	<?php
		if(isset($addons)){
			foreach($addons as $addon){
				include 'includes/addons/' . $addon . '.php';
			}
		}
	?>
	<script>
		$(function() {
			$('form').parsley();
			let input_file = $('input[type=file]')
			if (input_file.length) {
				input_file.closest('form').attr('enctype', "multipart/form-data")
			}
		})
    </script>
    <script src="<?= source('js/scripts.js') ?>"></script>