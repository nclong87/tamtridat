<?php

class duan extends VanillaModel {
	var $hasOne = array('account' => 'account','loaiduan' => 'loaiduan','image'=>'image');
}