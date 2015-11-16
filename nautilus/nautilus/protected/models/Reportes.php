<?php

/**
 * This is the model class for table "reportes".
 *
 * The followings are the available columns in table 'reportes':
 * @property string $codocu
 * @property string $nombrecampo
 * @property string $etiqueta
 * @property integer $absisa
 * @property integer $ordenada
 * @property string $fuente
 * @property integer $tamanofuente
 * @property integer $id
 */
class Reportes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Reportes the static model class
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
		return Yii::app()->params['prefijo'].'reportes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('absisa, ordenada, tamanofuente', 'numerical', 'integerOnly'=>true),
			array('codocu', 'length', 'max'=>3),
			array('nombrecampo, etiqueta', 'length', 'max'=>100),
			array('fuente', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codocu, nombrecampo, etiqueta, absisa, ordenada, fuente, tamanofuente, id', 'safe', 'on'=>'search'),
		);
	}

	public function generaetiqueta($valor) {
        $cadena='<div style="position: absolute; overflow: visible;
					left: '.$this->absisa.';
					bottom: '.$this->ordenada.';
					padding: 0em; font-family:'.$this->fuente.';
					font-size:'.$this->tamanofuente.'em; margin: 0; " >'.$valor.'</div>';
      return $cadena;
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
			'codocu' => 'Codocu',
			'nombrecampo' => 'Nombrecampo',
			'etiqueta' => 'Etiqueta',
			'absisa' => 'Absisa',
			'ordenada' => 'Ordenada',
			'fuente' => 'Fuente',
			'tamanofuente' => 'Tamanofuente',
			'id' => 'ID',
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

		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('nombrecampo',$this->nombrecampo,true);
		$criteria->compare('etiqueta',$this->etiqueta,true);
		$criteria->compare('absisa',$this->absisa);
		$criteria->compare('ordenada',$this->ordenada);
		$criteria->compare('fuente',$this->fuente,true);
		$criteria->compare('tamanofuente',$this->tamanofuente);
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}