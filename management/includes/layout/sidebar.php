<!-- right SIDEBAR -->
        <div id="sidebar-nav" class="sidebar">
            <div class="sidebar-scroll">
                <nav>
                    <ul class="nav reset">
                        <li><a href="index.php" class="<?php if ($_SESSION['page'] === 'index'): ?>active<?php endif ?>">
                            <i class="fa fa-dashboard"></i> 
                            <span>لوحة التحكم</span>
                        </a></li>
                        <li><a href="categories.php" class="<?php if ($_SESSION['page'] === 'categories'): ?>active<?php endif ?>">
                            <i class="fa fa-th-large"></i> 
                            <span>الأقسام</span>
                        </a></li>
                        <li><a href="trainers.php" class="<?php if ($_SESSION['page'] === 'trainers'): ?>active<?php endif ?>">
                            <span class="fa fa-fw fa-black-tie"></span>
                            <span>المدربين</span>
                            <!-- <span class="pull-left badge"><?= count(allTrainers()) ?></span> -->
                        </a></li>
                        <li><a href="customers.php" class="<?php if ($_SESSION['page'] === 'customers'): ?>active<?php endif ?>">
                            <i class="fa fa-users"></i> 
                            <span>المتدربين</span>
                        </a></li>
                        <li><a href="courses.php" class="<?php if ($_SESSION['page'] === 'courses'): ?>active<?php endif ?>">
                            <i class="fa fa-course"></i> 
                            <span>الدورات</span>
                        </a></li>
                        <li>
                            <a href="#userPages" data-toggle="collapse" class="<?php if ($_SESSION['page'] === 'users'): ?>active<?php endif ?>">
                                <i class="fa fa-user-secret"></i> 
                                <span>المستخدمين</span> 
                                <i class="icon-submenu fa fa-chevron-right"></i>
                            </a>
                            <div id="userPages" class="collapse">
                                <ul class="nav">
                                    <li><a href="add-user.php">
                                        <span class="fa fa-fw fa-angle-left"></span>
                                        إضافة مستخدم
                                        <span class="fa fa-sm fa-plus pull-left" style="color: #c6932a;"></span>
                                    </a></li>
                                    <li><a href="users.php">
                                        <span class="fa fa-fw fa-angle-left"></span>
                                        عرض المستخدمين
                                        <span class="pull-left badge"><?= count(allUsers()) ?></span>
                                    </a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- END right SIDEBAR -->