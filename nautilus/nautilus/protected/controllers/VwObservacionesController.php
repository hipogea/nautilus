<?php

class VwObservacionesController extends Controller
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
        return array('accessControl',array('CrugeAccessControlFilter'));
    }


    public function accessRules()
    {
        Yii::app()->user->loginUrl = array("/cruge/ui/login");
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			
		);
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex($hidinventario)
	{
	
	$model=new VwObservaciones('search');
		$model->unsetAttributes();  // clear any default values
		$this->render('index',array(
			'model'=>$model,
		));
		
	}

	

}
