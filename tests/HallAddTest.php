<?php

use Controller\HallView;
use Model\Hall;
use Model\User;
use PHPUnit\Framework\TestCase;
use Src\Request;


class HallAddTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     * @runInSeparateProcess
     */
    public function testCreate(string $httpMethod, array $userData, string $error): void
    {

        //Выбираем занятый логин из базы данных
        if ($userData['login'] === 'lib') {
            $userData['login'] = User::get()->first()->login;
        }

        // Создаем заглушку для класса Request.
        $request = $this->createMock(\Src\Request::class);
        // Переопределяем метод all() и свойство method
        $request->expects($this->any())
            ->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;

        //Сохраняем результат работы метода в переменную
        $result = (new \Controller\LibView())->lib_add($request);

        if (!empty($result)) {
            //Проверяем варианты с ошибками валидации
            $message = '/' . preg_quote($error, '/') . '/';
            $this->expectOutputRegex($message);
            return;
        }

        //Проверяем добавился ли пользователь в базу данных
        $this->assertTrue((bool)User::where('login', $userData['login'])->count());
        //Удаляем созданного пользователя из базы данных
        User::where('login', $userData->login)->delete();

        $this->assertContains($error, xdebug_get_headers());
    }

    //Метод, возвращающий набор тестовых данных
    static public function additionProvider(): array
    {
        return [
            ['GET', ['name' => '', 'login' => '', 'password' => ''],
                ''
            ],
            ['POST', ['name' => '', 'login' => '', 'password' => ''],
                '{"login":["Поле login пусто"],"name":["Поле name пусто"],"password":["Поле password пусто"]}',
            ],
            ['POST', ['name' => 'qwe123', 'login' => 'qwewewe', 'password' => 'QWEasd1234654'],
                ''
            ],
            ['POST', ['name' => 'q', 'login' => 'q', 'password' => 'q'],
                '{"password":["Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number"]}'
            ],
            ['POST', ['name' => 'q', 'login' => 'admin', 'password' => 'QWEasd123'],
                '{"login":["Field login must be unique"]}'
            ],
            ['POST', ['name' => 'q', 'login' => 'admin', 'password' => 'q'],
                '{"login":["Field login must be unique"],"password":["Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number"]}'
            ],
        ];
    }

    //Настройка конфигурации окружения
    protected function setUp(): void
    {
        //Установка переменых сред
        $_SERVER['DOCUMENT_ROOT'] = "C:xampp/htdocs/server";
        $settings = include $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
        $GLOBALS['app'] = new Src\Application(new Src\Settings([
            'app' => include '../config/app.php',
            'db' => include '../config/db.php',
            'path' => include '../config/path.php',
        ]));
        //Глобальная функция для доступа к объекту приложения
        if (!function_exists('app')) {
            function app()
            {
                return $GLOBALS['app'];
            }
        }
    }
}