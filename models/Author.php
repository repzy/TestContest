<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "authors".
 *
 * @property integer $id
 * @property string $ip
 * @property string $browser
 * @property string $country
 */
class Author extends \yii\db\ActiveRecord
{
    public function __construct()
    {
        $this->ip = Yii::$app->request->userIP;
        $this->browser = Yii::$app->request->acceptableLanguages[0];
        $this->country = $this->getCountryName();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'browser', 'country'], 'required'],
            [['ip', 'browser', 'country'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'browser' => 'Browser',
            'country' => 'Country',
        ];
    }

    public function getAdvertisements()
    {
        return $this->hasMany(Advertisement::className(), ['author_id' => 'id']);
    }

    /**
     * @return bool
     */
    public function getCountryName()
    {
        if( $curl = curl_init() ) {
            $ip = Yii::$app->request->userIP;;
            curl_setopt($curl, CURLOPT_URL, 'http://api.hostip.info/get_json.php?ip='.$ip);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $result = json_decode(curl_exec($curl));
            curl_close($curl);

            return $result->country_name;
        }

        return false;
    }
}
