<?php require 'init.php';
// if (!userIsAdmin()) {
// 	flash('alert-danger', 'عذرا غير مسموح لك بدخول هذا القسم يرجى مراجعة الإدارة');
// 	header("Location: index.php");
// 	exit;
// }
$_SESSION['page']   = 'users';
$title  = 'قائمة المستخدمين';
$link = ['title' => 'مستخدم', 'url' => 'add-user.php', 'icon' => 'success'];
$users 	= allUsers(['created_at', 'DESC']);

// Operations script
$operation = isset($_GET['operation']) && !empty($_GET['operation']) ? $_GET['operation'] : false;
$id = isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : false;
if ($operation && $id) {
	if ($operation === 'delete') {
		if (deleteUser($id)) {
			flash("alert-success", "تمت حذف المستخدم بنجاح.");
	        header("Location: users.php");
	        exit;
		}else{
			flash("alert-danger", "عذرا حدث خطأ اثناء عملية الحذف يرجى المحاولة مرة اخرى.");
	        header("Location: users.php");
	        exit;
		}
	}
}


include "includes/layout/header.php"; ?>
<div class="card">
	<div class="card-body">
		<!-- <h4 class="card-title"></h4> -->
		<div class="row">
			<div class="table-sorter-wrapper col-lg-12 table-responsive">
				<table class="table table-striped table-sorted">
					<thead>
						<tr>
							<th class="sortStyle descStyle" style="width: 60px">المعرف<i class="mdi mdi-chevron-down"></th>
							<th class="sortStyle descStyle">الإسم<i class="mdi mdi-chevron-down"></th>
							<th class="sortStyle descStyle">تاريخ الإنشاء<i class="mdi mdi-chevron-down"></th>
							<th>العمليات</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($users as $data): $user = userData($data); ?>
							<tr>
								<td><?= $user['id'] ?></td>
								<td><?= $user['username'] ?></td>
								<td><?= date("Y-m-d", strtotime($user['created_at'])) ?></td>
								<td>
									<a href="edit-user.php?id=<?= $user['id'] ?>" class="btn btn-xs btn-info">
										تعديل
									</a>
									<a href="<?= actionUrl('users.php', ['id', $user['id']], 'delete') ?>" class="btn btn-xs btn-danger confirm">
										حذف
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php include "includes/layout/footer.php"; ?>	