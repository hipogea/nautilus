<?php

/**
 * This is the model class for table "mot_mat_det".
 *
 * The followings are the available columns in table 'mot_mat_det':
 * @property integer $id
 * @property string $hidmot
 * @property string $item
 * @property string $codigo
 * @property string $descripcion
 * @property string $obs
 * @property string $um
 * @property string $codigoequipo
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadoel
 * @property string $modificadopor
 * @property string $estado
 * @property string $codocu
 */
class MotMatDet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MotMatDet the static model class
	 */
	public $equipito_descripcion;
	public $maestrocompo_maestrito; 
	public $estado_estadito;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mot_mat_det';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item, estado', 'length', 'max'=>2),
			array('codigo', 'length', 'max'=>12),
			array('descripcion', 'length', 'max'=>40),
			array('um, codocu', 'length', 'max'=>3),
			array('codigoequipo', 'length', 'max'=>5),
			array('creadopor, creadoel, modificadoel, modificadopor', 'length', 'max'=>25),
			array('hidmot, obs,estado,codigoequipo','cantidad', 'safe'),
			
			
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, hidmot, cantidad, item, codigo, codigoequipo,descripcion, obs, um, codigoequipo, creadopor, creadoel, modificadoel, modificadopor, estado, codocu', 'safe', 'on'=>'search'),
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
			'maestrito' => array(self::BELONGS_TO, 'Maestrocompo', 'codigo'),
			'estadito'=>array(self::BELONGS_TO, 'Estado', 'estado'),
			//'equipito'=>array(self::BELONGS_TO, 'Inventario', 'codigoequipo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hidmot' => 'Hidmot',
			'item' => 'Item',
			'codigo' => 'Codigo',
			'descripcion' => 'Descripcion',
			'obs' => 'Obs',
			'um' => 'Um',
			'codigoequipo' => 'Codigoequipo',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadoel' => 'Modificadoel',
			'modificadopor' => 'Modificadopor',
			'estado' => 'Estado',
			'codocu' => 'Codocu',
			'cantidad'=>'Cant',
		);
	}

	
	
	public function beforeSave() {
							if ($this->isNewRecord) {
									//$this->created = new CDbExpression('NOW()');
									// $nuevovalor=new CDbExpression('SELEC MAX(NUMERO)');
										//$this->numero=new CDbExpression('SELECt MAX(NUMERO) from mot_materiales');
									//$this->modified = new CDbExpression('NOW()');
									 $this->estado='01';
									$this->codocu='034';

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

		$criteria->compare('id',$this->id);
		$criteria->compare('hidmot',$this->hidmot,true);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('obs',$this->obs,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('codigoequipo',$this->codigoequipo,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('cantidad',$this->cantidad,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function search_pedido($idpedido)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('hidmot',$this->hidmot,true);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('obs',$this->obs,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('codigoequipo',$this->codigoequipo,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->addCondition("hidmot = ".$idpedido."");
				$criteria->compare('cantidad',$this->cantidad,true);

		
		//$criteria->compare('codlugar',$this->codlugar,true);
		$criteria->together  =  true;
		$criteria->with = array('estadito');
		 if($this->estado_estadito){
				$criteria->compare('estadito.estado',$this->estado_estadito,true);
			}
		$criteria->addCondition("estadito.codocu = '034'");	
		//$criteria->with = array('equipito');
			//if($this->equipito_descripcion){
				//$criteria->compare('equipito.descripcion',$this->equipito_descripcion,true);
			//}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	
}