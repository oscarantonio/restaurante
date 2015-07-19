<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function beforeFilter()
	{
		parent::beforeFilter();
		
		$this->Auth->allow('add');
		
	}
	
	public function afterFilter()
	{
		if ($this->params['action'] != 'login') {
			$data['Bitacora']['user'] = $this->Auth->user()['fullname'];
			$data['Bitacora']['controller'] = parent::traducir( $this->params['controller'] ); 
			$data['Bitacora']['actions'] = parent::traducir( $this->params['action'] );
			$this->loadModel('Bitacora');
			$this->Bitacora->create();
			$this->Bitacora->save($data);
		}
	}

	public function login()
	{
		if($this->request->is('post'))
		{
			if($this->Auth->login())
			{
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Session->setFlash('Usuario y/o contraseña son incorrectos!', 'default', array('class' => 'alert alert-danger'));
		}
	}
	
	public function logout()
	{
		return $this->redirect($this->Auth->logout());
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			$this->request->data['User']['role'] = 'user';
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('The user has been saved.', 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The user could not be saved. Please, try again.', 'default', array('class' => 'alert alert-danger'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('The user has been saved.', 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The user could not be saved. Please, try again.', 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash('The user has been deleted.', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('The user could not be deleted. Please, try again.', 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	public function backup() {
		
	}

	function dump($tables = '*') {

		$return = '';

		$modelName = $this->modelClass;

		$dataSource = $this->{$modelName}->getDataSource();
		$databaseName = $dataSource->getSchemaName();


		// Do a short header
		$return .= '-- Database: `' . $databaseName . '`' . "\n";
		$return .= '-- Generation time: ' . date('D jS M Y H:i:s') . "\n\n\n";


		if ($tables == '*') {
			$tables = array();
			$result = $this->{$modelName}->query('SHOW TABLES');
			foreach($result as $resultKey => $resultValue){
				$tables[] = current($resultValue['TABLE_NAMES']);
			}
		} else {
			$tables = is_array($tables) ? $tables : explode(',', $tables);
		}

		// Run through all the tables
		foreach ($tables as $table) {
			$tableData = $this->{$modelName}->query('SELECT * FROM ' . $table);

			$return .= 'DROP TABLE IF EXISTS ' . $table . ';';
			$createTableResult = $this->{$modelName}->query('SHOW CREATE TABLE ' . $table);
			$createTableEntry = current(current($createTableResult));
			$return .= "\n\n" . $createTableEntry['Create Table'] . ";\n\n";

			// Output the table data
			foreach($tableData as $tableDataIndex => $tableDataDetails) {

				$return .= 'INSERT INTO ' . $table . ' VALUES(';

				foreach($tableDataDetails[$table] as $dataKey => $dataValue) {

					if(is_null($dataValue)){
						$escapedDataValue = 'NULL';
					}
					else {
						// Convert the encoding
						$escapedDataValue = mb_convert_encoding( $dataValue, "UTF-8", "ISO-8859-1" );

						// Escape any apostrophes using the datasource of the model.
						$escapedDataValue = $this->{$modelName}->getDataSource()->value($escapedDataValue);
					}

					$tableDataDetails[$table][$dataKey] = $escapedDataValue;
				}
				$return .= implode(',', $tableDataDetails[$table]);

				$return .= ");\n";
			}

			$return .= "\n\n\n";
		}

		// Set the default file name
		$fileName = $databaseName . '-' . date('Y-m-d_H-i-s') . '.sql';

		// Serve the file as a download
		$this->autoRender = false;
		$this->response->type('Content-Type: text/x-sql');
		$this->response->download($fileName);
		$this->response->body($return);
	}
}
