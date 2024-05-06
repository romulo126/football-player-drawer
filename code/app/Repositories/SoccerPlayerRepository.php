<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\SoccerPlayer;

class SoccerPlayerRepository extends BaseRepository
{
    public function model()
    {
        return SoccerPlayer::class;
    }

    public function getConfirmedPlayers() {
        return $this->model->select(['name', 'goalkeeper', 'skill_level'])->where('confirmed', true)->get();
    }
}