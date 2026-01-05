<?php


namespace frontend\tests\unit;

use common\models\Categoria;
use frontend\tests\UnitTester;

class CategoriaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {

    }

    // tests
    public function testValidateCategoria()
    {
        $categoriaModel = new Categoria();

        $categoriaModel ->categoria = "senntidifhdfhffvjfhdhsdghsdfhfdbDBFhbfHBDFDHBshBFBHWRUI24Y2EBHVBDBdwgcvgvgvgvtvaakmkanandkndandjbubfub";
        $this -> assertFalse($categoriaModel->validate(['categoria']));

        $categoriaModel -> categoria = null;
        $this -> assertFalse($categoriaModel->validate(['categoria']));

        $categoriaModel -> id_gestor = 2;
        $this -> assertFalse($categoriaModel -> validate(['id_gestor']));

        $categoriaModel ->id_gestor = "ubfub";
        $this -> assertFalse($categoriaModel->validate(['id_gestor']));

        $categoriaModel -> id_gestor = null;
        $this -> assertFalse($categoriaModel->validate(['id_gestor']));
    }

    public function testCategoria()
    {
        $categoriaModel = new Categoria();

        $categoriaModel -> categoria = "categoria1";
        $categoriaModel -> id_gestor = 3;
        $categoriaModel -> save();
        $catModel = Categoria::findOne(['categoria' => 'categoria1']);
        $this->assertNotNull($catModel);

        $catModel -> categoria = "categoria2";
        $catModel -> save();

        $catOldModel = Categoria::findOne(['categoria' => 'categoria1']);
        $this->assertNull($catOldModel);

        $catUpdateModel = Categoria::findOne(['categoria' => 'categoria2']);
        $this->assertNotNull($catUpdateModel);

        $catUpdateModel->delete();

        $catDeletedModel = Categoria::findOne(['categoria' => 'categoria2']);
        $this->assertNull($catDeletedModel);
    }
}
