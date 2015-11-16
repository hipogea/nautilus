<?php

/**
 * This is the model class for table "{{coordreporte}}".
 *
 * The followings are the available columns in table '{{coordreporte}}':
 * @property integer $id
 * @property string $codocu
 * @property integer $x
 * @property integer $y
 * @property integer $font_size
 * @property string $font_family
 * @property string $font_weight
 * @property string $font_color
 * @property string $nombre_campo
 * @property integer $lbl_x
 * @property integer $lbl_y
 * @property integer $lbl_font_size
 * @property string $lbl_font_weight
 * @property string $lbl_font_family
 * @property string $lbl_font_color
 */
class Coordreporte extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{coordreporte}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//	array('codocu, x, y, nombre_campo, lbl_x, lbl_y', 'required'),
			//array('x, y, font_size, lbl_x, lbl_y, lbl_font_size', 'numerical', 'integerOnly'=>true),
			array('codocu', 'length', 'max'=>3),
			array('font_family, font_color', 'length', 'max'=>11),
			array('font_weight, lbl_font_weight', 'length', 'max'=>10),
			array('nombre_campo', 'length', 'max'=>60),
			array('lbl_font_family', 'length', 'max'=>35),
			array('lbl_font_color', 'length', 'max'=>25),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, codocu, x, y, font_size, font_family, font_weight, font_color, nombre_campo, lbl_left, lbl_top, lbl_font_size, lbl_font_weight, lbl_font_family, lbl_font_color,esdetalle,visiblelabel,visiblecampo', 'safe', 'on'=>'search'),
			array('codocu,hidreporte,esdetalle, x, y,left_,aliascampo,longitudcampo,tipodato, top, font_size, font_family, font_weight, font_color, nombre_campo, lbl_left, lbl_top, lbl_font_size, lbl_font_weight, lbl_font_family,estilo, tienepie, lbl_font_color,visiblelabel,visiblecampo,iduser', 'safe', 'on'=>'insert,update'),

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
				'reporte' => array(self::BELONGS_TO, 'Coordocs', 'hidreporte'),

			);

	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codocu' => 'Codocu',
			'left_' => 'Margen',
			'top' => 'Altura',
			'font_size' => 'Tamaño letra',
			'font_family' => 'Fuente',
			'font_weight' => 'Negrita',
			'font_color' => 'Color',
			'nombre_campo' => 'Nombre del Campo',
			'lbl_left' => 'Margen etiqueta',
			'lbl_top' => 'Altura etiqueta',
			'lbl_font_size' => 'Tamaño letra etiqueta',
			'lbl_font_weight' => 'Negrita etiqueta',
			'lbl_font_family' => 'Fuente etiqueta',
			'lbl_font_color' => 'Color etiqueta',
			'visiblelabel' => 'Etiqueta Visible',
			'visiblecampo' => 'Campo visible',
		);
	}





	 
	public function search_por_hidreporte($id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		//$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('left_',$this->left_);
		$criteria->compare('top',$this->top);
		$criteria->compare('font_size',$this->font_size);
		$criteria->compare('font_family',$this->font_family,true);
		$criteria->compare('font_weight',$this->font_weight,true);
		$criteria->compare('font_color',$this->font_color,true);
		$criteria->compare('nombre_campo',$this->nombre_campo,true);
		$criteria->compare('lbl_left',$this->lbl_left);
		$criteria->compare('lbl_top',$this->lbl_top);
		$criteria->compare('lbl_font_size',$this->lbl_font_size);
		$criteria->compare('lbl_font_weight',$this->lbl_font_weight,true);
		$criteria->compare('lbl_font_family',$this->lbl_font_family,true);
		$criteria->compare('lbl_font_color',$this->lbl_font_color,true);
		$criteria->addcondition("hidreporte=".$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 40,
			),
		));
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
	public function search_por_doc($codigodoc)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		//$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('left_',$this->left_);
		$criteria->compare('top',$this->top);
		$criteria->compare('font_size',$this->font_size);
		$criteria->compare('font_family',$this->font_family,true);
		$criteria->compare('font_weight',$this->font_weight,true);
		$criteria->compare('font_color',$this->font_color,true);
		$criteria->compare('nombre_campo',$this->nombre_campo,true);
		$criteria->compare('lbl_left',$this->lbl_left);
		$criteria->compare('lbl_top',$this->lbl_top);
		$criteria->compare('lbl_font_size',$this->lbl_font_size);
		$criteria->compare('lbl_font_weight',$this->lbl_font_weight,true);
		$criteria->compare('lbl_font_family',$this->lbl_font_family,true);
		$criteria->compare('lbl_font_color',$this->lbl_font_color,true);
		$criteria->addcondition("codocu='".trim($codigodoc)."'");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 40,
			),
		));
	}
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		//$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('left_',$this->left_);
		$criteria->compare('top',$this->top);
		$criteria->compare('font_size',$this->font_size);
		$criteria->compare('font_family',$this->font_family,true);
		$criteria->compare('font_weight',$this->font_weight,true);
		$criteria->compare('font_color',$this->font_color,true);
		$criteria->compare('nombre_campo',$this->nombre_campo,true);
		$criteria->compare('lbl_left',$this->lbl_left);
		$criteria->compare('lbl_top',$this->lbl_top);
		$criteria->compare('lbl_font_size',$this->lbl_font_size);
		$criteria->compare('lbl_font_weight',$this->lbl_font_weight,true);
		$criteria->compare('lbl_font_family',$this->lbl_font_family,true);
		$criteria->compare('lbl_font_color',$this->lbl_font_color,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 1000,
			),
		));
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Coordreporte the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}