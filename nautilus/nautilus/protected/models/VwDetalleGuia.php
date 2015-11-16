<?php
class VwDetalleGuia extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwDetalleGuia the static model class
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
		return 'vw_detalle_guia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('n_cangui', 'numerical'),
			array('c_itguia, c_um, c_codep', 'length', 'max'=>3),
			array('c_codgui', 'length', 'max'=>8),
			array('c_edgui, c_estado', 'length', 'max'=>2),
			array('c_descri', 'length', 'max'=>40),
			array('c_codactivo', 'length', 'max'=>13),
			array('c_codsap', 'length', 'max'=>5),
			array('nomep, estado', 'length', 'max'=>25),
			array('n_hguia, n_detgui', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('n_hguia, c_itguia, n_cangui, c_codgui, c_edgui, c_descri, c_um, c_codep, n_detgui, c_estado, c_codactivo, c_codsap, nomep, estado', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'n_hguia' => 'N Hguia',
			'c_itguia' => 'Item',
			'n_cangui' => 'Cant.',
			'c_codgui' => 'Cod.',
			'c_edgui' => 'C Edgui',
			'c_descri' => 'Descripcion',
			'c_um' => 'Um',
			'c_codep' => 'Ref',
			'n_detgui' => 'N Detgui',
			'c_estado' => 'C Estado',
			'c_codactivo' => 'Activo',
			'c_codsap' => 'C Codsap',
			'nomep' => 'Refer.',
			'estado' => 'Estado',
		);
	}

	
	 public function search_por_guia($idcabecera)
	 {	$criteria=new CDbCriteria;
		$criteria->compare('n_hguia',$this->n_hguia,true);
		$criteria->compare('c_itguia',$this->c_itguia,true);
		$criteria->compare('n_cangui',$this->n_cangui);
		$criteria->compare('c_codgui',$this->c_codgui,true);
		$criteria->compare('c_edgui',$this->c_edgui,true);
		$criteria->compare('c_descri',$this->c_descri,true);
		$criteria->compare('c_um',$this->c_um,true);
		$criteria->compare('c_codep',$this->c_codep,true);
		//$criteria->compare('n_detgui',$this->n_detgui,true);
		$criteria->compare('c_estado',$this->c_estado,true);
		$criteria->compare('c_codactivo',$this->c_codactivo,true);
		$criteria->compare('c_codsap',$this->c_codsap,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->addCondition("n_hguia = ".($idcabecera+0)."  ");
	/*	if(Yii::app()->params['veranulados']=='0') //si no  permite ver anulados entoncees filtrar
			$criteria->addCondition( " C_ESTADO <> '04'");*/
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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

		$criteria->compare('n_hguia',$this->n_hguia,true);
		$criteria->compare('c_itguia',$this->c_itguia,true);
		$criteria->compare('n_cangui',$this->n_cangui);
		$criteria->compare('c_codgui',$this->c_codgui,true);
		$criteria->compare('c_edgui',$this->c_edgui,true);
		$criteria->compare('c_descri',$this->c_descri,true);
		$criteria->compare('c_um',$this->c_um,true);
		$criteria->compare('c_codep',$this->c_codep,true);
		//$criteria->compare('n_detgui',$this->n_detgui,true);
		$criteria->compare('c_estado',$this->c_estado,true);
		$criteria->compare('c_codactivo',$this->c_codactivo,true);
		$criteria->compare('c_codsap',$this->c_codsap,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('estado',$this->estado,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}