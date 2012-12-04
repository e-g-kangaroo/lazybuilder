<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2>Living migration</h2>

	<div id="migration_control">
		<h3>Current migration : <?php echo $current; ?></h3>
		<button id="update" class="button-primary">Up</button>
		<button id="update" class="button-primary">Down</button>
	</div>

	<div id="migrations">
		<h3>Migrations</h3>
		<ul>
			<?php foreach ($migrations as $m) : ?>
			<li class="'. $m->class. '">
				<a href="#" id="<?php echo $m->name?>"><?php echo $m->name; ?></a>
				<?php if (strpos($m->class, 'current') !== FALSE) echo ' ←Current'; ?>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	
	<div id="migration_info">
		<div id="base">
			<h4>Migration ID : 02</h4>
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
				<h4>Categories</h4>
				<?php create_modification_list($categories, 'category_'); ?>
				<h4>Tags</h4>
				<?php create_modification_list($tags, 'tag_'); ?>
				<h4>Regions</h4>
				<?php create_modification_list($regions, 'region_'); ?>
				<h4>Pages</h4>
				<?php create_modification_list($pages, 'page_'); ?>
			</div>
			
			<div id="code">
			</div>
		</div>
		
	</div>
</div>