<?php


namespace frontend\tests\unit;

use common\models\Jogador;
use frontend\tests\UnitTester;

class JogadorTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidatedJogador()
    {
        $jogadorModel = new Jogador();

        $jogadorModel ->id_premium = "rgaagsf";
        $this -> assertFalse($jogadorModel->validate(['id_premium']));

        $jogadorModel -> id_premium = 1;
        $this -> assertFalse($jogadorModel -> validate(['id_premium']));

        $jogadorModel -> id_user = 30;
        $this -> assertFalse($jogadorModel -> validate(['id_user']));

        $jogadorModel ->id_user = "ubfub";
        $this -> assertFalse($jogadorModel->validate(['id_user']));

        $jogadorModel -> id_user = null;
        $this -> assertFalse($jogadorModel->validate(['id_user']));

        $jogadorModel ->nome = "senntidifhdfhffvjfhdhsdghsdfhfdbDBFhbfHBDFDHBshBFBHWRUI24Y2EBHVBDBdwgcvgvgvgvtvaakmkanandkndandjbubfubhdqwvvvdgvfdgvfuvuvgdwvjhjcenrigu3ur4bvsnfbbeitlkjg";
        $this -> assertFalse($jogadorModel->validate(['nome']));

        $jogadorModel -> nome = null;
        $this -> assertFalse($jogadorModel->validate(['nome']));

        $jogadorModel ->idade = "ubfub";
        $this -> assertFalse($jogadorModel->validate(['idade']));

        $jogadorModel -> idade = null;
        $this -> assertFalse($jogadorModel->validate(['idade']));
    }

    public function testJogador()
    {
        $jogadorModel = new Jogador();

        $jogadorModel -> nome = "jogador1";
        $jogadorModel -> idade = 19;
        $jogadorModel -> id_premium = null;
        $jogadorModel -> id_user = 11;
        $jogadorModel -> save();
        $jogModel = Jogador::findOne(['nome' => 'jogador1']);
        $this->assertNotNull($jogModel);

        $jogModel -> nome = "jogador2";
        $jogModel -> save();

        $jogOldModel = Jogador::findOne(['nome' => 'jogador1']);
        $this->assertNull($jogOldModel);

        $jogUpdateModel = Jogador::findOne(['nome' => 'jogador2']);
        $this->assertNotNull($jogUpdateModel);

        $jogUpdateModel->delete();

        $JogDeletedModel = Jogador::findOne(['nome' => 'jogador2']);
        $this->assertNull($JogDeletedModel);
    }
}
