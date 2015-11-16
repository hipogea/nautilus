<?php

/**
 * This is the model class for table "vw_pendiente_taller".
 *
 * The followings are the available columns in table 'vw_pendiente_taller':
 * @property string $razondestinatario
 * @property string $ptopartida
 * @property string $d_fectra
 * @property string $c_trans
 * @property string $c_serie
 * @property string $c_numgui
 * @property string $c_itguia
 * @property double $n_cangui
 * @property string $c_um
 * @property string $c_codgui
 * @property string $c_descri
 * @property string $nomep
 * @property double $devuelto
 * @property double $pendiente
 */
class VwPendienteTaller extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwPendienteTaller the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public $d_fectra1;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_pendiente_taller';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('n_cangui, devuelto, pendiente', 'numerical'),
			array('razondestinatario', 'length', 'max'=>50),
			array('ptopartida', 'length', 'max'=>60),
			array('c_trans', 'length', 'max'=>20),
			array('c_serie, c_itguia, c_um', 'length', 'max'=>3),
			array('c_numgui, c_codgui', 'length', 'max'=>8),
			array('c_descri', 'length', 'max'=>40),
			array('nomep', 'length', 'max'=>25),
			array('d_fectra', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('razondestinatario, ptopartida, d_fectra, c_trans, c_serie, c_numgui, c_itguia, n_cangui, c_um, c_codgui, c_descri, nomep, devuelto, pendiente', 'safe', 'on'=>'search'),
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
			'razondestinatario' => 'Destinatario',
			'ptopartida' => 'Desde',
			'd_fectra' => 'F. Traslado',
			'c_trans' => 'Conductor',
			'c_serie' => 'Serie',
			'c_numgui' => 'Numero Guia',
			'c_itguia' => 'Item',
			'n_cangui' => 'Cant.',
			'c_um' => 'Um',
			'c_codgui' => 'Codigo',
			'c_descri' => 'Descripcion',
			'nomep' => 'Embarcacion',
			'devuelto' => 'Cant. Devuelta',
			'pendiente' => 'Cant. Pendiente',
			'diaspasados' => 'Dias pasados',
			
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

		$criteria->compare('razondestinatario',$this->razondestinatario,true);
		$criteria->compare('ptopartida',$this->ptopartida,true);
		$criteria->compare('d_fectra',$this->d_fectra,true);
		$criteria->compare('c_trans',$this->c_trans,true);
		$criteria->compare('c_serie',$this->c_serie,true);
		$criteria->compare('c_numgui',$this->c_numgui,true);
		$criteria->compare('c_itguia',$this->c_itguia,true);
		$criteria->compare('n_cangui',$this->n_cangui);
		$criteria->compare('c_um',$this->c_um,true);
		$criteria->compare('c_codgui',$this->c_codgui,true);
		$criteria->compare('c_descri',$this->c_descri,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('devuelto',$this->devuelto);
		$criteria->compare('pendiente',$this->pendiente);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}