<?php

use App\Http\Controllers\Api\multiple_choicesController;
use App\Models\multiple_choices;
use Illuminate\Http\Request;
use Tests\TestCase;


class multiple_choicesControllerTest extends TestCase
{
    
    public function test_de_alternativa_erro()
    {
        $request = new Request([
            'idQuestion' => 1,
        ]);

        $controller = new multiple_choicesController();
        $response = $controller->store($request);

        $this->assertEquals(422, $response->getStatusCode());


    }

    public function testDestroyDeletesMultipleChoice()
    {
        $multiple_choice = multiple_choices::create([
            'choices' => 'A',
            'idQuestion' => 1,
        ]);

        $controller = new multiple_choicesController();
        $response = $controller->destroy($multiple_choice->id);

        $this->assertEquals(204, $response->getStatusCode());

        $this->assertDatabaseMissing('multiple_choices', ['id' => $multiple_choice->id]);
    }
}
