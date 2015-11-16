<?php

class Cargos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cargos the static model class
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
		return 'public_cargos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigocentro, codjefe, codentrega, codrecibe', 'required'),

			array('avisarvencimiento, esalmacen', 'numerical', 'integerOnly'=>true),
			array('codigocentro, codjefe, codentrega, codrecibe', 'length', 'max'=>4),
			array('descargo', 'length', 'max'=>45),
			array('codtipocargo, codigoestadocargo', 'length', 'max'=>2),
			array('cnumcargo', 'length', 'max'=>10),
			array('coddocucargo', 'length', 'max'=>3),
			array('creadopor, creadoel, modificadoel, modificadopor', 'length', 'max'=>25),
			array('m_cargo, fecdocumento, fecentrega, idcargo, fechavencimiento', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigocentro, descargo, m_cargo, codjefe, codentrega, codrecibe, fecdocumento, fecentrega, codtipocargo, codigoestadocargo, cnumcargo, coddocucargo, creadopor, creadoel, modificadoel, modificadopor, idcargo, avisarvencimiento, fechavencimiento, esalmacen', 'safe', 'on'=>'search'),
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
			'jefe' => array(self::BELONGS_TO, 'VwTrabajadores', 'codjefe'),
			'entrega' => array(self::BELONGS_TO,  'VwTrabajadores', 'codentrega'),
			'recibe' => array(self::BELONGS_TO,  'VwTrabajadores', 'codrecibe'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigocentro' => 'Codigocentro',
			'descargo' => 'Descargo',
			'm_cargo' => 'M Cargo',
			'codjefe' => 'Codjefe',
			'codentrega' => 'Codentrega',
			'codrecibe' => 'Codrecibe',
			'fecdocumento' => 'Fecdocumento',
			'fecentrega' => 'Fecentrega',
			'codtipocargo' => 'Codtipocargo',
			'codigoestadocargo' => 'Codigoestadocargo',
			'cnumcargo' => 'Cnumcargo',
			'coddocucargo' => 'Coddocucargo',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadoel' => 'Modificadoel',
			'modificadopor' => 'Modificadopor',
			'idcargo' => 'Idcargo',
			'avisarvencimiento' => 'Avisarvencimiento',
			'fechavencimiento' => 'Fechavencimiento',
			'esalmacen' => 'Esalmacen',
		);
	}

public $maximovalor;
public function beforeSave() {
							if ($this->isNewRecord) {
									
									///$this->usuario=Yii::app()->user->name;
											
									  
											$this->coddocucargo='260';
											$this->cnumcargo=Numeromaximo::numero($this->model(),'cnumcargo','maximovalor',10);
										
											//$this->cnumcargo=
											//$command = Yii::app()->db->createCommand(" select nextval('sq_guias') "); 											
											//$this->n_guia= $command->queryScalar();
											$this->codigoestadocargo='99'; //para que no lo agarre la vista VW-GUIA  HASTA QUE GRABE TODO EL DETALLE
									} else
									{
										  IF ($this->c_estgui=='99') //SI SE TRATA DE UNA GUIA NUEVA COLOCARLE 'PREVIO'
												$this->codigoestadocargo='10';
												  
										//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
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

		$criteria->compare('codigocentro',$this->codigocentro,true);
		$criteria->compare('descargo',$this->descargo,true);
		$criteria->compare('m_cargo',$this->m_cargo,true);
		$criteria->compare('codjefe',$this->codjefe,true);
		$criteria->compare('codentrega',$this->codentrega,true);
		$criteria->compare('codrecibe',$this->codrecibe,true);
		$criteria->compare('fecdocumento',$this->fecdocumento,true);
		$criteria->compare('fecentrega',$this->fecentrega,true);
		$criteria->compare('codtipocargo',$this->codtipocargo,true);
		$criteria->compare('codigoestadocargo',$this->codigoestadocargo,true);
		$criteria->compare('cnumcargo',$this->cnumcargo,true);
		$criteria->compare('coddocucargo',$this->coddocucargo,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('idcargo',$this->idcargo,true);
		$criteria->compare('avisarvencimiento',$this->avisarvencimiento);
		$criteria->compare('fechavencimiento',$this->fechavencimiento,true);
		$criteria->compare('esalmacen',$this->esalmacen);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}