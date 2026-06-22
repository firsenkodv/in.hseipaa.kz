<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poll extends Model
{
    protected $fillable = [
        'title',
        'questions',
        'is_active',
        'for_all',
        'city_ids',
        'has_tariff',
        'person_type',
        'is_specialist',
        'is_expert',
        'is_lecturer',
    ];

    protected function casts(): array
    {
        return [
            'questions'    => 'array',
            'city_ids'     => 'array',
            'is_active'    => 'boolean',
            'for_all'      => 'boolean',
            'has_tariff'   => 'boolean',
            'is_specialist' => 'boolean',
            'is_expert'    => 'boolean',
            'is_lecturer'  => 'boolean',
        ];
    }

    public function responses(): HasMany
    {
        return $this->hasMany(PollResponse::class);
    }

    public function responseByUser(int $userId): ?PollResponse
    {
        return $this->responses()->with('answers')->where('user_id', $userId)->first();
    }

    public function hasRespondedBy(int $userId): bool
    {
        return $this->responses()->where('user_id', $userId)->exists();
    }

    public function isEligible(User $user): bool
    {
        if ($this->for_all) {
            return true;
        }

        if (!empty($this->city_ids) && $user->user_city_id && in_array($user->user_city_id, $this->city_ids)) {
            return true;
        }

        if ($this->has_tariff && $user->has_tarif) {
            return true;
        }

        if ($this->person_type === 'individual' && $user->individual) {
            return true;
        }

        if ($this->person_type === 'legal' && $user->legal_entity) {
            return true;
        }

        if ($this->is_specialist && $user->UserSpecialist()->exists()) {
            return true;
        }

        if ($this->is_expert && $user->UserExpert()->exists()) {
            return true;
        }

        if ($this->is_lecturer && $user->UserLecturer()->exists()) {
            return true;
        }

        return false;
    }
}
