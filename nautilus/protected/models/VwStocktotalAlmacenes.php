<?php

/**
 * This is the model class for table "vw_stocktotal_almacenes".
 *
 * The followings are the available columns in table 'vw_stocktotal_almacenes':
 * @property string $codcen
 * @property string $codalm
 * @property string $codsoc
 * @property string $nomal
 * @property double $stocklibre
 * @property double $stockreservado
 * @property double $stocktransito
 */
class VwStocktotalAlmacenes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_stocktotal_almacenes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codcen, codalm, codsoc', 'required'),
			array('stocklibre, stockreservado, stocktransito', 'numerical'),
			array('codcen', 'length', 'max'=>4),
			array('codalm', 'length', 'max'=>3),
			array('codsoc', 'length', 'max'=>1),
			array('nomal', 'length', 'max'=>35),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codcen, codalm, codsoc, nomal, stocklibre, stockreservado, stocktransito', 'safe', 'on'=>'search'),
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
			'codcen' => 'Codcen',
			'codalm' => 'Codalm',
			'codsoc' => 'Codsoc',
			'nomal' => 'Nomal',
			'stocklibre' => 'Stocklibre',
			'stockreservado' => 'Stockreservado',
			'stocktransito' => 'Stocktransito',
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

		$criteria->compare('codcen',$this->codcen,true);
		$criteria->compare('codalm',$this->codalm,true);
		$criteria->compare('codsoc',$this->codsoc,true);
		$criteria->compare('nomal',$this->nomal,true);
		$criteria->compare('stocklibre',$this->stocklibre);
		$criteria->compare('stockreservado',$this->stockreservado);
		$criteria->compare('stocktransito',$this->stocktransito);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VwStocktotalAlmacenes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getTotal($provider)
	{
		$totallibre=0;
		$totalreserva=0;
		$totaltran=0;
		foreach($provider->data as $data)
		{
			$totallibre+=$data->stocklibre;
			$totalreserva+=$data->stockreservado;
			$totaltran+=$data->stocktransito;


		}
		return array('libre'=>$totallibre,'reserva'=>$totalreserva,'transito'=>$totaltran);
	}



}
