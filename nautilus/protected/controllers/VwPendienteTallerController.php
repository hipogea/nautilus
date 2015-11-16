<?php

class VwPendienteTallerController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	
	/**
	
	 */
	public function actionIndex()
	{
		$model=new VwPendienteTaller('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VwPendienteTaller']))
			$model->attributes=$_GET['VwPendienteTaller'];
         $this->layout='';
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	
}
