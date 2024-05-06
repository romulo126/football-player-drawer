<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\SoccerTeam;

class SoccerTeamRepository extends BaseRepository
{
    public function model()
    {
        return SoccerTeam::class;
    }
}