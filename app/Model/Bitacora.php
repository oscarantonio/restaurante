<?php
App::uses('AppModel', 'Model');

class Bitacora extends AppModel
{
	public $belongsTo = array(
		'Users' => array(
			'className' => 'Users',
			'foreignKey' => 'user',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
}
?>
