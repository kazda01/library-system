<?php

namespace app\commands;

use app\models\Author;
use app\models\Book;
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
        
        $author = new Author([
            'name' => 'Joanne Kathleen Rowling',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        $success = $success && $author->save();
        
        $book = new Book([
            'fk_author' => $author->id,
            'title' => "The Cuckoo's Calling",
            'description' => "After losing his leg to a land mine in Afghanistan, Cormoran Strike is barely scraping by as a private investigator. Then John Bristow walks through his door with an amazing story: His sister, the legendary supermodel Lula Landry, famously fell to her death a few months earlier. The police ruled it a suicide, but John refuses to believe that. The case plunges Strike into the world of multimillionaire beauties, rock-star boyfriends, and desperate designers, and it introduces him to every variety of pleasure, enticement, seduction, and delusion known to man.",
            'language' => 'english',
            'isbn' => '9780316206846',
            'pages' => 464,
            'year_of_publication' => 2013,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        $success = $success && $book->save();
        
        $book = new Book([
            'fk_author' => $author->id,
            'title' => 'The Silkworm',
            'description' => "The Silkworm is a crime thriller by Robert Galbraith. It is the second novel in the Cormoran Strike series, and Mulholland Books first published it in 2014. In the book, a private detective must track down a missing novelist before he's murdered for writing a scandalous new book.",
            'language' => 'english',
            'isbn' => '9780316351980',
            'pages' => 672,
            'year_of_publication' => 2015,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        $success = $success && $book->save();
        
        $author = new Author([
            'name' => 'Nikolaj Vasiljevič Gogol',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        $success = $success && $author->save();
        
        $book = new Book([
            'fk_author' => $author->id,
            'title' => 'Revizor',
            'description' => "Revizor (rusky Ревизор) je pětiaktová satirická komedie ruského prozaika a dramatika Nikolaje Vasiljeviče Gogola, patřící k nejslavnějším dílům světové dramatické literatury. Autor svou hrou, zachycující tupost, nevzdělanost a zkaženost úředníků v jednom ruském provinčním městečku prolezlém korupcí a různými jinými neřestmi, nastavil zrcadlo všem, jejichž charakter je pokřiven podlézavostí a úplatkářstvím.",
            'language' => 'česky',
            'isbn' => '9788074831959',
            'pages' => 96,
            'year_of_publication' => 1836,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        $success = $success && $book->save();

        if ($success) {
            echo ("Seeded successfully. Transaction commited.\n");
            $transaction->commit();
        } else {
            echo ("Seed failed. Transaction rolled back.\n");
            $transaction->rollBack();
        }
    }
}
