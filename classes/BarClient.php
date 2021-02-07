<?php
namespace classes;

use classes\state\State;
use classes\state\DanceState;
use classes\state\DrinkState;

/**
 * Class BarClient - сущность - клиент бара
 * @package classes
 * @author Dmitriy Zhugel <dzhugel@mail.ru>
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

    /**
     * @var string
     */
    protected string $order_genre = '';

    /**
     * @var State Ссылка на текущее состояние Контекста.
     */
    private State $state;

    /**
     * @var bool Признак заказа музыки
     */
    private bool $order_flag = false;

    public function __construct(string $name, array $genres, string $order_genre, State $state)
    {
        $this->name = $name;
        $this->genres = $genres;
        $this->order_genre = $order_genre;
        $this->changeState($state);
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
     * @return string
     */
    public function getOrderGenre(): string
    {
        return $this->order_genre;
    }

    /**
     * @param string $order_genre
     */
    public function setOrderGenre(string $order_genre): void
    {
        $this->order_genre = $order_genre;
    }

    /**
     * @return bool
     */
    public function isOrderFlag(): bool
    {
        return $this->order_flag;
    }

    /**
     * @param bool $order_flag
     */
    public function setOrderFlag(bool $order_flag): void
    {
        $this->order_flag = $order_flag;
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

    /**
     * Контекст позволяет изменять объект Состояния во время выполнения.
     * @param State $state
     */
    public function changeState(State $state): void
    {
        $this->state = $state;
        $this->state->setContext($this);
    }

    /**
     * Проверка текущего играющего жанра
     */
    public function checkCurrentTrack(): void
    {
        $this->state->checkCurrentTrack();
    }

    /**
     * Клиент идет танцевать
     */
    public function goDance(): void
    {
        $this->changeState(new DanceState());
    }

    /**
     * Клиент идет в бар
     */
    public function goDrink(): void
    {
        $this->changeState(new DrinkState());
    }

    /**
     * Описание деятельности клиента бара
     * @return string
     */
    public function getDescription(): string
    {
        return $this->state->getDescription();
    }
}
