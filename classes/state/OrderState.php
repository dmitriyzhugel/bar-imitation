<?php
namespace classes\state;

/**
 * Class OrderState - класс состояния - выпивает и заказывает музыку
 * @package classes
 * @author Dmitriy Zhugel <dzhugel@mail.ru>
 */
class OrderState extends State
{
    public function goDance(): void
    {
        $this->bar_client->changeState(new DanceState());
    }

    public function goDrink(): void
    {
        $this->bar_client->changeState(new DrinkState());
    }

    public function checkCurrentTrack(): void
    {
        if (!$this->bar_client->isOrderFlag()) {
            $this->bar_client->setOrderFlag(true);
        } else {
            parent::checkCurrentTrack();
        }
    }

    public function getDescription(): string
    {
        return "Клиент {$this->bar_client->getName()} выпивает и заказывает музыку." . PHP_EOL;
    }
}
