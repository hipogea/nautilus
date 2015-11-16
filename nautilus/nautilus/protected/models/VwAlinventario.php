<?php

/**
 * This is the model class for table "vw_alinventario".
 *
 * The followings are the available columns in table 'vw_alinventario':
 * @property string $codalm
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property string $fechainicio
 * @property string $fechafin
 * @property string $periodocontable
 * @property string $codresponsable
 * @property string $codart
 * @property string $codcen
 * @property string $um
 * @property double $cantlibre
 * @property double $canttran
 * @property double $cantres
 * @property string $ubicacion
 * @property string $lote
 * @property string $siid
 * @property string $ssiduser
 * @property integer $id
 * @property string $descripcion
 */
class VwAlinventario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwAlinventario the static model class
	 */
	public $haystock;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_alinventario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'numerical', 'integerOnly'=>true),
			array('cantlibre, canttran, cantres', 'numerical'),
			array('codalm, um', 'length', 'max'=>3),
			array('periodocontable, codresponsable, codcen', 'length', 'max'=>4),
			array('codart, ubicacion, lote', 'length', 'max'=>10),
			array('ssiduser', 'length', 'max'=>30),
			array('descripcion', 'length', 'max'=>60),
			array('creadopor, creadoel, ptlibre,modificadopor, modificadoel, fechainicio, fechafin, siid', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codalm, creadopor,haystock, creadoel, modificadopor, modificadoel, fechainicio, fechafin, periodocontable, codresponsable, codart, codcen, um, cantlibre, canttran, cantres, ubicacion, lote, siid, ssiduser, id, descripcion', 'safe', 'on'=>'search'),
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
			
			'maestro' => array(self::BELONGS_TO, 'Maestrocompo', 'codart'),
			//'codocu0' => array(self::BELONGS_TO, 'Estado', 'codocu'),
			//'cCoclig' => array(self::BELONGS_TO, 'ObjetosCliente', 'c_coclig'),
			//'codobjeto0' => array(self::BELONGS_TO, 'ObjetosCliente', 'codobjeto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codalm' => 'Almac',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'fechainicio' => 'Fechainicio',
			'fechafin' => 'Fechafin',
			'periodocontable' => 'Periodo',
			'codresponsable' => 'Codresponsable',
			'codart' => 'Codart',
			'codcen' => 'Centro',
			'um' => 'Um',
			'cantlibre' => 'Stock Libre',
			'canttran' => 'Stock trans',
			'cantres' => 'Stock reserv',
			'ubicacion' => 'Ubicacion',
			'lote' => 'Lote',
			'siid' => 'Siid',
			'ssiduser' => 'Ssiduser',
			'id' => 'ID',
			'descripcion' => 'Descripcion',
			'haystock' => 'Solo stock',
		);
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

		$criteria->compare('codalm',$this->codalm,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('fechainicio',$this->fechainicio,true);
		$criteria->compare('fechafin',$this->fechafin,true);
		$criteria->compare('periodocontable',$this->periodocontable,true);
		$criteria->compare('codresponsable',$this->codresponsable,true);
		//$criteria->compare('codart',$this->codart,true);
		$criteria->compare('codcen',$this->codcen,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('cantlibre',$this->cantlibre);
		$criteria->compare('descripcion',$this->descripcion,TRUE);
		$criteria->compare('canttran',$this->canttran);
		$criteria->compare('cantres',$this->cantres);
		$criteria->compare('ubicacion',$this->ubicacion,true);
		$criteria->compare('lote',$this->lote,true);
		$criteria->compare('siid',$this->siid,true);
		$criteria->compare('ssiduser',$this->ssiduser,true);
		$criteria->compare('id',$this->id);
		if($this->haystock=='1')
		$criteria->addCondition("cantlibre > 0 ");
      //  $criteria->addCondition("cantlibre > 0 or cantres >0 or canttran > 0");
		 if(isset($_SESSION['sesion_Maestrocompo'])) {
					$criteria->addInCondition('codart', $_SESSION['sesion_Maestrocompo'], 'AND');
													  	   } ELSE {
						$criteria->compare('codart',$this->codart,true);
													  	   }
		//$criteria->addSearchCondition('descripcion',$this->descripcion,FALSE,'and','LIKE');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
												'pageSize' => 100,
														),
		));
	}


	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchpareto()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codalm',$this->codalm,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('fechainicio',$this->fechainicio,true);
		$criteria->compare('fechafin',$this->fechafin,true);
		$criteria->compare('periodocontable',$this->periodocontable,true);
		$criteria->compare('codresponsable',$this->codresponsable,true);
		//$criteria->compare('codart',$this->codart,true);
		$criteria->compare('codcen',$this->codcen,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('cantlibre',$this->cantlibre);
		$criteria->compare('descripcion',$this->descripcion,TRUE);
		$criteria->compare('canttran',$this->canttran);
		$criteria->compare('cantres',$this->cantres);
		$criteria->compare('ubicacion',$this->ubicacion,true);
		$criteria->compare('lote',$this->lote,true);
		$criteria->compare('siid',$this->siid,true);
		$criteria->compare('ssiduser',$this->ssiduser,true);
		$criteria->compare('id',$this->id);
		$criteria->addcondition('cantlibre > 0');
		//  $criteria->addCondition("cantlibre > 0 or cantres >0 or canttran > 0");
		if(isset($_SESSION['sesion_Maestrocompo'])) {
			$criteria->addInCondition('codart', $_SESSION['sesion_Maestrocompo'], 'AND');
		} ELSE {
			$criteria->compare('codart',$this->codart,true);
		}
		//$criteria->addSearchCondition('descripcion',$this->descripcion,FALSE,'and','LIKE');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 1000,
			),
		));
	}




	public static function getTotal($provider)
        {
                $total=0;
                foreach($provider->data as $data)
                {
                        $t = $data->pttotal;
                        $total += $t;
                }
                return $total;
        }
	
	
	
	
}