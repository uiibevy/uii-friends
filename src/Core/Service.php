<?php

namespace Uiibevy\Friends\Core;

use Illuminate\Config\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Uiibevy\Friends\Exceptions\ServiceNotFound;
use Uiibevy\Friends\Services\Contracts\ServiceContract;

class Service implements ServiceContract
{
    use AuthorizesRequests;

    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Foundation\Application|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private Repository|Application|\Illuminate\Contracts\Foundation\Application|array $config;
    private string $service;

    public function __construct(string $service = null)
    {
        $this->config = config('friends');
        $this->service = $service ?? $this->guessServiceName();
    }

    private function guessServiceName(): string
    {
        return str(str(get_class($this))->explode('\\')->last())->replace('Service', '')->lower()->value();
    }

    /**
     * @param string $service
     *
     * @return \Uiibevy\Friends\Services\Contracts\ServiceContract
     * @throws \Uiibevy\Friends\Exceptions\ServiceNotFound
     */
    public static function load(string $service): ServiceContract
    {
        $driver = config('friends.systems.driver', 'default');
        $services = config('friends.systems' . $driver . '.services', []);
        if (!in_array($service, $services)) {
            throw new ServiceNotFound($service);
        }
        return app($service);
    }

    public function fireEvent(string $event, ...$attributes): void
    {
        event($this->getEventModel($event, ...$attributes));
    }

    public function getEventModel(string $event, ...$attributes): UiiEventContract
    {
        $class = $this->getEvent($event);
        return new $class(...$attributes);
    }

    public function getEvent(string $event): string
    {
        return $this->getEvents()[ $event ];
    }

    public function getEvents(): array
    {
        return $this->getServiceConfig()[ 'events' ];
    }

    public function getServiceConfig(): array
    {
        return $this->getDriverConfig()[ 'services' ][ $this->service ];
    }

    public function getDriverConfig(): array
    {
        return $this->config[ 'systems' ][ $this->getDriver() ];
    }

    public function getDriver(): string
    {
        return $this->config[ 'systems' ][ 'driver' ];
    }

    public function getQuery(): Builder|Contract
    {
        return $this->getModelInstance()->newQuery();
    }

    public function getModelInstance(...$attributes): Model
    {
        $class = $this->getModel();
        return new $class(...$attributes);
    }

    public function getModel(): string
    {
        return $this->getServiceConfig()[ 'model' ];
    }
}
