<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class BitacorasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function beforeFilter()
	{
		parent::beforeFilter();
	}
	

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Bitacora->recursive = 0;
		$this->set('bitacoras', $this->Paginator->paginate());
	}
}
