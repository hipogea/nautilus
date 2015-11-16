<?php

/**
 * This is the model class for table "vw_costos".
 *
 * The followings are the available columns in table 'vw_costos':
 * @property integer $id
 * @property string $ceco
 * @property string $fechacontable
 * @property double $monto
 * @property string $codmoneda
 * @property string $usuario
 * @property string $idref
 * @property string $tipo
 * @property string $creadoel
 * @property string $ano
 * @property string $mes
 * @property string $clasecolector
 * @property integer $iduser
 * @property string $numvale
 * @property string $codart
 * @property string $codmov
 * @property string $valido
 * @property string $destino
 * @property string $checki
 * @property double $cant
 * @property string $alemi
 * @property string $aldes
 * @property string $fecha
 * @property string $coddoc
 * @property string $numdoc
 * @property string $um
 * @property string $comentario
 * @property string $codocuref
 * @property string $numdocref
 * @property string $codcentro
 * @property string $idkardex
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
class VwCostos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_costos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ano, mes, clasecolector, iduser', 'required'),
			array('id, iduser', 'numerical', 'integerOnly'=>true),
			array('monto, cant', 'numerical'),
			array('ceco, numvale, correlativo', 'length', 'max'=>12),
			array('codmoneda, alemi, aldes, coddoc, um, codocuref', 'length', 'max'=>3),
			array('usuario', 'length', 'max'=>25),
			array('idref, destino, comentario, idkardex, hidvale, desum', 'length', 'max'=>20),
			array('tipo, clasecolector, valido, checki', 'length', 'max'=>1),
			array('creadoel, fecha, fechadoc', 'length', 'max'=>19),
			array('ano, codcentro', 'length', 'max'=>4),
			array('mes, codmov, codestado, prefijo', 'length', 'max'=>2),
			array('codart', 'length', 'max'=>10),
			array('numdoc, numdocref', 'length', 'max'=>15),
			array('numkardex', 'length', 'max'=>14),
			array('solicitante', 'length', 'max'=>18),
			array('descripcion', 'length', 'max'=>60),
			array('desdocu', 'length', 'max'=>45),
			array('movimiento', 'length', 'max'=>35),
			array('fechacontable', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ceco, fechacontable, monto, codmoneda, usuario, idref, tipo, creadoel, ano, mes, clasecolector, iduser, numvale, codart, codmov, valido, destino, checki, cant, alemi, aldes, fecha, coddoc, numdoc, um, comentario, codocuref, numdocref, codcentro, idkardex, codestado, prefijo, fechadoc, correlativo, numkardex, solicitante, hidvale, descripcion, desdocu, movimiento, desum', 'safe', 'on'=>'search'),
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
			'ceco' => 'Ceco',
			'fechacontable' => 'Fechacontable',
			'monto' => 'Monto',
			'codmoneda' => 'Codmoneda',
			'usuario' => 'Usuario',
			'idref' => 'Idref',
			'tipo' => 'Tipo',
			'creadoel' => 'Creadoel',
			'ano' => 'Ano',
			'mes' => 'Mes',
			'clasecolector' => 'Clasecolector',
			'iduser' => 'Iduser',
			'numvale' => 'Numvale',
			'codart' => 'Codart',
			'codmov' => 'Codmov',
			'valido' => 'Valido',
			'destino' => 'Destino',
			'checki' => 'Checki',
			'cant' => 'Cant',
			'alemi' => 'Alemi',
			'aldes' => 'Aldes',
			'fecha' => 'Fecha',
			'coddoc' => 'Coddoc',
			'numdoc' => 'Numdoc',
			'um' => 'Um',
			'comentario' => 'Comentario',
			'codocuref' => 'Codocuref',
			'numdocref' => 'Numdocref',
			'codcentro' => 'Codcentro',
			'idkardex' => 'Idkardex',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('ceco',$this->ceco,true);
		$criteria->compare('fechacontable',$this->fechacontable,true);
		$criteria->compare('monto',$this->monto);
		$criteria->compare('codmoneda',$this->codmoneda,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('idref',$this->idref,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('ano',$this->ano,true);
		$criteria->compare('mes',$this->mes,true);
		$criteria->compare('clasecolector',$this->clasecolector,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('numvale',$this->numvale,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('codmov',$this->codmov,true);
		$criteria->compare('valido',$this->valido,true);
		$criteria->compare('destino',$this->destino,true);
		$criteria->compare('checki',$this->checki,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('alemi',$this->alemi,true);
		$criteria->compare('aldes',$this->aldes,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('coddoc',$this->coddoc,true);
		$criteria->compare('numdoc',$this->numdoc,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('codocuref',$this->codocuref,true);
		$criteria->compare('numdocref',$this->numdocref,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('idkardex',$this->idkardex,true);
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
			'pagination' => array(
				'pageSize' => 100,
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VwCostos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
