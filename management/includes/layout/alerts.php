<script>
	<?php if (isset($_SESSION["alert-success"])): ?>
		Swal.fire({
			title: 'تم',
			text: '<?=flash("alert-success")?>',
			icon: 'success',
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'حسنا',
		})
	<?php endif ?>
	<?php if (isset($_SESSION["alert-warning"])): ?>
		Swal.fire({
			title: 'تحذير',
			text: '<?=flash("alert-warning")?>',
			icon: 'warning',
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'حسنا',
		})
	<?php endif ?>
	<?php if (isset($_SESSION["alert-danger"])): ?>
		Swal.fire({
			title: 'خطأ',
			text: '<?=flash("alert-danger")?>',
			icon: 'error',
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'حسنا',
		})
	<?php endif ?>
</script>