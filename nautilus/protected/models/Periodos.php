<?php

/**
 * This is the model class for table "{{periodos}}".
 *
 * The followings are the available columns in table '{{periodos}}':
 * @property integer $id
 * @property string $mes
 * @property string $anno
 * @property string $inicio
 * @property string $final
 * @property string $activo
 * @property integer $toleranciaatras
 * @property integer $toleranciadelante
 */
class Periodos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{periodos}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mes, anno, inicio, final, toleranciaatras, toleranciadelante', 'required'),
			array('toleranciaatras, toleranciadelante', 'numerical', 'integerOnly'=>true),
			array('mes, anno', 'length', 'max'=>2),
			array('activo', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, mes, anno, inicio, final, activo, toleranciaatras, toleranciadelante', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'mes' => 'Mes',
			'anno' => 'Anno',
			'inicio' => 'Inicio',
			'final' => 'Final',
			'activo' => 'Activo',
			'toleranciaatras' => 'Toleranciaatras',
			'toleranciadelante' => 'Toleranciadelante',
		);
	}

	public function HoyDentroPeriodo()
	{
		if( time() >=strtotime($this->inicio.'') -$this->toleranciaatras * (24 * 60 * 60)
			and
			time() <= strtotime($this->final.'')+$this->toleranciadelante * (24 * 60 * 60)
		){
			return true;
		} else {
				return false;
		}

	}

	public function FechaDentroPeriodo($fecha)
	{
		if(strtotime($fecha.'') >=strtotime($this->inicio.'')-$this->toleranciaatras * (24 * 60 * 60)
			and
			strtotime($fecha.'') <= strtotime($this->final.'')+$this->toleranciadelante * (24 * 60 * 60)
		  ){
			return true;
		} else {
			return false;
		}

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

		$criteria->compare('id',$this->id);
		$criteria->compare('mes',$this->mes,true);
		$criteria->compare('anno',$this->anno,true);
		$criteria->compare('inicio',$this->inicio,true);
		$criteria->compare('final',$this->final,true);
		$criteria->compare('activo',$this->activo,true);
		$criteria->compare('toleranciaatras',$this->toleranciaatras);
		$criteria->compare('toleranciadelante',$this->toleranciadelante);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function search_activo()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('mes',$this->mes,true);
		$criteria->compare('anno',$this->anno,true);
		$criteria->compare('inicio',$this->inicio,true);
		$criteria->compare('final',$this->final,true);
		//$criteria->compare('activo',$this->activo,true);
		$criteria->compare('toleranciaatras',$this->toleranciaatras);
		$criteria->compare('toleranciadelante',$this->toleranciadelante);
		$criteria->addcondition("activo='1'");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Periodos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
