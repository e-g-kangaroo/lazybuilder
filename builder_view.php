<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2>DB Builder</h2>

	<div id="migration_control">
		<h3>Current builder : <?php echo $current->num_str; ?></h3>
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
			<?php if (((int) get_option(LazyBuilder::OPT_CURRENT)) == $b->num): ?>
			<li class="doing_separator">Done</li>
			<?php endif; ?>
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
			<?php if ((! get_option(LazyBuilder::OPT_CURRENT))): ?>
			<li class="doing_separator">Never doing</li>
			<?php endif; ?>
		</ul>
	</div>
	
	<div id="migration_info">
		<div id="base">
			<h4>Builder ID : <?php echo $current->num_str; ?></h4>
			<h4>Title : <?php echo $current->name; ?></h4>
		</div>

		&nbsp;<a href="#" class="tab selected">Up</a>
		<a href="#" class="tab">Down</a>

		<div id="details">
			<h4><?php // echo ucwords($build_title); ?></h4>
			<ul></ul>
		</div>

		<input type="hidden" id="builder_info_path" value="<?php echo $current->filepath; ?>">

	</div>
</div>