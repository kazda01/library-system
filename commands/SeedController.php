<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;

class SeedController extends Controller
{
    /**
     * This command seeds database.
     * @return int Exit code
     */
    public function actionIndex()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $success = true;
        $admin = new User([
            'id' => 1,
            'username' => 'admin',
            'password_hash' => '$2a$12$iMWA4z1p9IOOq/MGTwqMeOIdGTgnDWNNN7RbbxAzbyB7gqcQeViku',
            'email' => 'admin@nitte.cz',
            'auth_key' => '',
            'status' => User::STATUS_ACTIVE,
        ]);
        $role = Yii::$app->authManager->getRole('admin');
        Yii::$app->authManager->assign($role, $admin->id);
        $success = $success && $admin->save();

        if ($success) {
            echo ("Seeded successfully. Transaction commited.\n");
            $transaction->commit();
        } else {
            echo ("Seed failed. Transaction rolled back.\n");
            $transaction->rollBack();
        }
    }
}
