<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2>DB Builder</h2>

	<div id="migration_control">
		<h3>Current builder : <?php echo $current; ?></h3>
		<button id="update" class="button-primary">Up</button>
		<button id="update" class="button-primary">Down</button>
	</div>

	<div id="migrations">
		<h3>Build files</h3>
		<ul>
			<?php foreach ($build_files as $b) : ?>
			<li class="'. $m->class. '">
				<a href="#" id="<?php echo $b->name?>"><?php echo $b->name; ?></a>
				<?php if (strpos($b->class, 'current') !== FALSE) echo ' ←Current'; ?>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	
	<div id="migration_info">
		<div id="base">
			<h4>Builder ID : 02</h4>
			<h4>Title : <?php echo $info['title']; ?></h4>
			<h4>Description : <?php echo $info['description']; ?></h4>
			<h4>Date created : <?php echo $info['date_created']; ?></h4>
		</div>

		&nbsp;<a href="#" class="tab selected">Up</a>
		<a href="#" class="tab">Down</a>

		<div id="details">
			<a href="#" class="selected">Modufied</a>
			<a href="#" class="">Executed code</a>

			<div id="modufied">
				<?php foreach ($builders as $build_title => $modifications) : ?>
					<h4><?php echo ucwords($build_title); ?></h4>
					<ul>
						<?php $empty = true; foreach ($modifications as $m) : $empty = false; ?>
							<li>
								<span class="<?php echo $m['change_type']; ?>"><?php echo $m['change_type'] ?></span>
								<?php echo (isset($m['name'])        ? 'Name : '.        $m['name']       : ''). ', '; ?>
								<?php echo (isset($m['nicename'])    ? 'Nicename : '.    $m['nicename']   : ''). ', '; ?>
								<?php echo (isset($m['parent'])      ? 'Parent : '.      $m['parent']     : ''). ', '; ?>
								<?php echo (isset($m['description']) ? 'Description : '. $m['description']: ''); ?>
							</li>
						<?php endforeach; ?>
						<?php if ($empty) echo '<li>None</li>'; ?>
					</ul>
				<?php endforeach ;?>
			</div>
			
			<div id="code">
			</div>
		</div>
		
	</div>
</div>