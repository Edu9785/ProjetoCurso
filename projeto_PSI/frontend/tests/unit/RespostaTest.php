<?php


namespace frontend\tests\unit;

use common\models\Resposta;
use frontend\tests\UnitTester;

class RespostaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidateResposta()
    {
        $respostaModel = new Resposta();

        $respostaModel -> id_pergunta = 11;
        $this -> assertFalse($respostaModel -> validate(['id_pergunta']));

        $respostaModel ->id_pergunta = "hdbvnsc";
        $this -> assertFalse($respostaModel->validate(['id_pergunta']));

        $respostaModel -> id_pergunta = null;
        $this -> assertFalse($respostaModel->validate(['id_pergunta']));

        $respostaModel ->correta = "ubfub";
        $this -> assertFalse($respostaModel->validate(['correta']));

        $respostaModel -> correta = null;
        $this -> assertFalse($respostaModel->validate(['correta']));

        $respostaModel ->resposta = "A tecnologia transforma profundamente nossa relação com o conhecimento. Antes restrito a livros e especialistas, o saber hoje pulsa em fluxos digitais instantâneos. Smartphones tornam-se extensões cognitivas, algoritmos organizam informações, redes sociais democratizam debates. Este acesso ilimitado, porém, exige responsabilidade: filtrar dados, questionar fontes, combater desinformação. Aprendemos coletivamente, em comunidades online que transcendem fronteiras físicas. A educação evolui para modelos híbridos, personalizados, interativos. Este novo paradigma convida a uma alfabetização digital crítica, onde";
        $this -> assertFalse($respostaModel->validate(['resposta']));

        $respostaModel -> resposta = null;
        $this -> assertFalse($respostaModel->validate(['resposta']));
    }

    public function testResposta()
    {
        $respostaModel = new Resposta();

        $respostaModel -> correta = 1;
        $respostaModel -> id_pergunta = 1;
        $respostaModel -> resposta = "resposta1";
        $respostaModel -> save();
        $resModel = Resposta::findOne(['resposta' => 'resposta1']);
        $this->assertNotNull($resModel);

        $resModel -> resposta = "resposta2";
        $resModel -> save();

        $resOldModel = Resposta::findOne(['resposta' => 'resposta1']);
        $this->assertNull($resOldModel);

        $resUpdateModel = Resposta::findOne(['resposta' => 'resposta2']);
        $this->assertNotNull($resUpdateModel);

        $resUpdateModel->delete();

        $resDeletedModel = Resposta::findOne(['resposta' => 'resposta2']);
        $this->assertNull($resDeletedModel);
    }
}
