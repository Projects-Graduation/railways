<nav class="sidebar sidebar-offcanvas" id="sidebar">
	<ul class="nav">
		<li class="nav-item">
			<a class="nav-link" href="<?= page('index') ?>">
				<span class="menu-title">لوحة التحكم</span>
				<i class="mdi mdi-view-dashboard menu-icon"></i>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#page-travels" aria-expanded="false" aria-controls="page-travels">
				<span class="menu-title">الرحلات</span>
				<i class="menu-arrow"></i>
				<i class="mdi mdi-ticket menu-icon"></i>
			</a>
			<div class="collapse" id="page-travels">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item"> <a class="nav-link" href="<?= page('travel') ?>">إضافة رحلة</a></li>
					<li class="nav-item"> <a class="nav-link" href="<?= page('travels') ?>">قائمة الرحلات</a></li>
				</ul>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#page-roads" aria-expanded="false" aria-controls="page-roads">
				<span class="menu-title">الخطوط</span>
				<i class="menu-arrow"></i>
				<i class="mdi mdi-road menu-icon"></i>
			</a>
			<div class="collapse" id="page-roads">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item"> <a class="nav-link" href="<?= page('road') ?>">إضافة خط</a></li>
					<li class="nav-item"> <a class="nav-link" href="<?= page('roads') ?>">قائمة الخطوط</a></li>
				</ul>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#page-trains" aria-expanded="false" aria-controls="page-trains">
				<span class="menu-title">القطارات</span>
				<i class="menu-arrow"></i>
				<i class="mdi mdi-train menu-icon"></i>
			</a>
			<div class="collapse" id="page-trains">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item"> <a class="nav-link" href="<?= page('train') ?>">إضافة قطار</a></li>
					<li class="nav-item"> <a class="nav-link" href="<?= page('trains') ?>">قائمة القطارات</a></li>
				</ul>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#page-levels" aria-expanded="false" aria-controls="page-levels">
				<span class="menu-title">الفئات</span>
				<i class="menu-arrow"></i>
				<i class="mdi mdi-sort-variant menu-icon"></i>
			</a>
			<div class="collapse" id="page-levels">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item"> <a class="nav-link" href="<?= page('level') ?>">إضافة فئة</a></li>
					<li class="nav-item"> <a class="nav-link" href="<?= page('levels') ?>">قائمة الفئات</a></li>
				</ul>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#page-cities" aria-expanded="false" aria-controls="page-cities">
				<span class="menu-title">المدن</span>
				<i class="menu-arrow"></i>
				<i class="mdi mdi-city menu-icon"></i>
			</a>
			<div class="collapse" id="page-cities">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item"> <a class="nav-link" href="<?= page('city') ?>">إضافة مدينة</a></li>
					<li class="nav-item"> <a class="nav-link" href="<?= page('cities') ?>">قائمة المدن</a></li>
				</ul>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#page-users" aria-expanded="false" aria-controls="page-users">
				<span class="menu-title">المستخدمين</span>
				<i class="menu-arrow"></i>
				<i class="mdi mdi-account-group menu-icon"></i>
			</a>
			<div class="collapse" id="page-users">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item"> <a class="nav-link" href="<?= page('add-user') ?>">إضافة مستخدم</a></li>
					<li class="nav-item"> <a class="nav-link" href="<?= page('users') ?>">قائمة المستخدمين</a></li>
				</ul>
			</div>
		</li>
	</ul>
</nav>