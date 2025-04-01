<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Yii;
use yii\base\NotSupportedException;
use yii\web\UploadedFile;

/**
 * This is the model class for table "new_users".
 *
 * @property int $id
 * @property string $login
 * @property string $email
 * @property string $password
 * @property string|null $image
 * @property string $created_at
 * @property string $updated_at
 */
class NewUsers extends ActiveRecord implements IdentityInterface
{
    // Добавляем константу для типа хеширования пароля
    const PASSWORD_RESET_TOKEN_VALID_TIME = 3600;
    public $imageFile;
    
    public static function tableName()
    {
        return 'new_users';
    }

    public function rules()
    {
        return [
            [['login', 'email', 'password'], 'required'],
            [['login', 'email', 'password'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['login', 'email'], 'unique'],
            [['imageFile'], 'file', 'extensions' => 'jpeg, png, jpg, gif, svg', 'maxSize' => 2048 * 1024, 'skipOnEmpty' => false],
            [['image'], 'string'],
            [['auth_key'], 'string', 'max' => 32],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'login' => 'Логин/Никнейм',
            'email' => 'email',
            'password' => 'Пароль',
            'image' => 'Изображение',
        ];
    }

    public function uploadImage()
    {
        if ($this->validate()) {
            // Генерация уникального имени для файла
            $filename = time() . '.' . $this->imageFile->extension;
            $path = 'uploads/avatars/' . $filename;
            
            // Сохраняем файл
            $filePath = Yii::getAlias('@webroot') . '/' . $path;
            if ($this->imageFile->saveAs($filePath)) {
                return $path;
            }
        }
        return false;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile($file)
    {
        $this->imageFile = $file;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['login' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
}