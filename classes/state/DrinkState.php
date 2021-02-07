<?php
namespace classes\state;

/**
 * Class DrinkState - класс состояния - в баре
 * @package classes
 * @author Dmitriy Zhugel <dzhugel@mail.ru>
 */
class DrinkState extends State
{
    public function goDance(): void
    {
        $this->bar_client->changeState(new DanceState());
    }

    public function goDrink(): void
    {
        //do nothing
    }

    public function getDescription(): string
    {
        return "Клиент {$this->bar_client->getName()} пьет коктейли в баре." . PHP_EOL;
    }
}
