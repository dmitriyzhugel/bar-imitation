<?php
namespace classes\state;

/**
 * Class DanceState - класс состояния - на танцполе
 * @package classes
 * @author Dmitriy Zhugel <dzhugel@mail.ru>
 */
class DanceState extends State
{
    public function goDance(): void
    {
        //do nothing
    }

    public function goDrink(): void
    {
        $this->bar_client->changeState(new DrinkState());
    }

    public function getDescription(): string
    {
        return "Клиент {$this->bar_client->getName()} танцует на танцполе." . PHP_EOL;
    }
}
