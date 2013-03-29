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

class ActiveRecordEC extends ActiveRecordECSimple {
	protected function beforeValidate() {
		if(!Yii::app()->user->isGuest) {
			$dateTime = new DateTime();
			if($this->getIsNewRecord()) {
				// get UnixTimeStamp
				$this->CREATED_ON = $dateTime->getTimestamp();
				$this->CREATED_BY = Yii::app()->user->id;
			}
			$this->CHANGED_ON = $dateTime->getTimestamp();
			$this->CHANGED_BY = Yii::app()->user->id;
			return true;
		}
		return parent::beforeValidate();
	}

	/**
	* @return string the associated database table name
	*/
	public function tableName() {
		preg_match("/dbname=([^;]+)/i", $this->dbConnection->connectionString, $matches);
		return $matches[1].'.table_name';
	}
}
