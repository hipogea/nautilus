<?php

/**
 * This is the model class for table "cargamasivadet".
 *
 * The followings are the available columns in table 'cargamasivadet':
 * @property integer $id
 * @property integer $hidcarga
 * @property string $nombrecampo
 * @property string $aliascampo
 * @property string $activa
 * @property string $requerida
 */
class Cargamasivadet extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cargamasivadet}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hidcarga', 'numerical', 'integerOnly'=>true),
			array('hidcarga', 'required', 'on'=>'insert'),
			array('nombrecampo, aliascampo', 'length', 'max'=>100),
			array('activa, requerida', 'length', 'max'=>1),
			array('orden,aliascampo,longitud', 'safe', 'on'=>'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hidcarga,longitud, tipo, orden,nombrecampo, aliascampo, activa, requerida', 'safe', 'on'=>'search'),
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
			'hidcarga' => 'Hidcarga',
			'nombrecampo' => 'Nombrecampo',
			'aliascampo' => 'Aliascampo',
			'activa' => 'Activa',
			'requerida' => 'Requerida',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('hidcarga',$this->hidcarga);
		$criteria->compare('nombrecampo',$this->nombrecampo,true);
		$criteria->compare('aliascampo',$this->aliascampo,true);
		$criteria->compare('activa',$this->activa,true);
		$criteria->compare('requerida',$this->requerida,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
	public function search_por_carga($id){
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		
		$criteria->addcondition("hidcarga=:vid");
		$criteria->params=array(":vid"=>$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination' => array(
                'pageSize' => 60,
            ),
		));
		
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cargamasivadet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
