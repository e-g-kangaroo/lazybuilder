<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2>DB Builder</h2>

	<div id="building_control">
		<h3>Next builder : <span id="next_building"><?php echo $next->num_str; ?></span></h3>
		<button id="lazy_builder_up" class="button-primary">Up</button>
		<button id="lazy_builder_down" class="button-primary">Down</button>
	</div>

	<div id="buildings">
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
			<li id="building_<?php echo $b->num ?>">
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
	
	<div id="building_info">
		<div id="base">
			<h4>Builder ID : <span id="show_builder_id"><?php echo $next->num_str; ?></span></h4>
			<h4>Title : <span id="show_builder_title"><?php echo $next->name; ?></span></h4>
		</div>

		&nbsp;<a href="#" class="tab active" id="up">Up</a>
		<a href="#" class="tab" id="down">Down</a>

		<div id="details">
			<h4><?php // echo ucwords($build_title); ?></h4>
			<ul></ul>
		</div>

		<input type="hidden" id="builder_num" value="<?php echo $next->num; ?>">

	</div>
</div>