<?php
namespace classes;

use classes\state\OrderState;

class Storage
{
    /**
     * @var array
     */
    private static $instances = [];

    /**
     * @var array
     */
    private static $clients = [];

    /**
     * Текущий жанр музыки на танцполе
     * @var string
     */
    private static $current_genre = '';

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
     * @return Storage
     */
    public static function getInstance(): Storage
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    /**
     *
     * @param $clients_file
     * @return bool
     */
    public function readClientsFile($clients_file): bool
    {
        if (($handle = fopen($clients_file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, " ")) !== FALSE) {
                $name = $data[0] ?? '';
                $genres = $data[1] ?? '';
                $order_genre = $data[2] ?? '';
                if (!empty($name) && !empty($genres)) {
                    $genres_list = explode(';', $genres);
                    $bar_client = new BarClient($name, $genres_list, $order_genre, new OrderState());
                    // Добавление клиента в список
                    static::addClient($bar_client);
                }
            }
            fclose($handle);
        }

        return true;
    }

    /**
     * Добавляет клиента в бар
     * @param BarClient $bar_client
     */
    public function addClient(BarClient $bar_client): void
    {
        self::$clients[] = $bar_client;
    }

    /**
     * Получить всех клиентов в баре
     * @return array
     */
    public function getClients(): array
    {
        return self::$clients;
    }

    /**
     * Поставить музыку на танцпол
     * @param string $genre
     */
    public function setCurrentGenre(string $genre): void
    {
        self::$current_genre = $genre;
    }

    /**
     * Получить текущий играющий жанр
     * @return string
     */
    public function getCurrentGenre(): string
    {
        return self::$current_genre;
    }
}
