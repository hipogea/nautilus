<?php

/**
 * This is the model class for table "archivador".
 *
 * The followings are the available columns in table 'archivador':
 * @property integer $id
 * @property string $codocu
 * @property string $desarchivo
 * @property string $obsarchivo
 * @property string $fechasubida
 * @property integer $ndescargas
 * @property string $autor
 * @property string $nombre
 * @property double $peso
 */
class Archivador extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Archivador the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	
	
	public $archivo;
	public $documentos_documento;
	//public $extension;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{archivador}}';
	}

	
	public function verifica()
	{
	 $tamanomaximo=1800;
	 if (!empty($this->archivo)) {
	     //$extension=strtoupper($this->archivo->getExtensionName());
		 if (strpos("JPG,JPEG,DOC,DOCX,XLS,XLSX,PDF,ZIP,RAR,DLL,BMP,GIF,PNG,MDB,MDBX,PPT,PPS,PPTX",
							strtoupper($this->archivo->getExtensionName()))==false
								)
			{
					return "No esta permitido subir este tipo de archivos"; 
			} elseif ($this->archivo->getSize() > 1024*$tamanomaximo)
			{
			   return "El tama�o excede a los ".$tamanomaximo." KB ";
			} elseif ($this->archivo->getHasError())
			{
			  return "";
			  return "Hubo un error al momento de subir el archivo, verifique";
			}else {
			  return "";
			}
		 
		 
	      
	  }else {
	    return "No se pudo cargar el archivo o no selecciono nada ";
	  }
	
	
		
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ndescargas', 'numerical', 'integerOnly'=>true),
			array('peso', 'numerical'),
			array('codocu', 'length', 'max'=>3),
			array('desarchivo, autor, nombre', 'length', 'max'=>40),
			array('obsarchivo,archivo, fechasubida', 'safe'),
			array('codocu','required','message'=>'Llena el tipo de Documento','on'=>'insert,update'),
			array('nombre','required','message'=>'Tienes que colocarle un nombre al archivo','on'=>'insert,update'),
			array('desarchivo','required','message'=>'Indica una descripcion corta','on'=>'insert,update'),
			array('archivo','required','message'=>'Seleciona el archivo','on'=>'insert'),
			
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id,extension, codocu,documentos_documento, desarchivo, archivo,obsarchivo, fechasubida, ndescargas, autor, nombre, peso', 'safe', 'on'=>'search'),
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
		'documento'=>array(self::BELONGS_TO, 'Documentos', 'codocu'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codocu' => 'Clase',
			'nombre' => 'Nombre de archivo',
			'desarchivo' => 'Descripcion del archivo',
			//'obsarchivo' => 'Obsarchivo',
			'fechasubida' => 'Fecha de subida',
			'ndescargas' => 'Numero de descargas',
			'autor' => 'Autor ',			
			'peso' => 'Tamano (KB)',
		);
	}

	public function beforeSave() {
							if ($this->isNewRecord) {
									
									$this->autor=Yii::app()->user->name;
									$this->peso=ROUND($this->archivo->getSize()/1024,2);
									$this->fechasubida="".date("Y-m-d")."";
									$this->extension=".".$this->archivo->getExtensionName();
									$this->ndescargas=0;
									//$this->descridetalle=" ".date("H:i")." -->".$this->descridetalle;
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

		$criteria->compare('id',$this->id);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('desarchivo',$this->desarchivo,true);
		$criteria->compare('obsarchivo',$this->obsarchivo,true);
		$criteria->compare('fechasubida',$this->fechasubida,true);
		$criteria->compare('ndescargas',$this->ndescargas);
		$criteria->compare('autor',$this->autor,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('peso',$this->peso);

		$criteria->together  =  true;
		$criteria->with = array('documento');
		 if($this->documentos_documento){
				$criteria->compare('documentos.desdocu',$this->documentos_documento,true);
			}
				$sort=new CSort;
				$sort->attributes=array(
										'coddocu',
									// For each relational attribute, create a 'virtual attribute' using the public variable name
										'documentos_documento' => array(
																	'asc' => 'documento.desdocu  ASC',
																	'desc' => 'documento.desdocu DESC ',
																	'label' => 'documentos',
																	),
										'*',
										);
		
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'sort'=>$sort,'pagination' => array(
                'pageSize' => 15,
            ),
		));
		
		
		
		
	}
}