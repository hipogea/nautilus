<?php

class VwLoginventariController extends Controller
{

    public function filters()
    {
        return array('accessControl',array('CrugeAccessControlFilter'));
    }


    public function accessRules()
    {
        Yii::app()->user->loginUrl = array("/cruge/ui/login");
		return array(

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','mismateriales'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	
	public function actionIndex()
	{
	
	$model=new VwLoginventari('search');
		$model->unsetAttributes();  // clear any default values
	   $criter=new CDbCriteria;
			$criter->addCondition('codestado = :pcodestado');
			$criter->params = array(':pcodestado' => '01');		///solo los log s qusestan sin tratar	

	
			
			$proveedor= new  CActiveDataProvider($model, array(
									'criteria'=>$criter,
									'sort'=>array(
									'defaultOrder'=>'fecha ASC',
            )						,
            'pagination' => array(
                'pageSize' => 10,
            ),

									
									));	
		
		if(isset($_GET['VwLoginventari']))
		   
			$model->attributes=$_GET['VwLoginventari'];
            
		$this->render('vw_log',array('model'=>$model,'proveedor'=>$proveedor));
	}

	// Uncomment the following methods and override them if needed
	
	public function actionRefresca()
	{
	if (!empty($_GET['asDialog']))
		{
													//Close the dialog, reset the iframe and update the grid
		 	
		Yii::app()->end();
					
					}
			  
	}		  
	/*		  
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}