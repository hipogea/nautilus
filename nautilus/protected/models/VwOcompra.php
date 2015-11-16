<?php

/**
 * This is the model class for table "vw_ocompra".
 *
 * The followings are the available columns in table 'vw_ocompra':
 * @property string $numcot
 * @property string $codpro
 * @property string $fecdoc
 * @property string $codcon
 * @property string $codestado
 * @property string $texto
 * @property string $textolargo
 * @property string $tipologia
 * @property string $moneda
 * @property string $orcli
 * @property integer $descuento
 * @property string $usuario
 * @property string $coddocu
 * @property string $creado
 * @property string $modificado
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property string $codtipofac
 * @property string $codsociedad
 * @property string $codgrupoventas
 * @property string $codtipocotizacion
 * @property integer $validez
 * @property string $codcentro
 * @property double $nigv
 * @property string $codobjeto
 * @property string $fechapresentacion
 * @property string $fechanominal
 * @property integer $idguia
 * @property string $desmon
 * @property string $tipofacturacion
 * @property string $estado
 * @property string $rucsoc
 * @property string $dsocio
 * @property string $c_nombre
 * @property string $simbolo
 * @property string $c_cargo
 * @property string $despro
 * @property string $rucpro
 * @property string $emailpro
 * @property string $desdocu
 * @property string $textocabeza
 * @property string $textopie
 * @property integer $id
 * @property string $codart
 * @property string $disp
 * @property double $cant
 * @property double $punit
 * @property string $item
 * @property string $descri
 * @property double $stock
 * @property string $detalle
 * @property string $tipoitem
 * @property string $estadodetalle
 * @property string $um
 * @property string $hidguia
 * @property string $codservicio
 */
class VwOcompra extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwOcompra the static model class
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
		return 'vw_ocompra';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descuento, validez, idguia, id', 'numerical', 'integerOnly'=>true),
			array('nigv, cant, punit, stock', 'numerical'),
			array('numcot, codart', 'length', 'max'=>8),
			array('codpro, codservicio', 'length', 'max'=>6),
			array('codcon', 'length', 'max'=>5),
			array('codestado, codtipofac, disp, estadodetalle', 'length', 'max'=>2),
			array('texto, dsocio, descri', 'length', 'max'=>40),
			array('tipologia, codsociedad, codtipocotizacion, tipoitem', 'length', 'max'=>1),
			array('moneda, coddocu, codgrupoventas, codobjeto, simbolo, item, um', 'length', 'max'=>3),
			array('orcli', 'length', 'max'=>12),
			array('usuario, tipofacturacion', 'length', 'max'=>35),
			array('creado, modificado, creadoel, modificadoel', 'length', 'max'=>20),
			array('creadopor, modificadopor, estado', 'length', 'max'=>25),
			array('codcentro', 'length', 'max'=>4),
			array('desmon', 'length', 'max'=>10),
			array('rucsoc, rucpro', 'length', 'max'=>11),
			array('c_nombre, c_cargo', 'length', 'max'=>30),
			array('despro', 'length', 'max'=>50),
			array('emailpro', 'length', 'max'=>60),
			array('desdocu', 'length', 'max'=>45),
			array('fecdoc, textolargo, fechapresentacion, fechanominal, textocabeza, textopie, detalle, hidguia', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('numcot, codpro, fecdoc,fecdoc1, codcon, codestado,codentro,codigoalma, texto, textolargo, tipologia, moneda, orcli, descuento, usuario, coddocu, creado, modificado, creadopor, creadoel, modificadopor, modificadoel, codtipofac, codsociedad, codgrupoventas, codtipocotizacion, validez, codcentro, nigv, codobjeto, fechapresentacion, fechanominal, idguia, desmon, tipofacturacion, estado, rucsoc, dsocio, c_nombre, simbolo, c_cargo, despro, rucpro, emailpro, desdocu, textocabeza, textopie, id, codart, disp, cant, punit, item, descri, stock, detalle, tipoitem, estadodetalle, um, hidguia, codservicio', 'safe', 'on'=>'search'),
		);
	}

public $fecdoc1;
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
			'numcot' => 'Numero',
			'codpro' => 'Cod',
			'fecdoc' => 'Fecha Cr',
			'codcon' => 'Cod Cont',
			'codestado' => 'Codestado',
			'texto' => 'Descrip',
			'textolargo' => 'Textolargo',
			'tipologia' => 'Tipo',
			'moneda' => 'Moneda',
			'orcli' => 'Orden Prov',
			'descuento' => 'Descuento',
			'usuario' => 'Usuario',
			'coddocu' => 'Cod Doc',
			'creado' => 'Creado',
			'modificado' => 'Modificado',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'codtipofac' => 'Codtipofac',
			'codsociedad' => 'Codsociedad',
			'codgrupoventas' => 'Codgrupoventas',
			'codtipocotizacion' => 'Codtipocotizacion',
			'validez' => 'Validez',
			'codcentro' => 'Centro',
			'nigv' => 'Nigv',
			'codobjeto' => 'Codobjeto',
			'fechapresentacion' => 'Fecha Presentacion',
			'fechanominal' => 'Fecha Doc',
			'idguia' => 'Idguia',
			'desmon' => 'Moneda',
			'tipofacturacion' => 'Tipofacturacion',
			'estado' => 'Estado',
			'rucsoc' => 'Rucsoc',
			'dsocio' => 'Dsocio',
			'c_nombre' => 'C Nombre',
			'simbolo' => 'Simbolo',
			'c_cargo' => 'C Cargo',
			'despro' => 'Despro',
			'rucpro' => 'Rucpro',
			'emailpro' => 'Emailpro',
			'desdocu' => 'Desdocu',
			'textocabeza' => 'Textocabeza',
			'textopie' => 'Textopie',
			'id' => 'ID',
			'codart' => 'Codart',
			'disp' => 'Disp',
			'cant' => 'Cant',
			'punit' => 'Punit',
			'item' => 'Item',
			'descri' => 'Descri',
			'stock' => 'Stock',
			'detalle' => 'Detalle',
			'tipoitem' => 'Tipoitem',
			'estadodetalle' => 'Estadodetalle',
			'um' => 'Um',
			'hidguia' => 'Hidguia',
			'codservicio' => 'Codservicio',
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

		$criteria->compare('numcot',$this->numcot,true);
		$criteria->compare('codpro',$this->codpro,true);
		$criteria->compare('codentro',$this->codentro,true);
		$criteria->compare('codigoalma',$this->codigoalma,true);
		//$criteria->compare('fecdoc',$this->fecdoc,true);
		$criteria->compare('codcon',$this->codcon,true);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('texto',$this->texto,true);
		$criteria->compare('textolargo',$this->textolargo,true);
		$criteria->compare('tipologia',$this->tipologia,true);
		$criteria->compare('moneda',$this->moneda,true);
		$criteria->compare('orcli',$this->orcli,true);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('codtipofac',$this->codtipofac,true);
		$criteria->compare('codsociedad',$this->codsociedad,true);
		$criteria->compare('codgrupoventas',$this->codgrupoventas,true);
		$criteria->compare('codtipocotizacion',$this->codtipocotizacion,true);
		$criteria->compare('validez',$this->validez);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('nigv',$this->nigv);
		$criteria->compare('codobjeto',$this->codobjeto,true);
		$criteria->compare('fechapresentacion',$this->fechapresentacion,true);
		$criteria->compare('fechanominal',$this->fechanominal,true);
		$criteria->compare('idguia',$this->idguia);
		$criteria->compare('desmon',$this->desmon,true);
		$criteria->compare('tipofacturacion',$this->tipofacturacion,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('rucsoc',$this->rucsoc,true);
		$criteria->compare('dsocio',$this->dsocio,true);
		$criteria->compare('c_nombre',$this->c_nombre,true);
		$criteria->compare('simbolo',$this->simbolo,true);
		$criteria->compare('c_cargo',$this->c_cargo,true);
		$criteria->compare('despro',$this->despro,true);
		$criteria->compare('rucpro',$this->rucpro,true);
		$criteria->compare('emailpro',$this->emailpro,true);
		$criteria->compare('desdocu',$this->desdocu,true);
		$criteria->compare('textocabeza',$this->textocabeza,true);
		$criteria->compare('textopie',$this->textopie,true);
		$criteria->compare('id',$this->id);
		//$criteria->compare('codart',$this->codart,true);
		$criteria->compare('disp',$this->disp,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('punit',$this->punit);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('descri',$this->descri,true);
		$criteria->compare('stock',$this->stock);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('tipoitem',$this->tipoitem,true);
		$criteria->compare('estadodetalle',$this->estadodetalle,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('hidguia',$this->hidguia,true);
		$criteria->compare('codservicio',$this->codservicio,true);
		if(isset($_SESSION['sesion_Maestrocompo'])) {
			$criteria->addInCondition('codart', $_SESSION['sesion_Maestrocompo'], 'AND');
		} ELSE {
			$criteria->compare('codart',$this->codart,true);
		}
		//$criteria->compare('codocu',$this->codocu,true);
		 if((isset($this->fecdoc) && trim($this->fecdoc) != "") && (isset($this->fecdoc1) && trim($this->fecdoc1) != ""))  {
		             //  $limite1=date("Y-m-d",strotime($this->d_fectra)-24*60*60); //UN DIA MENOS 
					 //  $limite2=date("Y-m-d",strotime($this->d_fectra)+24*60*60); //UN DIA mas 
		 
                        $criteria->addBetweenCondition('fecdoc', ''.$this->fecdoc.'', ''.$this->fecdoc1.'');
						
						}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function search2()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('numcot',$this->numcot,true);
		$criteria->compare('codpro',$this->codpro,true);
		//$criteria->compare('fecdoc',$this->fecdoc,true);
		$criteria->compare('codcon',$this->codcon,true);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('texto',$this->texto,true);
		$criteria->compare('textolargo',$this->textolargo,true);
		$criteria->compare('tipologia',$this->tipologia,true);
		$criteria->compare('moneda',$this->moneda,true);
		$criteria->compare('orcli',$this->orcli,true);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('codtipofac',$this->codtipofac,true);
		$criteria->compare('codsociedad',$this->codsociedad,true);
		$criteria->compare('codgrupoventas',$this->codgrupoventas,true);
		$criteria->compare('codtipocotizacion',$this->codtipocotizacion,true);
		$criteria->compare('validez',$this->validez);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('nigv',$this->nigv);
		$criteria->compare('codobjeto',$this->codobjeto,true);
		$criteria->compare('fechapresentacion',$this->fechapresentacion,true);
		$criteria->compare('fechanominal',$this->fechanominal,true);
		$criteria->compare('idguia',$this->idguia);
		$criteria->compare('desmon',$this->desmon,true);
		$criteria->compare('tipofacturacion',$this->tipofacturacion,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('rucsoc',$this->rucsoc,true);
		$criteria->compare('dsocio',$this->dsocio,true);
		$criteria->compare('c_nombre',$this->c_nombre,true);
		$criteria->compare('simbolo',$this->simbolo,true);
		$criteria->compare('c_cargo',$this->c_cargo,true);
		$criteria->compare('despro',$this->despro,true);
		$criteria->compare('rucpro',$this->rucpro,true);
		$criteria->compare('emailpro',$this->emailpro,true);
		$criteria->compare('desdocu',$this->desdocu,true);
		$criteria->compare('textocabeza',$this->textocabeza,true);
		$criteria->compare('textopie',$this->textopie,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('disp',$this->disp,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('punit',$this->punit);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('descri',$this->descri,true);
		$criteria->compare('stock',$this->stock);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('tipoitem',$this->tipoitem,true);
		$criteria->compare('estadodetalle',$this->estadodetalle,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('hidguia',$this->hidguia,true);
		$criteria->compare('codservicio',$this->codservicio,true);
		//$criteria->compare('codocu',$this->codocu,true);
		 $fechaactual = date("Y-m-d");
		$criteria->addCondition("d_fecdoc = '".$fechaactual."'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));

	}

	public function search_detalle($id) {
		$criteria=new CDbCriteria;
          // $estadoporliberar = '01';
		$criteria->addCondition("idguia = ".$id." ");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));



	}
}




