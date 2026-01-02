<?php


namespace frontend\tests\unit;

use common\models\Pergunta;
use frontend\tests\UnitTester;

class PerguntaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidadePergunta()
    {
        $perguntaModel = new Pergunta();

        $perguntaModel -> valor = "hgiyg";
        $this -> assertFalse($perguntaModel -> validate(['valor']));

        $perguntaModel -> valor = null;
        $this -> assertFalse($perguntaModel -> validate(['valor']));

        $perguntaModel -> pergunta = "senntidifhdfhffvjfhdhsdghsdfhfdbDBFhbfHBDFDHBshBFBHWRUI24Y2EBHVBDBdwgcvgvgvgvtvaakmkanandkndandjbubfub";
        $this -> assertFalse($perguntaModel -> validate(['pergunta']));

        $perguntaModel -> pergunta = null;
        $this -> assertFalse($perguntaModel -> validate(['pergunta']));
    }

    public function testPergunta()
    {
        $perguntaModel = new Pergunta();

        $perguntaModel -> valor = 100;
        $perguntaModel -> pergunta = "pergunta1";
        $perguntaModel -> save();
        $perModel = Pergunta::findOne(['pergunta' => 'pergunta1']);
        $this->assertNotNull($perModel);

        $perModel -> pergunta = "pergunta2";
        $perModel -> save();

        $perOldModel = Pergunta::findOne(['pergunta' => 'pergunta1']);
        $this->assertNull($perOldModel);

        $perUpdateModel = Pergunta::findOne(['pergunta' => 'pergunta2']);
        $this->assertNotNull($perUpdateModel);

        $perUpdateModel->delete();

        $perDeletedModel = Pergunta::findOne(['pergunta' => 'pergunta2']);
        $this->assertNull($perDeletedModel);
    }
}
