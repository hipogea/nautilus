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
        return array('accessControl',array('CrugeAccessControlFilter'));
    }


    public function accessRules()
    {
        Yii::app()->user->loginUrl = array("/cruge/ui/login");
       return array( array('allow', // allow authenticated user to perform 'create' and 'update' actions
            'actions'=>array('create','update','admin','cambio','colocacambio','actualizacambio'),
            'users'=>array('@'),
        ));
    }

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
