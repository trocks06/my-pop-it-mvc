<?php
use PHPUnit\Framework\TestCase;
use Model\Room;
use Model\Department;
use Model\RoomType;

class RoomControllerTest extends TestCase
{
    public function testSignup(string $httpMethod, array $roomData, string $message): void
    {
        //Выбираем занятый логин из базы данных
        if ($roomData['room_name'] === 'existing_room') {
            Room::create([
                'room_name' => 'Конференц-зал 101',
                'department_id' => 1,
                'room_type_id' => 1
            ]);
        }

        // Создаем заглушку для класса Request.
        $request = $this->createMock(\Src\Request::class);
        // Переопределяем метод all() и свойство method
        $request->expects($this->any())
            ->method('all')
            ->willReturn($roomData);
        $request->method = $httpMethod;

        //Сохраняем результат работы метода в переменную
        $result = (new \Controller\RoomController())->create_room($request);

        if (!empty($result)) {
            //Проверяем варианты с ошибками валидации
            $message = '/' . preg_quote($message, '/') . '/';
            $this->expectOutputRegex($message);
            return;
        }

        //Проверяем добавился ли пользователь в базу данных
        $this->assertTrue((bool)Room::where('room_name', $roomData['room_name'])->count());
        //Удаляем созданного пользователя из базы данных
        Room::where('room_name', $roomData['room_name'])->delete();

    }

    protected function setUp(): void
    {
        //Установка переменной среды
        $_SERVER['DOCUMENT_ROOT'] = '/var/www';

   //Создаем экземпляр приложения
   $GLOBALS['app'] = new Src\Application(new Src\Settings([
       'app' => include $_SERVER['DOCUMENT_ROOT'] . '/config/app.php',
       'db' => include $_SERVER['DOCUMENT_ROOT'] . '/config/db.php',
       'path' => include $_SERVER['DOCUMENT_ROOT'] . '/config/path.php',
   ]));

   //Глобальная функция для доступа к объекту приложения
   if (!function_exists('app')) {
       function app()
       {
           return $GLOBALS['app'];
       }
   }
}

//Метод, возвращающий набор тестовых данных
    public function additionProvider(): array
    {
        return [
            ['POST', ['room_name' => 'Конференц-зал 101', 'department_id' => '1', 'room_type_id' => '1'],
                '<h3></h3>'
            ],
            ['POST', ['room_name' => '', 'department_id' => '1', 'room_type_id' => '1'],
                '<h3></h3>',
            ],
            ['POST', ['room_name' => 'Конференц-зал 101', 'department_id' => '1', 'room_type_id' => '1'],
                '<h3>{"login":["Поле login должно быть уникально"]}</h3>',
            ],
        ];
    }
}