<?php

class Atencionreserva extends CActiveRecord
{

	CONST ESTADO_CREADO='10';
	CONST ESTADO_ANULADO='20';

	public function tableName()
	{
		return '{{atencionreserva}}';
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id, cant, hidreserva, hidkardex', 'required'),
			array('cant', 'numerical'),
			array('id, hidreserva, hidkardex', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cant, hidreserva, hidkardex', 'safe', 'on'=>'search'),
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
			'atencionreserva_alkardex' => array(self::HAS_ONE, 'Alkardex', 'hidkardex'),
			'atencionreserva_alreserva' => array(self::BELONGS_TO, 'Alreserva', 'hidreserva'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cant' => 'Cant',
			'hidreserva' => 'Hidreserva',
			'hidkardex' => 'Hidkardex',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('hidreserva',$this->hidreserva,true);
		$criteria->compare('hidkardex',$this->hidkardex,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Atencionreserva the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



public static function getTotal($provider)
{
	$total=0;

	foreach($provider->data as $data)
	{
		if($data->est <> '20'){
			$r = $data->monto;

			$total += $r;

		}
	}
	return $total;
}

}