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

$this->breadcrumbs=array(
	'Feedbacks'=>array('index'),
	$model->FEE_ID,
);

$this->menu=array(
	array('label'=>'List Feedbacks', 'url'=>array('index')),
	array('label'=>'Create Feedbacks', 'url'=>array('create')),
	array('label'=>'Update Feedbacks', 'url'=>array('update', 'id'=>$model->FEE_ID)),
	array('label'=>'Delete Feedbacks', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->FEE_ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Feedbacks', 'url'=>array('admin')),
);

$this->mainButtons = array(
	array('label'=>$this->trans->GENERAL_EDIT, 'link_id'=>'middle_single', 'url'=>array('update',$this->getActionParams())),
);
?>

<h1><?php printf($this->trans->TITLE_FEEDBACKS_VIEW, $model->FEE_ID); ?></h1>
<div class="f-center">
	<?php echo CHtml::link($this->trans->GENERAL_BACK_TO_SEARCH, array('search'), array('class'=>'button')); ?><br>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'FEE_ID',
		'FEE_TEXT',
		'FEE_STATUS',
		'CREATED_BY',
		'CREATED_ON',
		'CHANGED_BY',
		'CHANGED_ON',
	),
)); ?>
