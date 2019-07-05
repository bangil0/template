<div id="container">
	<h1>Welcome to Admin Controller!</h1>

	<div id="body">
		<p>This is admin page. <a href="<?=logout_url()?>">Logout</a> </p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>
