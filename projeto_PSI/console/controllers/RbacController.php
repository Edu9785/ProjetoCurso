<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $recoverPassword = $auth->createPermission('recoverPassword');
        $recoverPassword->description = 'Recuperar palavra-passe';
        $auth->add($recoverPassword);

        $buyPremium = $auth->createPermission('buyPremium');
        $buyPremium->description = 'Comprar versão premium';
        $auth->add($buyPremium);

        $deleteAccount = $auth->createPermission('deleteAccount');
        $deleteAccount->description = 'Eliminar a própria conta';
        $auth->add($deleteAccount);

        $chooseDifficulty = $auth->createPermission('chooseDifficulty');
        $chooseDifficulty->description = 'Escolher o nível de dificuldade do quiz';
        $auth->add($chooseDifficulty);

        $chooseCategory = $auth->createPermission('chooseCategory');
        $chooseCategory->description = 'Escolher a categoria do quiz';
        $auth->add($chooseCategory);

        $searchQuiz = $auth->createPermission('searchQuiz');
        $searchQuiz->description = 'Pesquisar quizzes por nome';
        $auth->add($searchQuiz);

        $editAccount = $auth->createPermission('editAccount');
        $editAccount->description = 'Editar os dados da conta';
        $auth->add($editAccount);

        $createQuiz = $auth->createPermission('createQuiz');
        $createQuiz->description = 'Criar quizzes';
        $auth->add($createQuiz);

        $playDefaultQuiz = $auth->createPermission('playDefaultQuiz');
        $playDefaultQuiz->description = 'Jogar quizzes default';
        $auth->add($playDefaultQuiz);

        $playUserQuiz = $auth->createPermission('playUserQuiz');
        $playUserQuiz->description = 'Jogar quizzes criados por utilizadores';
        $auth->add($playUserQuiz);

        $editQuiz = $auth->createPermission('editQuiz');
        $editQuiz->description = 'Editar os próprios quizzes';
        $auth->add($editQuiz);

        $deleteQuiz = $auth->createPermission('deleteQuiz');
        $deleteQuiz->description = 'Eliminar os próprios quizzes';
        $auth->add($deleteQuiz);

        $validateQuiz = $auth->createPermission('validateQuiz');
        $validateQuiz->description = 'Validar quizzes criados por utilizadores';
        $auth->add($validateQuiz);

        $rejectQuiz = $auth->createPermission('rejectQuiz');
        $rejectQuiz->description = 'Recusar quizzes criados por utilizadores';
        $auth->add($rejectQuiz);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Eliminar utilizadores';
        $auth->add($deleteUser);

        $editUser = $auth->createPermission('editUser');
        $editUser->description = 'Editar utilizadores';
        $auth->add($editUser);

        $createCategory = $auth->createPermission('createCategory');
        $createCategory->description = 'Criar categorias para quizzes';
        $auth->add($createCategory);

        $createDefaultQuiz = $auth->createPermission('createDefaultQuiz');
        $createDefaultQuiz->description = 'Criar quizzes default (sem internet)';
        $auth->add($createDefaultQuiz);

        $editDefaultQuiz = $auth->createPermission('editDefaultQuiz');
        $editDefaultQuiz->description = 'Editar quizzes default (sem internet)';
        $auth->add($editDefaultQuiz);

        $deleteDefaultQuiz = $auth->createPermission('deleteDefaultQuiz');
        $deleteDefaultQuiz->description = 'Eliminar quizzes default (sem internet)';
        $auth->add($deleteDefaultQuiz);

        $promoteUser = $auth->createPermission('promoteUser');
        $promoteUser->description = 'Promover utilizadores a gestores';
        $auth->add($promoteUser);

        $demoteManager = $auth->createPermission('demoteManager');
        $demoteManager->description = 'Despromover gestores a utilizadores';
        $auth->add($demoteManager);

        $deleteAnyUser = $auth->createPermission('deleteAnyUser');
        $deleteAnyUser->description = 'Eliminar qualquer utilizador';
        $auth->add($deleteAnyUser);

        $editAnyUser = $auth->createPermission('editAnyUser');
        $editAnyUser->description = 'Editar qualquer utilizador';
        $auth->add($editAnyUser);

        $createAdmin = $auth->createPermission('createAdmin');
        $createAdmin->description = 'Criar administradores';
        $auth->add($createAdmin);

        $editCategory = $auth->createPermission('editCategory');
        $editCategory->description = 'Editar categorias de quizzes';
        $auth->add($editCategory);

        $deleteCategory = $auth->createPermission('deleteCategory');
        $deleteCategory->description = 'Eliminar categorias de quizzes';
        $auth->add($deleteCategory);

        $createDifficulty = $auth->createPermission('createDifficulty');
        $createDifficulty->description = 'Criar dificuldades para quizzes';
        $auth->add($createDifficulty);

        $editDifficulty = $auth->createPermission('editDifficulty');
        $editDifficulty->description = 'Editar dificuldades para quizzes';
        $auth->add($editDifficulty);

        $deleteDifficulty = $auth->createPermission('deleteDifficulty');
        $deleteDifficulty->description = 'Eliminar dificuldades para quizzes';
        $auth->add($deleteDifficulty);

        $createPremium = $auth->createPermission('createPremium');
        $createPremium->description = 'Criar planos premium';
        $auth->add($createPremium);

        $editPremium = $auth->createPermission('editPremium');
        $editPremium->description = 'Editar planos premium';
        $auth->add($editPremium);

        $deletePremium = $auth->createPermission('deletePremium');
        $deletePremium->description = 'Eliminar planos premium';
        $auth->add($deletePremium);

        $accessBackOffice = $auth->createPermission('accessBackOffice');
        $accessBackOffice->description = 'Acessar Backoffice';
        $auth->add($accessBackOffice);

        // ROLE: Utilizador
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $recoverPassword);
        $auth->addChild($user, $buyPremium);
        $auth->addChild($user, $deleteAccount);
        $auth->addChild($user, $chooseDifficulty);
        $auth->addChild($user, $chooseCategory);
        $auth->addChild($user, $searchQuiz);
        $auth->addChild($user, $editAccount);
        $auth->addChild($user, $createQuiz);
        $auth->addChild($user, $playDefaultQuiz);
        $auth->addChild($user, $playUserQuiz);
        $auth->addChild($user, $editQuiz);
        $auth->addChild($user, $deleteQuiz);

        // ROLE: Gestor
        $manager = $auth->createRole('manager');
        $auth->add($manager);
        $auth->addChild($manager, $user);
        $auth->addChild($manager, $validateQuiz);
        $auth->addChild($manager, $rejectQuiz);
        $auth->addChild($manager, $deleteUser);
        $auth->addChild($manager, $editUser);
        $auth->addChild($manager, $createCategory);
        $auth->addChild($manager, $editCategory);
        $auth->addChild($manager, $deleteCategory);
        $auth->addChild($manager, $deleteDifficulty);
        $auth->addChild($manager, $createDifficulty);
        $auth->addChild($manager, $editDifficulty);
        $auth->addChild($manager, $accessBackOffice);


        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $createDefaultQuiz);
        $auth->addChild($admin, $editDefaultQuiz);
        $auth->addChild($admin, $deleteDefaultQuiz);
        $auth->addChild($admin, $promoteUser);
        $auth->addChild($admin, $demoteManager);
        $auth->addChild($admin, $deleteAnyUser);
        $auth->addChild($admin, $editAnyUser);
        $auth->addChild($admin, $createCategory);
        $auth->addChild($admin, $editCategory);
        $auth->addChild($admin, $deleteCategory);
        $auth->addChild($admin, $createDifficulty);
        $auth->addChild($admin, $editDifficulty);
        $auth->addChild($admin, $deleteDifficulty);
        $auth->addChild($admin, $createPremium);
        $auth->addChild($admin, $editPremium);
        $auth->addChild($admin, $deletePremium);
        $auth->addChild($admin, $createAdmin);
        $auth->addChild($admin, $accessBackOffice);

        echo "RBAC configuration successfully initialized.\n";
    }
}
