<?php
/**
 * Conversation Fixture
 */
class ConversationFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'conversation';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'sender_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'recipient_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_conversation_sender_id' => array('column' => 'sender_user_id', 'unique' => 0),
			'fk_conversation_recipient_id' => array('column' => 'recipient_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'sender_user_id' => 1,
			'recipient_user_id' => 1
		),
	);

}
