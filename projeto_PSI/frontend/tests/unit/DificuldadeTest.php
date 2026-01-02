<?php


namespace frontend\tests\unit;

use common\models\Dificuldade;
use frontend\tests\UnitTester;

class DificuldadeTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidateDificuldade()
    {
        $dificuldadeModel = new Dificuldade();

        $dificuldadeModel -> dificuldade = "senntidifhdfhffvjfhdhsdghsdfhfdbDBFhbfHBDFDHBshkanandkndandjbubfub";
        $this -> assertFalse($dificuldadeModel->validate(['dificuldade']));

        $dificuldadeModel -> dificuldade = null;
        $this -> assertFalse($dificuldadeModel->validate(['dificuldade']));
    }

    public function testDificuldade()
    {
        $dificuldadeModel = new Dificuldade();

        $dificuldadeModel -> dificuldade = "dificuldade1";
        $dificuldadeModel -> save();
        $difModel = Dificuldade::findOne(['dificuldade' => 'dificuldade1']);
        $this->assertNotNull($difModel);

        $difModel -> dificuldade = "dificuldade2";
        $difModel -> save();

        $difOldModel = Dificuldade::findOne(['dificuldade' => 'dificuldade1']);
        $this->assertNull($difOldModel);

        $difUpdateModel = Dificuldade::findOne(['dificuldade' => 'dificuldade2']);
        $this->assertNotNull($difUpdateModel);

        $difUpdateModel->delete();

        $difDeletedModel = Dificuldade::findOne(['dificuldade' => 'dificuldade2']);
        $this->assertNull($difDeletedModel);
    }
}
