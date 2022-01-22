<?php

namespace app\models\user;

use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{
    /**
     * Returns only active Users.
     *
     * @return UserQuery
     */
    public function active(): UserQuery
    {
        return $this->andWhere(['status' => User::STATUS_ACTIVE]);
    }

    /**
     * Finds model by token.
     *
     * @param string $token
     * @return UserQuery
     */
    public function byToken(string $token): UserQuery
    {
        return $this->andWhere(['access_token' => $token]);
    }

    /**
     * Finds User model by id.
     *
     * @param int $id
     * @return UserQuery
     */
    public function byId(int $id): UserQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * Finds User model by login.
     *
     * @param string $login
     * @return UserQuery
     */
    public function byLogin(string $login): UserQuery
    {
        return $this->andWhere(['login' => $login]);
    }

    /**
     * Finds User model by email.
     *
     * @param string $email
     * @return UserQuery
     */
    public function byEmail(string $email): UserQuery
    {
        return $this->andWhere(['email' => $email]);
    }

    /**
     * Selects public fields only.
     *
     * @return UserQuery
     */
    public function public(): UserQuery
    {
        return $this->select([
            'id',
            'login',
            'email',
            'created_at',
            'updated_at',
        ]);
    }
}