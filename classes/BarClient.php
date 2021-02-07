<?php
namespace classes;

/**
 * Class BarClient - сущность - клиент бара
 * @package classes
 */
class BarClient
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var array
     */
    protected array $genres = [];

    protected string $order_genre = '';

    /**
     * @var State Ссылка на текущее состояние Контекста.
     */
    private $state;

    public function __construct(string $name, array $genres)
    {
        $this->name = $name;
        $this->genres = $genres;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getGenres(): array
    {
        return $this->genres;
    }

    /**
     * @param array $genres
     */
    public function setGenres(array $genres): void
    {
        $this->genres = $genres;
    }

    /**
     * Проверка на любимый жанр
     * @param string $genre
     * @return bool
     */
    public function checkFavoriteGenre(string $genre): bool
    {
        return in_array($genre, $this->genres);
    }

    /**
     * Заказать музыку
     * @param string $genre
     */
    public function orderMusic(string $genre): void
    {
        Storage::getInstance()->setCurrentGenre($genre);
    }
}
