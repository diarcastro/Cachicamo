<?php

/**
 * This is the model class for table "{{location}}".
 *
 * The followings are the available columns in table '{{location}}':
 * @property integer $id
 * @property string $name
 * @property string $imege
 * @property string $city
 * @property string $capacity
 * @property string $fiffa_url
 * @property integer $time_zone
 *
 * The followings are the available model relations:
 * @property Match[] $matches
 */
class Location extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{location}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('time_zone', 'numerical', 'integerOnly'=>true),
			array('name, imege, city', 'length', 'max'=>30),
			array('capacity', 'length', 'max'=>10),
			array('fiffa_url', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, imege, city, capacity, fiffa_url, time_zone', 'safe', 'on'=>'search'),
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
			'matches' => array(self::HAS_MANY, 'Match', 'location_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'imege' => 'Imege',
			'city' => 'City',
			'capacity' => 'Capacity',
			'fiffa_url' => 'Fiffa Url',
			'time_zone' => 'Time Zone',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('imege',$this->imege,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('capacity',$this->capacity,true);
		$criteria->compare('fiffa_url',$this->fiffa_url,true);
		$criteria->compare('time_zone',$this->time_zone);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Location the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}