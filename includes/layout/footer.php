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
						<li><a href="<?= page('example') ?>">لوحة المدراء</a></li>
						<li><a href="<?= page('example') ?>">الإدارة</a></li>
						<li><a href="<?= page('example') ?>">المستثمرين</a></li>
					</ul>
				</div>
				<div class="col-md-3">
					<h5>الخدمات</h5>
					<ul>
						<li><a href="<?= page('example') ?>">حجز التذاكر</a></li>
						<li><a href="<?= page('example') ?>">عروض خاصة</a></li>
						<li><a href="<?= page('example') ?>">إضافة مشغل خدمة (شركة نقل)</a></li>
						<li><a href="<?= page('example') ?>">وظائف</a></li>
					</ul>
				</div>
				<div class="col-md-3">
					<h5>الدعم</h5>
					<ul>
						<li><a href="<?= page('example') ?>">إتصل بنا</a></li>
						<li><a href="<?= page('example') ?>">المدونة</a></li>
						<li><a href="<?= page('example') ?>">الأسئلة الشائعة</a></li>
					</ul>
				</div>
				<div class="col-md-3">
					<h5>السياسة و الشروط</h5>
					<ul>
						<li><a href="<?= page('example') ?>">سياسة الخصوصية</a></li>
						<li><a href="<?= page('example') ?>">شروط الإستخدام</a></li>
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
</body>
</html>