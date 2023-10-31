<?php
App::uses('AppModel', 'Model');
/**
 * Conversation Model
 *
 */
class Conversation extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'conversation';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

	public $belongsTo = array(
        'Sender' => array(
            'className' => 'User',
            'foreignKey' => 'sender_user_id'
        ),
        'Recipient' => array(
            'className' => 'User',
            'foreignKey' => 'recipient_user_id'
        ),
    );

	public $hasMany = array(
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'convo_id'
        )
    );
}

