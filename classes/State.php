<?php
namespace classes;

use RefactoringGuru\State\Conceptual\Context;

/**
 * Базовый класс Состояния объявляет методы, которые должны реализовать все
 * Конкретные Состояния, а также предоставляет обратную ссылку на объект
 * Контекст, связанный с Состоянием. Эта обратная ссылка может использоваться
 * Состояниями для передачи Контекста другому Состоянию.
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

    abstract public function checkCurrentTrack(): void;
}
