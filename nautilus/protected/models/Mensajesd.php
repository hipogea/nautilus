<?php

/**
 * This is the model class for table "mensajesd".
 *
 * The followings are the available columns in table 'mensajesd':
 * @property string $id
 * @property string $correodestinatario
 * @property string $esinterno
 * @property string $hidevento
 */
class Mensajesd extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Mensajesd the static model class
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
		return Yii::app()->params['prefijo'].'mensajesd';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('correodestinatario', 'required'),
			//array('correodestinatario', 'unique', 'attributeName'=> 'correodestinatario', 'caseSensitive' => 'false','message'=>'Este correo ya esta registrado'),
			array('correodestinatario', 'match', 'pattern'=>'/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/',
				'message'=>'El correo no es el correcto'),			
			
			//array('correodestinatario', 'checkmail'),
			array('correodestinatario', 'length', 'max'=>60),
			array('esinterno', 'length', 'max'=>1),
			array('hidevento', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, correodestinatario, esinterno, hidevento', 'safe', 'on'=>'search'),
		);
	}



	/*public function checkmail($attribute,$params) {
		$vali=new CEmailValidator;
											if (!$vali->validatevalue($this->correodestinatario)) 
														$this->adderror('correodestinatario','El correo no es valido');

	                                                 } */
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
			'correodestinatario' => 'Correodestinatario',
			'esinterno' => 'Esinterno',
			'hidevento' => 'Hidevento',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('correodestinatario',$this->correodestinatario,true);
		$criteria->compare('esinterno',$this->esinterno,true);
		$criteria->compare('hidevento',$this->hidevento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


public function listarcorreos($ideven,$externo)
	{
		

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('correodestinatario',$this->correodestinatario,true);
		$criteria->addCondition('hidevento='.$externo);
		$criteria->addCondition("esinterno='".$ideven."'");

		$prove= new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
		return $prove->getdata();
	}


//devuelve la lista de correos 
	public function direcciones ($ideven,$externo){
		$misdireccciones= $this->findall("hidevento=:iventio and esinterno=:inter",array(":iventio"=>$ideven,":inter"=>$externo));
		//$misdirecciones= $this->findAll();
		$arreglo="";
					 if (count($activos)> 0) {
					 						for ($i = 0; $i < count($misdirecciones); ++$i) {
		         							 	  $arreglo=$arreglo.",".$misdirecciones[$i]['correodestinatario'];												



		         							 	  }



											 }

							return substr(1,$arreglo);

		
						}
            }

          

           							 	    																			