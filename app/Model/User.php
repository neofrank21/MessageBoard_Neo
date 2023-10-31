<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 */
class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
/**
 * Validation rules
 *
 * @var array
 */
	public $hasMany = array(
		'Message' => array(
			'className' => 'Message',
			'foreignKey' => 'sender_id'
		),
		'SentConversation' => array(
			'className' => 'Conversation',
			'foreignKey' => 'sender_user_id'
		),
		'ReceivedConversation' => array(
			'className' => 'Conversation',
			'foreignKey' => 'recipient_user_id'
		)
	);

	public $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Enter Valid Email',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'minLength' => array(
				'rule' => array('minLength', 5),
				'message' => 'Name must be at least 5 characters long'
			),
			'maxLength' => array(
				'rule' => array('maxLength', 20),
				'message' => 'Name cannot be more than 20 characters long'
			)
		),
		'password' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Enter a password',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'minLength' => array(
				'rule' => array('minLength', 8),
				'message' => 'Name must be at least 8 characters long'
			),
			'Match passwords' => array(
				'rule' => 'matchPasswords',
				'message' => 'Your password do not match'
			)
		),
		'confirm_password' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please confirm your password',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'minLength' => array(
				'rule' => array('minLength', 8),
				'message' => 'Name must be at least 8 characters long'
			)
		),
	);

	public function matchPasswords($data)
	{
		if ($data['password'] == $this->data['User']['confirm_password'])
		{
			return true;
		}
		$this->invalidate('confirm_password','Your password do not match');
		return false;
	}

	public function beforeSave($options = array())
	{
		if (isset($this->data['User']['password']))
		{
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
		}
		return true;
	}
}
