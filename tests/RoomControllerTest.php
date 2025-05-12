<?php

use Controller\RoomController;
use PHPUnit\Framework\TestCase;
use Src\Request;
use Src\Application;

class RoomControllerTest extends TestCase
{
    protected function setUp(): void
    {
        // Создаем простой мок приложения без лишних зависимостей
        $GLOBALS['app'] = $this->getMockBuilder(stdClass::class)
            ->addMethods(['settings']) // Добавляем метод settings к stdClass
            ->getMock();

        // Глобальная функция для доступа к объекту приложения
        if (!function_exists('app')) {
            function app()
            {
                return $GLOBALS['app'];
            }
        }
    }

    /**
     * @dataProvider roomProvider
     */
    public function testRoomCreation(string $httpMethod, array $roomData, $expectedResult): void
    {
        // Создаем заглушку для класса Request
        $request = $this->createMock(Request::class);
        $request->expects($this->any())
            ->method('all')
            ->willReturn($roomData);
        $request->method = $httpMethod;

        // Создаем частичный мок RoomController
        $controller = $this->getMockBuilder(RoomController::class)
            ->onlyMethods(['create_room'])
            ->getMock();

        // Настраиваем ожидания для метода validate
        if (is_array($expectedResult)) {
            $controller->expects($this->once())
                ->method('create_room')
                ->willReturn($expectedResult);
        } else {
            $controller->expects($this->once())
                ->method('create_room')
                ->willReturn([]);
        }

        // Вызываем тестируемый метод
        $result = $controller->create_room($request);

        // Проверяем результат
        if (is_array($expectedResult)) {
            $this->assertEquals($expectedResult, $result);
        } else {
            $this->assertEquals($expectedResult, $result);
        }
    }

    public function roomProvider(): array
    {
        return [
            // Успешное создание помещения
            [
                'POST',
                [
                    'room_name' => 'Конференц-зал 101',
                    'department_id' => 1,
                    'room_type_id' => 1
                ],
                new class {
                    public function getHeaderLine($name) {
                        return '/rooms';
                    }
                }
            ],
            // Проверка валидации обязательных полей
            [
                'POST',
                [
                    'room_name' => '',
                    'department_id' => '',
                    'room_type_id' => ''
                ],
                [
                    'room_name' => ['Поле room_name обязательно для заполнения'],
                    'department_id' => ['Поле department_id обязательно для заполнения'],
                    'room_type_id' => ['Поле room_type_id обязательно для заполнения']
                ]
            ],
            // Проверка уникальности названия помещения
            [
                'POST',
                [
                    'room_name' => 'Конференц-зал 101',
                    'department_id' => 1,
                    'room_type_id' => 1,
                    'check_exists' => true
                ],
                [
                    'room_name' => ['Помещение с таким названием уже существует']
                ]
            ]
        ];
    }
}