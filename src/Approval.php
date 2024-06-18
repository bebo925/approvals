<?php

namespace Bebo925\Approvals;

use Illuminate\Database\Eloquent\Model;
use Bebo925\Approvals\Enums\ApprovalStatus;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Approval extends Model
{
    protected $guarded = [];

    public $casts = [
        'status' => ApprovalStatus::class,
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function reject($userId = null): void
    {
        $this->status = ApprovalStatus::REJECTED;
        $this->rejected_at = now();
        $this->rejected_by_id = $userId ?? auth()->id();
        $this->save();
    }

    public function approve($userId = null): void
    {
        $this->status = ApprovalStatus::APPROVED;
        $this->approved_at = now();
        $this->approved_by_id = $userId ?? auth()->id();
        $this->save();
    }

    public function approvable(): MorphTo
    {
        return $this->morphTo();
    }

    public function approvalStep(): BelongsTo
    {
        return $this->belongsTo(ApprovalStep::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function scopePending($query)
    {
        return $query->where(function ($query) {
            $query->whereNull('status')
                ->orWhereNot('status', ApprovalStatus::APPROVED);
        });
    }

    public function scopeApproved($query)
    {
        return $query->where('status',  ApprovalStatus::APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', ApprovalStatus::REJECTED);
    }
}
