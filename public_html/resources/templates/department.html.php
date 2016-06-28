<!DOCTYPE html>
<html>
	<body>
		<section>
			<form action="" method="post"> 
				<select name="department">
					<option value = "">Select a department</option>
					<?php foreach ($departments as $dept): ?>
					<option value=<?php echo $dept ?>><?php echo $dept; ?></option>
					<?php endforeach; ?>
				</select>
				<br><br>
				<input type="submit" value="View">
			</form>
		</section>
	</body>
</html>
