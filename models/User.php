<?php

namespace app\models;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
   public $idusuario;
   public $nombre;
   public $apellido;
   public $usuario;
   public $contrasena;
   public $rol;
   public $authKey;
   public $accessToken;




    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $usuario = Usuario::find()
                ->Where(['idusuario'=>$id])
                ->one();
        return isset($usuario) ? new static($usuario) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
            $users = Users::find()
                ->where("activate=:activate", [":activate" => 1])
                ->andWhere("accessToken=:accessToken", [":accessToken" => $token])
                ->all();

        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $usuarios = Usuario::find()
                ->where(['usuario'=>$username])
                ->all();

        foreach ($usuarios as $user)
        {
            if( strcasecmp( $user->usuario, $username ) === 0 )
            {
                return new static( $user );
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->idusuario;
    }

    public function getEsadmin()
    {
        return ( $this->rol == 0 ) ? true : false;
    }

    public function getEsvendedor()
    {
        return ( $this->rol == 1 ) ? true : false;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->contrasena === $password;
    }
}
