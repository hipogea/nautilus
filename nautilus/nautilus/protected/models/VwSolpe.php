
<?php

class VwSolpe extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwSolpe the static model class
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
		return 'vw_solpe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'numerical', 'integerOnly'=>true),
			array('cant', 'numerical'),
			array('numero, codart, numsolpe', 'length', 'max'=>10),
			array('posicion, centro, grupocompras', 'length', 'max'=>4),
			array('tipimputacion, estadolib, tipsolpe', 'length', 'max'=>1),
			array('codal, codocu, um, item', 'length', 'max'=>3),
			array('txtmaterial', 'length', 'max'=>40),
			array('usuario, modificado', 'length', 'max'=>30),
			array('imputacion', 'length', 'max'=>12),
			array('solicitanet', 'length', 'max'=>6),
			array('creado, creadopor, modificadopor', 'length', 'max'=>25),
			array('creadoel, modificadoel', 'length', 'max'=>20),
			array('est', 'length', 'max'=>2),
			array('textodetalle, fechacrea, fechaent, fechalib, hidsolpe,estado', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('numero,escompra, posicion, identidad,tipimputacion, centro, fechacrea1,fechaent1, codal, codart, txtmaterial, grupocompras, usuario, modificado, textodetalle, fechacrea, fechaent, fechalib, estadolib, imputacion, solicitanet, hidsolpe, creado, creadopor, creadoel, modificadopor, modificadoel, id, codocu, um, tipsolpe, est, cant, item, numsolpe', 'safe', 'on'=>'search'),
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


	public $fechaent1;
	public $fechacrea1;
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fechaent1' => '',
			'fechacrea1' => '',
			'numero' => 'Numero',
			'posicion' => 'Posicion',
			'tipimputacion' => 'Imputacion',
			'centro' => 'Centro',
			'codal' => 'Almac',
            'escompra'=>'Abastec',
			'codart' => 'Cod',
			'txtmaterial' => 'Descripcion',
			'grupocompras' => 'Gr Comp',
			'desum'=>'Um',
			'usuario' => 'Usuario',
			'modificado' => 'Modificado',
			'textodetalle' => 'Texto detalle',
			'fechacrea' => 'Fec Crea',
			'fechaent' => 'Fec Prog',
			'fechalib' => 'Fecha Aut.',
			'estadolib' => 'Est',
			'imputacion' => 'Imput',
			'solicitanet' => 'Solicitante',
			'hidsolpe' => 'Hidsolpe',
			'creado' => 'Creado',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'id' => 'ID',
			'codocu' => 'Docum',
			'um' => 'Um',
			'tipsolpe' => 'Tipo',
			'est' => 'Estado',
			'cant' => 'Cant',
			'item' => 'Item',
			'numsolpe' => 'Numero',
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

		//$criteria->compare('numero',$this->numero,true);
		$criteria->compare('posicion',$this->posicion,true);
		$criteria->compare('tipimputacion',$this->tipimputacion,true);
		$criteria->compare('centro',$this->centro,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('codal',$this->codal,true);
		$criteria->compare('codart',trim($this->codart),true);
		//$criteria->compare('txtmaterial',$this->txtmaterial,true);
		$criteria->compare('grupocompras',$this->grupocompras,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('textodetalle',$this->textodetalle,true);
		//$criteria->compare('fechacrea',$this->fechacrea,true);
		//$criteria->compare('fechaent',$this->fechaent,true);
		$criteria->compare('fechalib',$this->fechalib,true);
		$criteria->compare('estadolib',$this->estadolib,true);
		$criteria->compare('imputacion',$this->imputacion,true);
		$criteria->compare('solicitanet',$this->solicitanet,true);
		$criteria->compare('hidsolpe',$this->hidsolpe,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('tipsolpe',$this->tipsolpe,true);
		$criteria->compare('est',$this->est,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('item',$this->item,true);
        $criteria->compare('escompra',$this->escompra,true);
		$criteria->compare('numsolpe',$this->numsolpe,true);
		$criteria->addcondition("numsolpe IS NOT NULL" );
		$criteria->addcondition(" txtmaterial like '%".$this->txtmaterial."%' ");
		// if((isset($this->fecdoc) && trim($this->fecdoc) != "") && (isset($this->fecdoc1) && trim($this->fecdoc1) != ""))  {
		             //  $limite1=date("Y-m-d",strotime($this->d_fectra)-24*60*60); //UN DIA MENOS 
					 //  $limite2=date("Y-m-d",strotime($this->d_fectra)+24*60*60); //UN DIA mas 
		 
                        $criteria->addBetweenCondition('fechaent', ''.$this->fechaent.'', ''.$this->fechaent1.''); 
                          $criteria->addBetweenCondition('fechacrea', ''.$this->fechacrea.'', ''.$this->fechacrea1.''); 
						
					///	}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
                'pageSize' => 30,
            ),
		));
	}


    public function search_compras()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('numero',$this->numero,true);
        $criteria->compare('posicion',$this->posicion,true);
        $criteria->compare('tipimputacion',$this->tipimputacion,true);
        $criteria->compare('centro',$this->centro,true);
        $criteria->compare('codal',$this->codal,true);
		$criteria->compare('estado',$this->estado,true);
        $criteria->compare('codart',trim($this->codart),true);
        $criteria->compare('txtmaterial',$this->txtmaterial,true);
        $criteria->compare('grupocompras',$this->grupocompras,true);
        $criteria->compare('usuario',$this->usuario,true);
        $criteria->compare('modificado',$this->modificado,true);
        $criteria->compare('textodetalle',$this->textodetalle,true);
        //$criteria->compare('fechacrea',$this->fechacrea,true);
        //$criteria->compare('fechaent',$this->fechaent,true);
        $criteria->compare('fechalib',$this->fechalib,true);
        $criteria->compare('estadolib',$this->estadolib,true);
        $criteria->compare('imputacion',$this->imputacion,true);
        $criteria->compare('solicitanet',$this->solicitanet,true);
        $criteria->compare('hidsolpe',$this->hidsolpe,true);
        $criteria->compare('creado',$this->creado,true);
        $criteria->compare('creadopor',$this->creadopor,true);
        $criteria->compare('creadoel',$this->creadoel,true);

        $criteria->compare('modificadopor',$this->modificadopor,true);
        $criteria->compare('modificadoel',$this->modificadoel,true);
        $criteria->compare('id',$this->id);
        $criteria->compare('codocu',$this->codocu,true);
        $criteria->compare('um',$this->um,true);
        $criteria->compare('tipsolpe',$this->tipsolpe,true);
        $criteria->compare('est',$this->est,true);
        $criteria->compare('cant',$this->cant);
        $criteria->compare('item',$this->item,true);
        $criteria->compare('numsolpe',$this->numsolpe,true);
        $criteria->addcondition("numsolpe IS NOT NULL" );
        $criteria->addcondition("escompra='1'" );
        $criteria->addcondition("est in ('30','50') " );
        // if((isset($this->fecdoc) && trim($this->fecdoc) != "") && (isset($this->fecdoc1) && trim($this->fecdoc1) != ""))  {
        //  $limite1=date("Y-m-d",strotime($this->d_fectra)-24*60*60); //UN DIA MENOS
        //  $limite2=date("Y-m-d",strotime($this->d_fectra)+24*60*60); //UN DIA mas

        $criteria->addBetweenCondition('fechaent', ''.$this->fechaent.'', ''.$this->fechaent1.'');
        $criteria->addBetweenCondition('fechacrea', ''.$this->fechacrea.'', ''.$this->fechacrea1.'');

        ///	}

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }



		public function searchliberacion()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		
		
                       // $criteria->addBetweenCondition('fechaent', ''.$this->fechaent.'', ''.$this->fechaent1.''); 
                         $criteria->addCondition("est='10'");
						
					///	}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 200,
			),
		));
	}


		public function searchAtencion()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		
		
                       // $criteria->addBetweenCondition('fechaent', ''.$this->fechaent.'', ''.$this->fechaent1.''); 
                         $criteria->addCondition("est='30'");
						
					///	}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}