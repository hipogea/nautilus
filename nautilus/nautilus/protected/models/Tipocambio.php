<?php

/**
 * This is the model class for table "tipocambio".
 *
 * The followings are the available columns in table 'tipocambio':
 * @property string $codmon1
 * @property string $codmon2
 * @property integer $id
 * @property integer $denominador
 * @property integer $numerador
 */
class Tipocambio extends CActiveRecord
{

	public $monedaref=NULL;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tipocambio the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{tipocambio}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('compra,venta', 'numerical'),
			array('codmon1, codmon2', 'length', 'max'=>3),
			//array('compra, venta', 'required', 'message'=>'Indique todos los datos'),
			//array('compra, venta', 'safe', 'on'=>'update'),
			array('compra, venta', 'checkvalores', 'on'=>'update,insert,general'),
			array('compra, venta,monedaref', 'required', 'on'=>'general'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codmon1, codmon2, id, denominador, numerador', 'safe', 'on'=>'search'),
			array('codmon1, codmon2, ultima,cambio', 'safe', 'on'=>'analitica'),
			array('codmon1, codmon2, ultima,monedaref,cambio', 'safe', 'on'=>'general'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}


public function checkvalores($attribute,$params) {
	if(empty($this->compra) or empty( $this->venta) )
	  		$this->adderror('compra','Los datos compra y venta son obligatorios');	

	  	if($this->compra >= $this->venta )
	  		$this->adderror('compra','Imposible, la compra no puede ser mayor a la venta');	


			}




	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codmon1' => 'Codmon1',
			'codmon2' => 'Codmon2',
			'id' => 'ID',
			'denominador' => 'Denominador',
			'numerador' => 'Numerador',
		);
	}



public function beforeSave() {
							if ($this->isNewRecord) {
										
											
									} else
									{
										$this->ultima=date("Y-m-d H:i:s"); 
												$this->modificadopor=Yii::app()->user->name;  

										   }


									

									return parent::beforeSave();
				}
	











	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codmon1',$this->codmon1,true);
		$criteria->compare('codmon2',$this->codmon2,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('denominador',$this->denominador);
		$criteria->compare('numerador',$this->numerador);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}