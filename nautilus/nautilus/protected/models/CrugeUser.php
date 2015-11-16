<?php

/**
 * This is the model class for table "cruge_user".
 *
 * The followings are the available columns in table 'cruge_user':
 * @property integer $iduser
 * @property string $regdate
 * @property string $actdate
 * @property string $logondate
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $authkey
 * @property integer $state
 * @property integer $totalsessioncounter
 * @property integer $currentsessioncounter
 */
class CrugeUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cruge_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iduser', 'required'),
			array('iduser, state, totalsessioncounter, currentsessioncounter', 'numerical', 'integerOnly'=>true),
			array('regdate, actdate, logondate', 'length', 'max'=>20),
			array('username, password', 'length', 'max'=>64),
			array('email', 'length', 'max'=>45),
			array('authkey', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('iduser, regdate, actdate, logondate, username, email, password, authkey, state, totalsessioncounter, currentsessioncounter', 'safe', 'on'=>'search'),
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
			'iduser' => 'Iduser',
			'regdate' => 'Regdate',
			'actdate' => 'Actdate',
			'logondate' => 'Logondate',
			'username' => 'Username',
			'email' => 'Email',
			'password' => 'Password',
			'authkey' => 'Authkey',
			'state' => 'State',
			'totalsessioncounter' => 'Totalsessioncounter',
			'currentsessioncounter' => 'Currentsessioncounter',
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

		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('regdate',$this->regdate,true);
		$criteria->compare('actdate',$this->actdate,true);
		$criteria->compare('logondate',$this->logondate,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('authkey',$this->authkey,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('totalsessioncounter',$this->totalsessioncounter);
		$criteria->compare('currentsessioncounter',$this->currentsessioncounter);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CrugeUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
