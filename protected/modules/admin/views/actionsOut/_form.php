<?php
/*
This is the EveryCook Recipe Database. It is a web application for creating (and storing) machine (and human) readable recipes.
These recipes are linked to foods and suppliers to allow meal planning and shopping list creation. It also guides the user step-by-step through the recipe with the CookAssistant
EveryCook is an open source platform for collecting all data about food and make it available to all kinds of cooking devices.

This program is copyright (C) by EveryCook. Written by Samuel Werder, Matthias Flierl and Alexis Wiasmitinow.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

See GPLv3.htm in the main folder for details.
*/
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'actions-out-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo $this->trans->CREATE_REQUIRED; ?></p>
	<?php
	echo $form->errorSummary($model);
	if ($this->errorText){
			echo '<div class="errorSummary">';
			echo $this->errorText;
			echo '</div>';
	}
	
	foreach($this->allLanguages as $lang=>$name){
	echo '<div class="row">'."\r\n";
		echo $form->labelEx($model,'AOU_DESC_'.$lang) ."\r\n";
		echo $form->textField($model,'AOU_DESC_'.$lang,array('size'=>60,'maxlength'=>100)) ."\r\n";
		echo $form->error($model,'AOU_DESC_'.$lang) ."\r\n";
	echo '</div>'."\r\n";
	}
	
	$htmlOptions_type0 = array('empty'=>$this->trans->GENERAL_CHOOSE);
	echo CHtml::link($this->trans->GENERAL_CREATE_NEW, array('stepTypes/create',array('newModel'=>time())), array('class'=>'button f-right'));
	echo Functions::createInput(null, $model, 'STT_ID', $stepTypes, Functions::DROP_DOWN_LIST, 'stepTypes', $htmlOptions_type0, $form);
	echo CHtml::link($this->trans->GENERAL_CREATE_NEW, array('tools/create',array('newModel'=>time())), array('class'=>'button f-right'));
	echo Functions::createInput(null, $model, 'TOO_ID', $tools, Functions::DROP_DOWN_LIST, 'tools', $htmlOptions_type0, $form);
	echo CHtml::link($this->trans->GENERAL_CREATE_NEW, array('actionTypes/create',array('newModel'=>time())), array('class'=>'button f-right'));
	echo Functions::createInput(null, $model, 'ATY_ID', $actionTypes, Functions::DROP_DOWN_LIST, 'actionTypes', $htmlOptions_type0, $form);
	?>

	<div class="row">
		<?php echo $form->labelEx($model,'AOU_PREP'); ?>
		<?php
			echo $this->trans->GENERAL_NO . ' ' . $form->radioButton($model,'AOU_PREP',array('uncheckValue'=>null,'value'=>'N'));
			echo  '&nbsp;&nbsp;&nbsp;';
			echo $this->trans->GENERAL_YES . ' ' . $form->radioButton($model,'AOU_PREP',array('uncheckValue'=>null,'value'=>'Y')); ?>
		<?php echo $form->error($model,'AOU_PREP'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'AOU_DURATION'); ?>
		<?php echo $form->textField($model,'AOU_DURATION'); ?>
		<?php echo $form->error($model,'AOU_DURATION'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'AOU_DUR_PRO'); ?>
		<?php echo $form->textField($model,'AOU_DUR_PRO'); ?>
		<?php echo $form->error($model,'AOU_DUR_PRO'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'AOU_CIS_CHANGE'); ?>
		<?php echo $form->textField($model,'AOU_CIS_CHANGE'); ?>
		<?php echo $form->error($model,'AOU_CIS_CHANGE'); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? $this->trans->GENERAL_CREATE : $this->trans->GENERAL_SAVE); ?>
		<?php echo CHtml::link($this->trans->GENERAL_CANCEL, array('cancel'), array('class'=>'button', 'id'=>'cancel')); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->