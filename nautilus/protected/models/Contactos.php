<?php

/**

 */
class Contactos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Contactos the static model class
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
		return Yii::app()->params['prefijo'].'contactos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('c_nombre', 'required','message'=>'Debes de colocar el nombre'),
			array('c_hcod', 'length', 'max'=>6),
			array('c_nombre, c_cargo, c_tel, c_mail', 'length','min'=>10, 'max'=>30),
			array('c_mail', 'required','message'=>'El correo es un dato obligatorio'),
			array('c_mail', 'match','pattern'=>'/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/','message'=>'El correo no es el apropiado'),
			//array('creadopor, modificadopor', 'length', 'max'=>25),
			//array('creadoel, modificadoel', 'length', 'max'=>20),
			//array('correlativo', 'length', 'max'=>5),
			//array('calificacion', 'length', 'max'=>1),
			array('fecnacimiento', 'required','message'=>'Llenar la fecha de cumplea�os'),
			array('fecnacimiento', 'safe','on'=>'update'),
			array('c_hcod', 'required','on'=>'creasolo'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('c_hcod, c_nombre, c_cargo, c_tel, c_mail, creadopor, creadoel, modificadopor, modificadoel, correlativo, fecnacimiento, calificacion', 'safe', 'on'=>'search'),
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
			//'cotis' => array(self::HAS_MANY, 'Coti', 'codcon'),
			'contactos_clipro' => array(self::BELONGS_TO, 'Clipro', 'c_hcod'),
			'contactos_mail' => array(self::HAS_MANY, 'Contactosadicio', 'hidcontacto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'c_hcod' => 'Empresa',
			'c_nombre' => 'Nombres y apellidos',
			'c_cargo' => 'Cargo',
			'c_tel' => 'Telefonos ',
			'c_mail' => 'E-mail',
			'creadopor' => 'Creado por',
			'creadoel' => 'Creado el',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'correlativo' => 'Correlativo',
			'fecnacimiento' => 'Onomastico',
			'calificacion' => 'Calificacion',
		);
	}










	public function beforeSave() {
							if ($this->isNewRecord) {
									
									    $this->creadopor=Yii::app()->user->name;
										// $this->creadoel=Yii::app()->user->name;
									    //$this->codpro=Numeromaximo::numero($this->model(),'codpro','maximovalor',6);
										//$this->cod_estado='01';
											//$this->c_salida='1';
									} else
									{
										
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

		$criteria->compare('c_hcod',$this->c_hcod,true);
		$criteria->compare('c_nombre',$this->c_nombre,true);
		$criteria->compare('c_cargo',$this->c_cargo,true);
		$criteria->compare('c_tel',$this->c_tel,true);
		$criteria->compare('c_mail',$this->c_mail,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('correlativo',$this->correlativo,true);
		$criteria->compare('fecnacimiento',$this->fecnacimiento,true);
		$criteria->compare('calificacion',$this->calificacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static  function getListMailContacto($idcontacto,$codocu) {
		$modelocontacto=self::model()->findByPk($idcontacto);
		$registroshijos=$modelocontacto->contactos_mail;
		$listacorreos=$modelocontacto->c_mail.",";
		foreach($registroshijos as $fila ){
			if($fila->codocu==$codocu)
				$listacorreos.=$fila->mail.",";
		}
		// $listacorreos=substr($listacorreos,1).""; //quitar el primer slash
		$listacorreos=str_replace(",,",",",$listacorreos);//quitamos los slashes
		if(substr($listacorreos,strlen($listacorreos)-1,1)==",")
			$listacorreos=substr($listacorreos,0,strlen($listacorreos)-1); //quitar el tultimo slash si lo tuviera



		return $listacorreos;
	}

	public static  function getListMailEmpresa($codempresa,$codocu) {
		$modeloempresa=self::model()->findAll("c_hcod=:vcodempresa", array(":vcodempresa"=>$codempresa));
		//echo "esta es la empresa". $codempresa;
		//yii::app()->end();
		$listacorreos="";
		foreach($modeloempresa as $fila ){

				$listacorreos.=$fila->c_mail.",";
		}
		// $listacorreos=substr($listacorreos,1).""; //quitar el primer slash
		$listacorreos=str_replace(",,",",",$listacorreos);//quitamos los slashes
		if(substr($listacorreos,strlen($listacorreos)-1,1)==",")
			$listacorreos=substr($listacorreos,0,strlen($listacorreos)-1); //quitar el tultimo slash si lo tuviera
     /* echo "esta es la lista". $listacorreos;
		yii::app()->end();*/


		return $listacorreos;
	}




}