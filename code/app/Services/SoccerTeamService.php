<?php

namespace App\Services;

use App\Repositories\SoccerTeamRepository;
use App\Repositories\SoccerPlayerRepository;
use Illuminate\Support\Arr;
use Exception;

class SoccerTeamService
{
    private SoccerTeamRepository $repository;
    private SoccerPlayerRepository $repositorySoccerPlayer;

    public function __construct(SoccerTeamRepository $repository, SoccerPlayerRepository $repositorySoccerPlayer)
    {
        $this->repository = $repository;
        $this->repositorySoccerPlayer = $repositorySoccerPlayer;
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

    public function all()
    {
        return optional($this->repository->all())->shuffle();
    }

    public function drawPlayers() 
    {
        $jogadoresConfirmados = $this->repositorySoccerPlayer->getConfirmedPlayers()
            ->shuffle();

        if (empty($jogadoresConfirmados)) {
            throw new Exception("Não existe usuarios confirmados");
        }

        $equipes = optional($this->repository->all());

        if ($equipes->count() < 2) {
            throw new Exception("Precisa de pelo menos duas equipes para realizar o sorteio.");
        }

        $distribuicao = $equipes->mapWithKeys(function ($equipe) {
            return [
                $equipe->name => [
                    'jogadores' => collect(),
                    'total_permitido' => $equipe->players,
                    ]
                ];
        });

        foreach ($jogadoresConfirmados as $jogador) {
            if (! $this->allocatePlayers($jogador, $distribuicao)) {
                throw new Exception("Não há espaço suficiente nas equipes existentes para alocar todos os jogadores.");
            }
        }
        
        
        return $distribuicao;
    }

    private function allocatePlayers($jogador, &$distribuicao)
    {
        $allocated = false;
        $distribuicao->each(function ($dadosEquipe, $id) use (&$allocated, $jogador, &$distribuicao) {
            if (!$allocated && $dadosEquipe['jogadores']->count() < $dadosEquipe['total_permitido']) {
                $distribuicao[$id]['jogadores']->push($jogador->name);
                $allocated = true;
            }
        });
        
        return $allocated;
    }
}