<?php

/**
 * This is the model class for table "vw_almacendocs".
 *
 * The followings are the available columns in table 'vw_almacendocs':
 * @property string $numvale
 * @property string $codtrabajador
 * @property string $cestadovale
 * @property string $fechacont
 * @property string $fechacre
 * @property string $idvale
 * @property string $textolargo
 * @property string $fechavale
 * @property string $codart
 * @property string $codmov
 * @property string $valido
 * @property string $destino
 * @property string $checki
 * @property double $cant
 * @property string $idref
 * @property string $alemi
 * @property string $aldes
 * @property string $fecha
 * @property string $coddoc
 * @property string $numdoc
 * @property string $usuario
 * @property string $um
 * @property string $comentario
 * @property string $codocuref
 * @property string $numdocref
 * @property string $codcentro
 * @property string $id
 * @property string $codestado
 * @property string $prefijo
 * @property string $fechadoc
 * @property string $correlativo
 * @property string $numkardex
 * @property string $solicitante
 * @property string $hidvale
 * @property string $descripcion
 * @property string $desdocu
 * @property string $movimiento
 * @property string $desum
 */
class VwAlmacendocs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_almacendocs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cant', 'numerical'),
			array('numvale, correlativo', 'length', 'max'=>12),
			array('codtrabajador, codcentro', 'length', 'max'=>4),
			array('cestadovale, codmov, codestado, prefijo', 'length', 'max'=>2),
			array('idvale, destino, idref, comentario, id, hidvale, desum', 'length', 'max'=>20),
			array('codart', 'length', 'max'=>10),
			array('valido, checki', 'length', 'max'=>1),
			array('alemi, aldes, coddoc, um, codocuref', 'length', 'max'=>3),
			array('fecha, fechadoc', 'length', 'max'=>19),
			array('numdoc, numdocref', 'length', 'max'=>15),
			array('usuario', 'length', 'max'=>25),
			array('numkardex', 'length', 'max'=>14),
			array('solicitante', 'length', 'max'=>18),
			array('descripcion', 'length', 'max'=>60),
			array('desdocu', 'length', 'max'=>45),
			array('movimiento', 'length', 'max'=>35),
			array('fechacont, fechacre, textolargo, fechavale', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('numvale, codtrabajador, cestadovale, fechacont, fechacre, idvale, textolargo, fechavale, codart, codmov, valido, destino, checki, cant, idref, alemi, aldes, fecha, coddoc, numdoc, usuario, um, comentario, codocuref, numdocref, codcentro, id, codestado, prefijo, fechadoc, correlativo, numkardex, solicitante, hidvale, descripcion, desdocu, movimiento, desum', 'safe', 'on'=>'search'),
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
			'numvale' => 'Numvale',
			'codtrabajador' => 'Codtrabajador',
			'cestadovale' => 'Cestadovale',
			'fechacont' => 'Fechacont',
			'fechacre' => 'Fechacre',
			'idvale' => 'Idvale',
			'textolargo' => 'Textolargo',
			'fechavale' => 'Fechavale',
			'codart' => 'Codart',
			'codmov' => 'Codmov',
			'valido' => 'Valido',
			'destino' => 'Destino',
			'checki' => 'Checki',
			'cant' => 'Cant',
			'idref' => 'Idref',
			'alemi' => 'Alemi',
			'aldes' => 'Aldes',
			'fecha' => 'Fecha',
			'coddoc' => 'Coddoc',
			'numdoc' => 'Numdoc',
			'usuario' => 'Usuario',
			'um' => 'Um',
			'comentario' => 'Comentario',
			'codocuref' => 'Codocuref',
			'numdocref' => 'Numdocref',
			'codcentro' => 'Codcentro',
			'id' => 'ID',
			'codestado' => 'Codestado',
			'prefijo' => 'Prefijo',
			'fechadoc' => 'Fechadoc',
			'correlativo' => 'Correlativo',
			'numkardex' => 'Numkardex',
			'solicitante' => 'Solicitante',
			'hidvale' => 'Hidvale',
			'descripcion' => 'Descripcion',
			'desdocu' => 'Desdocu',
			'movimiento' => 'Movimiento',
			'desum' => 'Desum',
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

		$criteria->compare('numvale',$this->numvale,true);
		$criteria->compare('codtrabajador',$this->codtrabajador,true);
		$criteria->compare('cestadovale',$this->cestadovale,true);
		$criteria->compare('fechacont',$this->fechacont,true);
		$criteria->compare('fechacre',$this->fechacre,true);
		$criteria->compare('idvale',$this->idvale,true);
		$criteria->compare('textolargo',$this->textolargo,true);
		$criteria->compare('fechavale',$this->fechavale,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('codmov',$this->codmov,true);
		$criteria->compare('valido',$this->valido,true);
		$criteria->compare('destino',$this->destino,true);
		$criteria->compare('checki',$this->checki,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('idref',$this->idref,true);
		$criteria->compare('alemi',$this->alemi,true);
		$criteria->compare('aldes',$this->aldes,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('coddoc',$this->coddoc,true);
		$criteria->compare('numdoc',$this->numdoc,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('codocuref',$this->codocuref,true);
		$criteria->compare('numdocref',$this->numdocref,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('prefijo',$this->prefijo,true);
		$criteria->compare('fechadoc',$this->fechadoc,true);
		$criteria->compare('correlativo',$this->correlativo,true);
		$criteria->compare('numkardex',$this->numkardex,true);
		$criteria->compare('solicitante',$this->solicitante,true);
		$criteria->compare('hidvale',$this->hidvale,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('desdocu',$this->desdocu,true);
		$criteria->compare('movimiento',$this->movimiento,true);
		$criteria->compare('desum',$this->desum,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VwAlmacendocs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
