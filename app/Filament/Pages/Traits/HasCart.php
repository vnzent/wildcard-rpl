<?php

namespace App\Filament\Pages\Traits;

use App\Models\Cart;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait HasCart
{
    public function removeFromCart(mixed $id): self
    {
        Cart::query()->where('id', $id)->delete();
        $this->notify(trans('filament-pos::messages.notifications.delete.message'));

        return $this;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function clearCart(): self
    {
        Cart::query()->where('session_id', session()->get('sessionID'))->delete();
        $this->notify(trans('filament-pos::messages.notifications.clear.message'));

        return $this;
    }
}
