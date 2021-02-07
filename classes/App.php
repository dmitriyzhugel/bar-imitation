<?php
namespace classes;

/**
 * Class App - контейнер приложения
 * @package classes
 * @author Dmitriy Zhugel <dzhugel@mail.ru>
 */
class App
{
    /**
     * Объект одиночки храниться в статичном поле класса. Это поле — массив, так
     * как мы позволим нашему Одиночке иметь подклассы. Все элементы этого
     * массива будут экземплярами кокретных подклассов Одиночки. Не волнуйтесь,
     * мы вот-вот познакомимся с тем, как это работает.
     */
    private static $instances = [];

    /**
     * Конструктор Одиночки всегда должен быть скрытым, чтобы предотвратить
     * создание объекта через оператор new.
     */
    protected function __construct() { }

    /**
     * Одиночки не должны быть клонируемыми.
     */
    protected function __clone() { }

    /**
     * Одиночки не должны быть восстанавливаемыми из строк.
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    /**
     * Это статический метод, управляющий доступом к экземпляру одиночки. При
     * первом запуске, он создаёт экземпляр одиночки и помещает его в
     * статическое поле. При последующих запусках, он возвращает клиенту объект,
     * хранящийся в статическом поле.
     *
     * Эта реализация позволяет вам расширять класс Одиночки, сохраняя повсюду
     * только один экземпляр каждого подкласса.
     * @return App
     */
    public static function getInstance(): App
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    /**
     * Запуск приложения
     */
    public function run(): void
    {
        global $argv;

        $clients_file = isset($argv[1]) ? $argv[1] : false;
        if (empty($clients_file)) {
            throw new \Exception("Cannot read client's file");
        }

        $storage = Storage::getInstance();
        $storage->readClientsFile($clients_file);
        $clients = $storage->getClients();

        $timeline_buf = [];
        foreach ($clients as $client) {

            $order_genre = $client->getOrderGenre();
            // Клиент заказывает музыку
            $client->orderMusic($order_genre);
            $timeline_buf[] = $client;
            print "Welcome " . $client->getName() . "!" . PHP_EOL;

            if (!empty($timeline_buf)) {
                foreach ($timeline_buf as $tmp_client) {
                    $tmp_client->checkCurrentTrack();
                    print $tmp_client->getDescription();
                }
                print "\n";
            }
        }
    }
}
