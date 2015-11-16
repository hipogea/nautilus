<?php

/**
 * This is the model class for table "{{bloqueos}}".
 *
 * The followings are the available columns in table '{{bloqueos}}':
 * @property string $id
 * @property string $codocu
 * @property integer $iduser
 * @property string $fechabloqueo
 * @property string $iddocu
 * @property string $ip
 * @property string $idsesion
 */
class Bloqueos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{bloqueos}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id, codocu, iduser, fechabloqueo, iddocu, ip, idsesion', 'required'),
			array('iduser', 'numerical', 'integerOnly'=>true),
			array('id, iddocu', 'length', 'max'=>20),
			array('codocu', 'length', 'max'=>3),
			array('ip', 'length', 'max'=>15),
			array('idsesion', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, codocu, iduser, fechabloqueo, iddocu, ip, idsesion', 'safe', 'on'=>'search'),
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
			'documentos'=>array(self::BELONGS_TO, 'Documentos', 'codocu'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codocu' => 'Codocu',
			'iduser' => 'Iduser',
			'fechabloqueo' => 'Fechabloqueo',
			'iddocu' => 'Iddocu',
			'ip' => 'Ip',
			'idsesion' => 'Idsesion',
		);
	}

	public static function bloquea($id,$codigodoc)	{

		$criterio=New CDbCriteria();
		$criterio->addcondition(" codocu=:vdocu AND iddocu=:vid AND iduser =:vusuario");
		$criterio->params=array(":vdocu"=>$codigodoc,":vid"=>$id, ":vusuario"=>Yii::app()->user->id);
		$block=Bloqueos::model()->find($criterio);
		if(is_null($block)) {
			$block=New Bloqueos;
			$block->codocu=$codigodoc;
			$block->iduser=Yii::app()->user->id;
			$block->fechabloqueo=date("Y-m-d H:i:s");
			$block->iddocu=$id;
			$block->ip=Yii::app()->request->userHostAddress;
			if(!$block->save()){
				throw new CHttpException(500,' no se grabo el blqouoe');

				return true;
			} else {
				return false;  /// nos epudo bloquear;
			}
		} else {
			return false;  /// ya esta blqoeuado
		}
	}


	public static function estasensesion($id,$codigodoc){
		$criterio=New CDbCriteria;
		$criterio->addcondition(" codocu=:vdocu AND iddocu=:vid AND iduser =:vusuario ");
		$criterio->params=array(":vdocu"=>$codigodoc,":vid"=>$id, ":vusuario"=>Yii::app()->user->id);
		$block=Bloqueos::model()->find($criterio);
		if(!is_null($block)) {
			if ( ( time () - strtotime ( $block->fechabloqueo . '' ) ) >
				Yii::app ()->user->um->getDefaultSystem ()->getn ( 'sessionmaxdurationmins' ) * 60 )
			{
			 	$block->delete();
				return false;
				}else {
               return true;
			}


		} else {
			return false;  /// NO hay blqieo esta libre no hay sesion
		}
	}


	public static function establoqueado($id,$codigodoc)	{

		$criterio=New CDbCriteria;
		$criterio->addcondition(" codocu=:vdocu AND iddocu=:vid AND iduser = :vusuario");
		$criterio->params=array(":vdocu"=>$codigodoc,":vid"=>$id, ":vusuario"=>Yii::app()->user->id);
		$block=Bloqueos::model()->find($criterio);
		if(!is_null($block)) { ///Tendremos que revisar la sesion del usuario que esta ocupando
			$elusuario=Yii::app()->user->um->LoadUserById($block->iduser);
			///hallando la sesion activa de este usuario
			$sesion_activa=Yii::app()->user->um->findSession($elusuario);
			if(is_null($sesion_activa)) {
				return null;
			}  else {
				return $block;
				//echo "  Estaa cupado por el usuario ".$elusuario->username;  ///Si esta ocupado por que el usuario tiene sesion activa, y eszta editando
			}

		} else {
			return null;
		}
	}

	public static function clearbloqueos()	{
		//Verifcando primero aquellos bloqueos cuya fecha de bloqueo es mayor que
		//laduracion dela sesion

		$fechalimite=date("Y-m-d H:i:s",
			time()-yii::app()->user->um->getDefaultSystem()->getn('sessionmaxdurationmins')*60-10);
		$criterio=New CDbCriteria;
		$criterio->addcondition(" fechabloqueo < :fechalimite ");
		$criterio->params=array(":fechalimite"=>$fechalimite);
/*	echo "fecha actual ".date("Y-m-d H:i:s")."<br>";
		echo  "fechalimite  ".	$fechalimite."<br>";*/
		$filasborradas=Yii::app()->db->createCommand()->delete(self::tableName(),$criterio->condition,$criterio->params);
		/*var_dump($criterio);*/
		return $filasborradas;




	}

	public static function desbloquea($id,$codigodoc)	{

		$criterio=New CDbCriteria;
		$criterio->addcondition(" codocu=:vdocu AND iddocu=:vid AND iduser =:vusuario ");
		$criterio->params=array(":vdocu"=>$codigodoc,":vid"=>$id, ":vusuario"=>Yii::app()->user->id);
		$block=Bloqueos::model()->find($criterio);
		if(!is_null($block)) {

			if($block->delete()){
				return true;
			} else {
				return false;  /// nos epudo bloquear;
			}
		} else {
			return true;  /// NO hay blqieo esta linre
		}
	}

	//no usar esta funcion dentro de una transaccion

	public static function estaocupado($id,$codigodoc)	{

		self::clearbloqueos();
		//Listo

		$criterio=New CDbCriteria;
		$criterio->addcondition(" codocu=:vdocu AND iddocu=:vid AND iduser <>:vusuario ");
		$criterio->params=array(":vdocu"=>$codigodoc,":vid"=>$id, ":vusuario"=>Yii::app()->user->id);
		$blockes=self::model()->findAll($criterio);
		if(count($blockes)>0) {

				return $blockes[0]->iduser;

			}else {
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('fechabloqueo',$this->fechabloqueo,true);
		$criteria->compare('iddocu',$this->iddocu,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('idsesion',$this->idsesion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_por_usuario($iduser)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->addcondition("iduser=:viduser");
		$criteria->params=array(":viduser"=>$iduser);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 1000,
			)
		));
	}



	public static function conteo($iduser){
		$iduser=(int)MiFactoria::cleanInput($iduser);
		$numerobloqueos=Yii::app()->db->createCommand()
			->select('count(a.id)')
			->from('{{bloqueos}} a ')
			->where('a.iduser=:viduser ',array(":viduser"=>$iduser))
			->queryScalar();
		if($numerobloqueos!=false){
			return $numerobloqueos;
		}else{
			 return 0;
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Bloqueos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
