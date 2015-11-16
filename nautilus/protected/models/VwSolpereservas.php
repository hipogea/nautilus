<?php

/**
 * This is the model class for table "vw_solpereservas".
 *
 * The followings are the available columns in table 'vw_solpereservas':
 * @property integer $identidad
 * @property string $numero
 * @property string $posicion
 * @property string $tipimputacion
 * @property string $centro
 * @property string $codal
 * @property string $codart
 * @property string $txtmaterial
 * @property string $grupocompras
 * @property string $usuariodesolpe
 * @property string $modificado
 * @property string $textodetalle
 * @property string $fechacrea
 * @property string $fechaent
 * @property string $fechalib
 * @property string $estadolib
 * @property string $imputacion
 * @property string $solicitanet
 * @property string $hidsolpe
 * @property string $creado
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property integer $iddesolpe
 * @property string $codocusolpe
 * @property string $um
 * @property string $tipsolpe
 * @property string $est
 * @property double $cantdesolpe
 * @property string $item
 * @property string $numsolpe
 * @property integer $id
 * @property string $hidesolpe
 * @property string $estadoreserva
 * @property string $fechares
 * @property string $usuario
 * @property double $cant
 * @property string $codocu
 * @property integer $numreserva
 * @property string $flag
 * @property string $rex
 * @property string $atendido
 */




class VwSolpereservas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwSolpereservas the static model class
	 */

    public $fechaent1;
    public $fechacrea1;


    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_solpereservas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('identidad, iddesolpe, id, numreserva', 'numerical', 'integerOnly'=>true),
			array('cantdesolpe, cant', 'numerical'),
			array('numero, numsolpe', 'length', 'max'=>10),
			array('posicion, centro, grupocompras', 'length', 'max'=>4),
			array('tipimputacion, estadolib, tipsolpe, flag', 'length', 'max'=>1),
			array('codal, codocusolpe, um, item, codocu', 'length', 'max'=>3),
			array('codart', 'length', 'max'=>8),
			array('txtmaterial', 'length', 'max'=>40),
			array('usuariodesolpe, modificado', 'length', 'max'=>30),
			array('imputacion', 'length', 'max'=>12),
			array('solicitanet', 'length', 'max'=>6),
			array('creado, creadopor, modificadopor, usuario', 'length', 'max'=>25),
			array('creadoel, modificadoel', 'length', 'max'=>20),
			array('est, estadoreserva', 'length', 'max'=>2),
			array('rex', 'length', 'max'=>100),
			array('textodetalle, fechacrea, fechaent, fechalib, hidsolpe, hidesolpe, fechares, atendido', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('identidad, numero, posicion, tipimputacion, centro, codal, codart, txtmaterial, grupocompras, usuariodesolpe, modificado, textodetalle, fechacrea, fechaent, fechalib, estadolib, imputacion, solicitanet, hidsolpe, creado, creadopor, creadoel, modificadopor, modificadoel, iddesolpe, codocusolpe, um, tipsolpe, est, cantdesolpe, item, numsolpe, id, hidesolpe, estadoreserva, fechares, usuario, cant, codocu, numreserva, flag, rex, atendido', 'safe', 'on'=>'search'),
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

            'maestro' => array(self::BELONGS_TO, 'Maestrocompo', 'codart'),
            'cecos' => array(self::BELONGS_TO, 'Cc','imputacion'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'identidad' => 'Identidad',
			'numero' => 'Numero',
			'posicion' => 'Posicion',
			'tipimputacion' => 'Tipimputacion',
			'centro' => 'Centro',
			'codal' => 'Codal',
			'codart' => 'Codart',
			'txtmaterial' => 'Txtmaterial',
			'grupocompras' => 'Grupocompras',
			'usuariodesolpe' => 'Usuariodesolpe',
			'modificado' => 'Modificado',
			'textodetalle' => 'Textodetalle',
			'fechacrea' => 'Fechacrea',
			'fechaent' => 'Fechaent',
			'fechalib' => 'Fechalib',
			'estadolib' => 'Estadolib',
			'imputacion' => 'Imputacion',
			'solicitanet' => 'Solicitanet',
			'hidsolpe' => 'Hidsolpe',
			'creado' => 'Creado',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'iddesolpe' => 'Iddesolpe',
			'codocusolpe' => 'Codocusolpe',
			'um' => 'Um',
			'tipsolpe' => 'Tipsolpe',
			'est' => 'Est',
			'cantdesolpe' => 'Cantdesolpe',
			'item' => 'Item',
			'numsolpe' => 'Numsolpe',
			'id' => 'ID',
			'hidesolpe' => 'Hidesolpe',
			'estadoreserva' => 'Estadoreserva',
			'fechares' => 'Fechares',
			'usuario' => 'Usuario',
			'cant' => 'Cant',
			'codocu' => 'Codocu',
			'numreserva' => 'Numreserva',
			'flag' => 'Flag',
			'rex' => 'Rex',
			'atendido' => 'Atendido',
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

		$criteria->compare('identidad',$this->identidad);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('posicion',$this->posicion,true);
		$criteria->compare('tipimputacion',$this->tipimputacion,true);
		$criteria->compare('centro',$this->centro,true);
		$criteria->compare('codal',$this->codal,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('txtmaterial',$this->txtmaterial,true);
		//$criteria->compare('grupocompras',$this->grupocompras,true);
		$criteria->compare('usuariodesolpe',$this->usuariodesolpe,true);
		$criteria->compare('textodetalle',$this->textodetalle,true);
		$criteria->compare('fechacrea',$this->fechacrea,true);
		$criteria->compare('fechaent',$this->fechaent,true);
		$criteria->compare('imputacion',$this->imputacion,true);
			$criteria->compare('hidsolpe',$this->hidsolpe,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('iddesolpe',$this->iddesolpe);
		$criteria->compare('codocusolpe',$this->codocusolpe,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('tipsolpe',$this->tipsolpe,true);
		$criteria->compare('est',$this->est,true);
		$criteria->compare('cantdesolpe',$this->cantdesolpe);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('numsolpe',$this->numsolpe,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('hidesolpe',$this->hidesolpe,true);
		$criteria->compare('estadoreserva',$this->estadoreserva,true);
		$criteria->compare('fechares',$this->fechares,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('flag',$this->flag,true);
		$criteria->compare('rex',$this->rex,true);
		$criteria->compare('atendido',$this->atendido,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function search_solpe()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('identidad',$this->identidad);
        $criteria->compare('numero',$this->numero,true);
        $criteria->compare('posicion',$this->posicion,true);
        $criteria->compare('tipimputacion',$this->tipimputacion,true);
        $criteria->compare('centro',$this->centro,true);
        $criteria->compare('codal',$this->codal,true);
        $criteria->compare('codart',$this->codart,true);
        $criteria->compare('txtmaterial',$this->txtmaterial,true);
       // $criteria->compare('grupocompras',$this->grupocompras,true);
        $criteria->compare('usuariodesolpe',$this->usuariodesolpe,true);
        $criteria->compare('textodetalle',$this->textodetalle,true);
        $criteria->compare('fechacrea',$this->fechacrea,true);
        $criteria->compare('fechaent',$this->fechaent,true);
        $criteria->compare('imputacion',$this->imputacion,true);
        $criteria->compare('hidsolpe',$this->hidsolpe,true);
        $criteria->compare('iddesolpe',$this->iddesolpe);
        $criteria->compare('codocusolpe',$this->codocusolpe,true);
        $criteria->compare('um',$this->um,true);
        $criteria->compare('tipsolpe',$this->tipsolpe,true);
        $criteria->compare('est',$this->est,true);
        $criteria->compare('cantdesolpe',$this->cantdesolpe);
        $criteria->compare('item',$this->item,true);
        $criteria->compare('numsolpe',$this->numsolpe,true);
        $criteria->compare('id',$this->id);
        $criteria->compare('hidesolpe',$this->hidesolpe,true);
       // $criteria->compare('estadoreserva',$this->estadoreserva,true);
        $criteria->compare('fechares',$this->fechares,true);
        $criteria->compare('usuario',$this->usuario,true);
        $criteria->compare('cant',$this->cant);
       // $criteria->compare('codocu',$this->codocu,true);
        $criteria->compare('flag',$this->flag,true);
        $criteria->compare('rex',$this->rex,true);
        $criteria->compare('atendido',$this->atendido,true);
        $criteria->addCondition( "estadoreserva='10'");

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

}