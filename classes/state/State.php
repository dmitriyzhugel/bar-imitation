<?php
namespace classes\state;

use classes\BarClient;
use classes\Storage;

/**
 * Class State
 *
 * Базовый класс Состояния объявляет методы, которые должны реализовать все
 * Конкретные Состояния, а также предоставляет обратную ссылку на объект
 * Контекст, связанный с Состоянием. Эта обратная ссылка может использоваться
 * Состояниями для передачи Контекста другому Состоянию.
 *
 * @package classes
 */
abstract class State
{
    /**
     * @var BarClient
     */
    protected $bar_client;

    public function setContext(BarClient $bar_client)
    {
        $this->bar_client = $bar_client;
    }

    abstract public function goDance(): void;

    abstract public function goDrink(): void;

    abstract public function getDescription(): string;

    public function checkCurrentTrack(): void
    {
        $storage = Storage::getInstance();
        if ($this->bar_client->checkFavoriteGenre($storage->getCurrentGenre())) {
            $this->goDance();
        } else {
            $this->goDrink();
        }
    }
}
