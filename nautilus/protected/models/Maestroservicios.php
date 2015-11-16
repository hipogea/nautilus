<?php

/**
 * This is the model class for table "{{maestroservicios}}".
 *
 * The followings are the available columns in table '{{maestroservicios}}':
 * @property integer $id
 * @property string $codserv
 * @property string $catval
 * @property string $DECRIPCION
 * @property string $descripcion
 */
class Maestroservicios extends ModeloGeneral
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{maestroservicios}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catval, descripcion', 'required'),
			//array('codserv', 'length', 'max'=>8),
			array('catval', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codserv, catval,  descripcion', 'safe', 'on'=>'search'),
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
			'codserv' => 'Codserv',
			'catval' => 'Catval',
			'DECRIPCION' => 'Decripcion',
			'descripcion' => 'Descripcion',
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

		//$criteria->compare('id',$this->id);
		$criteria->compare('codserv',$this->codserv,true);
		$criteria->compare('catval',$this->catval,true);

		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_window()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codserv',$this->codserv,true);
		$criteria->addcondition(" descripcion like '%".$this->descripcion."%' ");


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 100,
			),
		));
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Maestroservicios the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function yaestaenuso(){
		$criterio=New DBCriteria;
		$criterio->addcondition("codservicio=:servi");
		$criterio->paramas=array(":servi"=>$this->codserv);
		$registro=Desolpe::model()->find($criterio);
		return(is_null($registro))?false:true;
	}


	public function beforeSave() {
		if ($this->isNewRecord) {

			//$command = Yii::app()->db->createCommand(" select nextval('sq_guias') ");
			$this->iduser=Yii::app()->user->id;
			$this->fechacre=date("Y-m-d H:i:s");
			$this->codocu='560';
			$this->codserv=$this->correlativo('codserv',null,'30',5);



		} else
		{
		}



		return parent::beforeSave();
	}


}
