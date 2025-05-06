<?php

use Controller\RoomController;
use PHPUnit\Framework\TestCase;
use Model\Room;
use Model\RoomType;
use Model\Department;
use Src\Validator;
use Src\View;
use Src\Request;
use Illuminate\Database\Capsule\Manager as Capsule;

class RoomControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'pxurhary_m5',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $this->initDatabase();
    }

    protected function tearDown(): void
    {
        // Очистка базы данных после тестов
        $this->resetDatabase();
    }

    private function initDatabase()
    {
        RoomType::create(['type_name' => 'Конференц-зал']);
        Department::create(['department_name' => 'IT отдел', 'department_type_id' => '1']);
    }

    private function resetDatabase()
    {
        Room::where('room_name', 'Конференц-зал 101')->delete();
        RoomType::where(['type_name' => 'Конференц-зал'])->delete();
        Department::where(['department_name' => 'IT отдел'])->delete();
    }

    /**
     * Тест #1: Проверка успешного создания помещения (TC_FUNC_1)
     */
    public function testSuccessfulRoomCreation()
    {
        $roomType = RoomType::where(['type_name' => 'Конференц-зал'])->first();
        $department = Department::where(['department_name' => 'IT отдел'])->first();
        $request = new Request();
        $request->method = 'POST';
        $request->all = [
            'room_name' => 'Конференц-зал 101',
            'department_id' => $department->id,
            'room_type_id' => $roomType->id,
        ];

        // Вызов тестируемой функции
        $controller = new RoomController();
        $response = $controller->create_room($request);

        // Проверки
        $this->assertInstanceOf(\App\Core\RedirectResponse::class, $response);
        $this->assertEquals('/rooms', $response->getTargetUrl());

        // Проверка, что помещение создано в базе
        $room = Room::where('room_name', 'Конференц-зал 101')->first();
        $this->assertNotNull($room);
        $this->assertEquals('Конференц-зал 101', $room->room_name);
        $this->assertEquals($department->id, $room->department_id);
        $this->assertEquals($roomType->id, $room->room_type_id);
    }

    /**
     * Тест #2: Проверка валидации обязательных полей (TC_FUNC_2)
     */
    public function testValidationForRequiredFields()
    {
        // Подготовка тестовых данных
        $request = new Request();
        $request->method = 'POST';
        $request->all = [
            'room_name' => '',
            'department_id' => '',
            'room_type_id' => ''
        ];

        // Вызов тестируемой функции
        $controller = new RoomController();
        $response = $controller->create_room($request);

        // Проверки
        $this->assertInstanceOf(View::class, $response);

        // Получаем ошибки из ответа
        $errors = $response->getData()['errors'] ?? null;
        $this->assertNotNull($errors);

        // Проверяем наличие ошибок для каждого обязательного поля
        $this->assertTrue($errors->has('room_name'));
        $this->assertEquals('Поле room_name обязательно для заполнения', $errors->first('room_name'));

        $this->assertTrue($errors->has('department_id'));
        $this->assertEquals('Поле department_id обязательно для заполнения', $errors->first('department_id'));

        $this->assertTrue($errors->has('room_type_id'));
        $this->assertEquals('Поле room_type_id обязательно для заполнения', $errors->first('room_type_id'));

        // Проверка, что помещение не создано
        $count = Room::count();
        $this->assertEquals(0, $count);
    }

    /**
     * Тест #3: Проверка уникальности названия помещения (TC_FUNC_3)
     */
    public function testUniqueRoomNameValidation()
    {
        // Сначала создаем помещение с таким именем
        Room::create([
            'room_name' => 'Конференц-зал 101',
            'department_id' => 1,
            'room_type_id' => 1
        ]);

        // Подготовка тестовых данных
        $request = new Request();
        $request->method = 'POST';
        $request->all = [
            'room_name' => 'Конференц-зал 101',
            'department_id' => 1,
            'room_type_id' => 1
        ];
// Вызов тестируемой функции
        $controller = new RoomController();
        $response = $controller->create_room($request);

        // Проверки
        $this->assertInstanceOf(View::class, $response);

        // Получаем ошибки из ответа
        $errors = $response->getData()['errors'] ?? null;
        $this->assertNotNull($errors);

        // Проверяем наличие ошибки уникальности
        $this->assertTrue($errors->has('room_name'));
        $this->assertEquals('Помещение с таким названием уже существует', $errors->first('room_name'));

        // Проверка, что новое помещение не создано
        $count = Room::where('room_name', 'Конференц-зал 101')->count();
        $this->assertEquals(1, $count); // Должна остаться только одна запись
    }
}