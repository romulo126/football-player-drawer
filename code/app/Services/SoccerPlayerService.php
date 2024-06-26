<?php

namespace App\Services;

use App\Repositories\SoccerPlayerRepository;

class SoccerPlayerService
{
    private SoccerPlayerRepository $repository;

    public function __construct(SoccerPlayerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        return optional($this->repository->create($data))->toArray();
    }

    public function update(array $data, $id)
    {
        return $this->repository->update($data, $id);
    }

    public function delete($id)
    {
        return (bool) $this->repository->delete($id);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function getConfirmedPlayers()
    {
        return optional($this->repository->getConfirmedPlayers())->toArray();
    }

    public function getNotConfirmedPlayers()
    {
        return optional($this->repository->getNotConfirmedPlayers())->toArray();
    }

    public function all()
    {
        return optional($this->repository->all())->toArray();
    }
}