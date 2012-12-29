<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2>DB Builder</h2>

	<div id="migration_control">
		<h3>Current builder : <span id="current_builder"><?php echo $current; ?></span></h3>
		<button id="lazy_builder_up" class="button-primary">Up</button>
		<button id="lazy_builder_down" class="button-primary">Down</button>
	</div>

	<div id="migrations">
		<h3>Build files</h3>
		<ul>
<?php
			try {
			$build_files = new LazyBuilder_Collection_Building();
			foreach ($build_files as $b) :
?>
			<li>
				<?php echo $b->num_str ?>: <a href="#" id="<?php echo $b->num ?>"><?php echo $b->name ?></a>
			</li>
<?php
			endforeach;

			} catch ( Exception $e ) {
?>
			<li class="error">Error</li>
<?php
			}
?>
		</ul>
	</div>
	
	<div id="migration_info">
		<div id="base">
			<h4>Builder ID : <?php echo $current; ?></h4>
			<h4>Title : <?php echo $info['title']; ?></h4>
		</div>

		&nbsp;<a href="#" class="tab selected">Up</a>
		<a href="#" class="tab">Down</a>

		<div id="details">
			<h4><?php // echo ucwords($build_title); ?></h4>
			<ul>
			</ul>
		</div>
		
	</div>
</div>