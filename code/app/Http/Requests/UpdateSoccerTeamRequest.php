<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\SoccerPlayer;
use App\Models\SoccerTeam;

class UpdateSoccerTeamRequest extends FormRequest
{
    private int $totalPlayer;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'string',
                'max:255',
            ],
            'players' => [
                'sometimes',
                'integer',
                'min:1',
                $this->validatePlayers(),
                $this->validateTotalPlayers(),
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'O nome deve ser um texto.',
            'name.max' => 'O nome não pode ter mais que 255 caracteres.',
            'players.integer' => 'O número de jogadores deve ser um número inteiro.',
            'players.min' => 'O número de jogadores deve ser pelo menos 1.',
        ];
    }

    private function validatePlayers()
    {
        return function ($attribute, $value, $fail) {
            $this->totalPlayer = SoccerPlayer::count();
            if ($value > $this->totalPlayer) {
                $fail("O número de jogadores por equipe não pode ser maior que o número total de jogadores".
                    " registrados, que atualmente é de $this->totalPlayer.");
            }
        };
    }

    private function validateTotalPlayers()
    {
        return function ($attribute, $value, $fail) {
            $teamId = $this->route('id');
            $team = SoccerTeam::find($teamId);

            if (! $team) {
                $fail("Equipe não encontrada.");
                return;
            }

            $currentTotalTeamPlayers = SoccerTeam::sum('players');
            $currentPlayersInTeam = $team->players;
            $adjustedTotalTeamPlayers = $currentTotalTeamPlayers - $currentPlayersInTeam;
            $newTotalTeamPlayers = $adjustedTotalTeamPlayers + $value;

            if ($newTotalTeamPlayers > $this->totalPlayer) {
                $fail("A soma total dos jogadores em todos os times ($newTotalTeamPlayers) não pode exceder o número".
                " total de jogadores disponíveis ($this->totalPlayer).");
            }
        };
    }
}
