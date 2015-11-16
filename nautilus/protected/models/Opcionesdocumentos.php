<?php

/**
 * This is the model class for table "opcionesdocumentos".
 *
 * The followings are the available columns in table 'opcionesdocumentos':
 * @property integer $id
 * @property string $usuario
 * @property string $codparam
 * @property string $valor
 * @property string $tipodato
 * @property string $seleccionador
 * @property string $codocu
 * @property string $idusuario
 * @property string $nombrecampo
 * @property string $nombretabla
 *
 * The followings are the available model relations:
 * @property CrugeUser $idusuario0
 * @property Documentos $codocu0
 */
class Opcionesdocumentos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Opcionesdocumentos the static model class
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
		return Yii::app()->params['prefijo'].'opcionesdocumentos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario, valor', 'length', 'max'=>40),
			array('codparam', 'length', 'max'=>5),
			array('tipodato', 'length', 'max'=>1),
			array('seleccionador, codocu', 'length', 'max'=>3),
			array('nombrecampo, nombretabla', 'length', 'max'=>30),
			array('idusuario', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, usuario, codparam, valor, tipodato, seleccionador, codocu, idusuario, nombrecampo, nombretabla', 'safe', 'on'=>'search'),
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
			'idusuario0' => array(self::BELONGS_TO, 'CrugeUser', 'idusuario'),
			'codocu0' => array(self::BELONGS_TO, 'Documentos', 'codocu'),
			'param'=> array(self::BELONGS_TO, 'Opcionescamposdocu', 'idopdoc'),
			
		);
	}



    public function FileReceptor($fullFileName,$userdata) {
        // userdata is the same passed via widget config.
        $path_parts = pathinfo($fullFileName);
        if (rename($fullFileName,$path_parts['dirname'].DIRECTORY_SEPARATOR.$userdata.'.'.$path_parts['extension'] )) {
            $ruta_imagen = $fullFileName;
            $miniatura_ancho_maximo = 200;
            $miniatura_alto_maximo = 200;
            $info_imagen = getimagesize('logos'.DIRECTORY_SEPARATOR.$userdata.'.'.$path_parts['extension']);
            $imagen_ancho = $info_imagen[0];
            $imagen_alto = $info_imagen[1];
            $imagen_tipo = $info_imagen['mime'];
            $proporcion_imagen = $imagen_ancho / $imagen_alto;
            $proporcion_miniatura = $miniatura_ancho_maximo / $miniatura_alto_maximo;
            if ( $proporcion_imagen > $proporcion_miniatura ){
                $miniatura_ancho = $miniatura_ancho_maximo;
                $miniatura_alto = $miniatura_ancho_maximo / $proporcion_imagen;
            } else if ( $proporcion_imagen < $proporcion_miniatura ){
                $miniatura_ancho = $miniatura_ancho_maximo * $proporcion_imagen;
                $miniatura_alto = $miniatura_alto_maximo;
            } else {
                $miniatura_ancho = $miniatura_ancho_maximo;
                $miniatura_alto = $miniatura_alto_maximo;
            }
            switch ( $imagen_tipo ){
                case "image/jpg":
                case "image/jpeg":
                   // $imagen = imagecreatefromjpeg(yii::app()->basepath.DIRECTORY_SEPARATOR.'materiales'.DIRECTORY_SEPARATOR.$userdata.'.'.$path_parts['extension'] );
				$imagen = imagecreatefromjpeg('logos'.DIRECTORY_SEPARATOR.$userdata.'.'.$path_parts['extension'] );
                    break;
                case "image/png":
                    $imagen = imagecreatefrompng('logos'.DIRECTORY_SEPARATOR.$userdata.'.'.$path_parts['extension'] );
                    break;
                case "image/gif":
                    $imagen = imagecreatefromgif( 'logos'.DIRECTORY_SEPARATOR.$userdata.'.'.$path_parts['extension'] );
                    break;
            }
            $lienzo = imagecreatetruecolor( $miniatura_ancho, $miniatura_alto );
            imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $miniatura_ancho, $miniatura_alto, $imagen_ancho, $imagen_alto);
            imagejpeg($lienzo, 'logos'.DIRECTORY_SEPARATOR.$userdata.'.'.STRTOUPPER($path_parts['extension']), 50);
        } else {
        }
    }




    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usuario' => 'Usuario',
			'codparam' => 'Codparam',
			'valor' => 'Valor',
			'tipodato' => 'Tipodato',
			'seleccionador' => 'Seleccionador',
			'codocu' => 'Codocu',
			'idusuario' => 'Idusuario',
			'nombrecampo' => 'Nombrecampo',
			'nombretabla' => 'Nombretabla',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	
	public function search_d($docu)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('codparam',$this->codparam,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('tipodato',$this->tipodato,true);
		$criteria->compare('seleccionador',$this->seleccionador,true);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('idusuario',$this->idusuario,true);
		$criteria->compare('nombrecampo',$this->nombrecampo,true);
		$criteria->compare('nombretabla',$this->nombretabla,true);
		$criteria->addCondition(" codocu='".$docu."' ");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('codparam',$this->codparam,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('tipodato',$this->tipodato,true);
		$criteria->compare('seleccionador',$this->seleccionador,true);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('idusuario',$this->idusuario,true);
		$criteria->compare('nombrecampo',$this->nombrecampo,true);
		$criteria->compare('nombretabla',$this->nombretabla,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}