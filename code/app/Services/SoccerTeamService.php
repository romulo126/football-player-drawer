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
        $jogadoresConfirmados = $this->repositorySoccerPlayer->getConfirmedPlayers()->sortByDesc('skill_level');
        $goalkeeper = $jogadoresConfirmados->where('goalkeeper', true);
        $jogadoresLinha = $jogadoresConfirmados->where('goalkeeper', false)->shuffle();

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
                    'total_goalkeeper' => 1,
                    ]
                ];
        });

        foreach ($goalkeeper as $jogador) {
            if (! $this->allocatePlayers($jogador, $distribuicao, true)) {
                throw new Exception("Não há espaço suficiente nas equipes para alocar o goleiro.");
            }
        }

        foreach ($jogadoresLinha as $jogador) {
            if (! $this->allocatePlayers($jogador, $distribuicao)) {
                throw new Exception("Não há espaço suficiente nas equipes existentes para alocar todos os jogadores.");
            }
        }
        
        
        return $distribuicao;
    }

    private function allocatePlayers($jogador, &$distribuicao, $is_goalkeeper = false)
    {
        $allocated = false;
        $distribuicao->each(function ($dadosEquipe, $id) use (&$allocated, $jogador, &$distribuicao, $is_goalkeeper) {
            if ($is_goalkeeper && ! $allocated && $dadosEquipe['jogadores']->count() < $dadosEquipe['total_goalkeeper']) {
                $distribuicao[$id]['jogadores']->push($jogador->name);
                $allocated = true;
            } elseif (! $allocated && $dadosEquipe['jogadores']->count() < $dadosEquipe['total_permitido'] && ! $is_goalkeeper) {
                $distribuicao[$id]['jogadores']->push($jogador->name);
                $allocated = true;
            }
        });
        
        return $allocated;
    }
}