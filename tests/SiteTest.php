<?php
use PHPUnit\Framework\TestCase;
use Model\Subscriber;
use Model\Phone;
use Model\Department;
use Src\View;
use Controller\Site;

class SiteTest extends TestCase
{
    /**
     * @dataProvider subscriberDataProvider
     */
    public function testSubscriberFunction(
        int $id,
        ?Subscriber $subscriber,
        array $phones,
        ?string $departmentName,
        string $expectedResultType,
        ?string $expectedException = null
    ): void {
        if ($expectedException) {
            $this->expectException($expectedException);
        }

        // Мокируем запросы к базе данных
        Subscriber::shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn($subscriber);

        if ($subscriber) {
            Phone::shouldReceive('where')
                ->once()
                ->with('subscriber_id', $id)
                ->andReturnSelf();

            Phone::shouldReceive('get')
                ->once()
                ->andReturn(collect($phones));

            Department::shouldReceive('find')
                ->once()
                ->with($subscriber->department_id)
                ->andReturn(
                    $departmentName ? (object)['department_name' => $departmentName] : null
                );
        }

        // Вызываем тестируемую функцию
        $result = subscriber($id);

        // Проверяем тип результата
        $this->assertInstanceOf($expectedResultType, $result);

        // Если это View, проверяем переданные данные
        if ($expectedResultType === View::class) {
            $viewData = $result->getData();

            $this->assertEquals($subscriber, $viewData['subscriber']);
            $this->assertEquals($departmentName, $viewData['departmentName']);
            $this->assertEquals($phones, $viewData['phones']->toArray());
        }
    }

    public function subscriberDataProvider(): array
    {
        return [
            // Абонент существует, есть телефоны и отдел
            [
                1,
                new Subscriber(['id' => 1, 'department_id' => 1]),
                [new Phone(), new Phone()],
                'IT Department',
                View::class
            ],
            // Абонент существует, нет телефонов
            [
                2,
                new Subscriber(['id' => 2, 'department_id' => 2]),
                [],
                'HR Department',
                View::class
            ],
            // Абонент не существует
            [
                999,
                null,
                [],
                null,
                View::class,
                \Exception::class
            ],
            // Абонент существует, но отдел не найден
            [
                3,
                new Subscriber(['id' => 3, 'department_id' => 999]),
                [new Phone()],
                null,
                View::class,
                \Exception::class
            ],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Инициализация приложения (если нужно)
        $_SERVER['DOCUMENT_ROOT'] = '/xampp/htdocs/my-pop-it-mvc/tests';

        $GLOBALS['app'] = new Src\Application(new Src\Settings([
            'app' => include $_SERVER['DOCUMENT_ROOT'] . '/config/app.php',
            'db' => include $_SERVER['DOCUMENT_ROOT'] . '/config/db.php',
            'path' => include $_SERVER['DOCUMENT_ROOT'] . '/config/path.php',
        ]));
    }
}