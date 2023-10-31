<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 */
class Message extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'message';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'message';

	public $belongsTo = array(
        'Conversation' => array(
            'className' => 'Conversation',
            'foreignKey' => 'convo_id'
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'sender_id'
        )
    );

}
