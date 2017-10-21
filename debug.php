
<div id="debug">
	<style type="text/css">
		#debug { width: 100%; border: 3px brown solid; border-radius: 5px; }
		#debug #dbgtitle { background: brown; font-size: 12px; font-weight: bold; color: white; padding: 3px; }
		#debug #dbgpanels { overflow: auto; height: 200px;}
		.gv { float: left; width: 150px; border: 2px gray solid; margin: 3px; border-radius: 6px; }
		.gv div { background: gray; color: white; font-weight: bold; }
		.gv pre { font-size: 8px; overflow: auto; height: 150px; }
	</style>
	<div id="dbgtitle">DEBUG PANEL</div>
	<div id="dbgpanels">
		<?php if(isset($_SESSION)): ?>
		<div class="gv">
			<div>$_SESSION</div> 
			<pre><?php var_dump($_SESSION); ?></pre>
		</div>
		<?php endif; ?>
		<div class="gv">
			<div>$_GET</div> 
			<pre><?php var_dump($_GET); ?></pre>
		</div>
		<div class="gv">
			<div>$_POST</div> 
			<pre><?php var_dump($_POST); ?></pre>
		</div>
		<div class="gv">
			<div>$_REQUEST</div> 
			<pre><?php var_dump($_REQUEST); ?></pre>
		</div>
		<div class="gv">
			<div>$_COOKIE</div> 
			<pre><?php var_dump($_COOKIE); ?></pre>
		</div>
		<div class="gv">
			<div>$_FILES</div> 
			<pre><?php var_dump($_FILES); ?></pre>
		</div>
		<div class="gv">
			<div>$_SERVER</div> 
			<pre><?php var_dump($_SERVER); ?></pre>
		</div>
		<div style="clear: both;"></div>
	</div>
</div>