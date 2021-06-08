<?php
	/** @var \MABEL_SI\Code\Models\Shoppable_Image_VM $model */
?>

<div
	class="mabel-siwc-img-wrapper"
    data-sw-open="<?php echo $model->when_to_open ?>"
	data-sw-action="<?php echo $model->button_action ?>"
	data-sw-anim="<?php echo $model->animation;?>"
	data-sw-text="<?php echo $model->button_text ?>"
	data-sw-tags='<?php echo json_encode($model->tags,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT  ); ?>'
	data-sw-icon="<?php echo $model->icon; ?>"
    data-sw-size="<?php echo $model->size; ?>"
>
	<img src="<?php echo $model->image;?>" />
</div>