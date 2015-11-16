<?php

/**
 * This is the model class for table "vw_pareto".
 *
 * The followings are the available columns in table 'vw_pareto':
 * @property string $codart
 * @property string $desum
 * @property double $punit
 * @property string $descripcion
 * @property double $ptlibre
 * @property integer $ranking
 * @property string $clase
 * @property double $acumulado
 * @property double $porcentaje
 * @property string $hinventario
 * @property integer $idsesion
 * @property integer $column_7
 * @property double $porcentajeac
 */
class VwPareto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_pareto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ranking, clase, acumulado, porcentaje, hinventario, idsesion, column_7, porcentajeac', 'required'),
			array('ranking, idsesion, column_7', 'numerical', 'integerOnly'=>true),
			array('punit, ptlibre, acumulado, porcentaje, porcentajeac', 'numerical'),
			array('codart', 'length', 'max'=>10),
			array('desum, hinventario', 'length', 'max'=>20),
			array('descripcion', 'length', 'max'=>60),
			array('clase', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codart, desum, punit, descripcion, ptlibre, ranking, clase, acumulado, porcentaje, hinventario, idsesion, column_7, porcentajeac', 'safe', 'on'=>'search'),
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codart' => 'Codart',
			'desum' => 'Desum',
			'punit' => 'Punit',
			'descripcion' => 'Descripcion',
			'ptlibre' => 'Ptlibre',
			'ranking' => 'Ranking',
			'clase' => 'Clase',
			'acumulado' => 'Acumulado',
			'porcentaje' => 'Porcentaje',
			'hinventario' => 'Hinventario',
			'idsesion' => 'Idsesion',
			'column_7' => 'Column 7',
			'porcentajeac' => 'Porcentajeac',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('codart',$this->codart,true);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('punit',$this->punit);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('ptlibre',$this->ptlibre);
		$criteria->compare('ranking',$this->ranking);
		$criteria->compare('clase',$this->clase,true);
		$criteria->compare('acumulado',$this->acumulado);
		$criteria->compare('porcentaje',$this->porcentaje);
		$criteria->compare('hinventario',$this->hinventario,true);
		$criteria->compare('idsesion',$this->idsesion);
		$criteria->compare('column_7',$this->column_7);
		$criteria->compare('porcentajeac',$this->porcentajeac);
		$criteria->addcondition('idsesion='.Yii::app()->user->getId().'');
		if(isset($_SESSION['sesion_Maestrocompo'])) {
			$criteria->addInCondition('codart', $_SESSION['sesion_Maestrocompo'], 'AND');
		} ELSE {
			$criteria->compare('codart',$this->codart,true);
		}
		$criteria->order = "ranking";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 1000,
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VwPareto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
