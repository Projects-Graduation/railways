	<?php if(!isset($plain_layout)):?>
		</div>
	</section>
	<!-- End Content -->
	<!-- Start Footer -->
	<footer id="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<h5>الهيئة</h5>
					<ul>
						<li><a href="<?= page('about') ?>">حول الهيئة</a></li>
						<li><a href="<?= 'example' ?>">لوحة المدراء</a></li>
						<li><a href="<?= 'example' ?>">الإدارة</a></li>
						<li><a href="<?= 'example' ?>">المستثمرين</a></li>
					</ul>
				</div>
				<div class="col-md-3">
					<h5>الخدمات</h5>
					<ul>
						<li><a href="<?= 'example' ?>">حجز التذاكر</a></li>
						<li><a href="<?= 'example' ?>">عروض خاصة</a></li>
						<li><a href="<?= 'example' ?>">إضافة مشغل خدمة (شركة نقل)</a></li>
						<li><a href="<?= 'example' ?>">وظائف</a></li>
					</ul>
				</div>
				<div class="col-md-3">
					<h5>الدعم</h5>
					<ul>
						<li><a href="<?= 'example' ?>">إتصل بنا</a></li>
						<li><a href="<?= 'example' ?>">المدونة</a></li>
						<li><a href="<?= 'example' ?>">الأسئلة الشائعة</a></li>
					</ul>
				</div>
				<div class="col-md-3">
					<h5>السياسة و الشروط</h5>
					<ul>
						<li><a href="<?= 'example' ?>">سياسة الخصوصية</a></li>
						<li><a href="<?= 'example' ?>">شروط الإستخدام</a></li>
					</ul>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="copy-rights">
					<p><img src="<?= source('images/favicons/favicon-32x32.png') ?>"> <?= APP_NAME ?> &copy; جميع الحقوق محفوظة <?= date('Y/m/d') ?> </p>
				</div>
			</div>
		</div>
	</footer>
	<!-- End Footer -->
    <?php endif;?>
    
	<!-- Scripts -->
	<script type="text/javascript" src="<?= source('website/js/jquery-1.12.3.min.js') ?>"></script>
	<script type="text/javascript" src="<?= source('website/js/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" src="<?= source('website/js/style.js') ?>"></script>

	<!-- Start Datepicker required js files -->
	<script src="<?= source('website/js/picker.js') ?>" type="text/javascript"></script>
	<script src="<?= source('website/js/legacy.js') ?>" type="text/javascript"></script>
	<script src="<?= source('website/js/picker.date.js') ?>" type="text/javascript"></script>
	<script src="<?= source('website/js/picker.time.js') ?>" type="text/javascript"></script>
	<script src="<?= source('website/js/translations/ar.js') ?>" type="text/javascript"></script>
	<script src="<?= source('website/js/picker.init.js') ?>" type="text/javascript"></script>
    <!-- End Datepicker required js files -->
    
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