<?php
	use \MABEL_SI\Core\Common\Html;
	/** @var \MABEL_SI\Core\Models\Container_Option $option */
?>
<div class="mabel-accordion">
	<button class="mabel-accordion-btn"><?php echo $option->button_text; ?></button>
	<div style="<?php if($option->is_closed) echo 'display: none;';?>">
		<table class="form-table">
			<?php
				foreach($option->options as $o)
				{
					echo '<tr><th scope="row">'.$o->title.'</th>';
					echo '<td>';
						Html::option($o);
					echo '</td>';
				}
			?>
		</table>
	</div>
</div>
<?php if(!empty($option->extra_info)) {
	echo '<div class="p-t-1 extra-info">' . $option->extra_info . '</div>';
} ?>