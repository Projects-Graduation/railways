<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="../../index.html"><img src="<?= source('images/logo.png') ?>" alt="logo" /></a>
        <!-- <a class="navbar-brand brand-logo-mini" href="../../index.html"><img src="src/dashboard/images/logo-mini.svg" alt="logo" /></a> -->
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <div id="form-search-by-id" class="search-field d-none d-md-block">
            <div class="d-flex align-items-center h-100" action="">
                <input type="hidden" name="operation" value="search">
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                        <i class="input-group-text border-0 mdi mdi-magnify"></i>
                    </div>
                    <input type="text" class="form-control bg-transparent" style="height: 48px;" name="model_id" placeholder="ادخل الرقم هنا">
                </div>
                <div class="input-group">
                    <select class="form-control bg-transparent" name="model_url">
                        <option value="<?= page('ticket') ?>?ticket_id=:model_id">تذكرة</option>
                        <option value="<?= page('travel') ?>?travel_id=:model_id">رحلة</option>
                        <option value="<?= page('train') ?>?train_id=:model_id">قطار</option>
                    </select>
                    <div class="input-group-append bg-transparent">
                        <button id="btn-search-by-id" type="button" class="btn btn-primary" style="border-radius: 0; border-width: 2px;">
                            <span>بحث</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <ul class="navbar-nav navbar-nav-right pr-0">
            <li class="nav-item">
                <a class="nav-link" href="<?= page('ticket') ?>">
                    <div class="nav-text">
                        <i class="fa fa-plus"></i>
                        <span class="mb-1 text">إضافة تذكرة</span>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= page('reports') ?>">
                    <div class="nav-text">
                        <i class="fa fa-print"></i>
                        <span class="mb-1 text">التقارير</span>
                    </div>
                </a>
            </li>
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black"><?= userLogedIn() ? user('username') : '' ?></p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="<?= page('edit-account') ?>">
                        <i class="mdi mdi-account mr-2 text-success"></i>
                        <span>الحساب</span>
                    </a>
                </div>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
                <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                </a>
            </li>
            <li class="nav-item nav-logout d-none d-lg-block">
                <a class="nav-link" href="<?= page('logout') ?>">
                <i class="mdi mdi-power"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>