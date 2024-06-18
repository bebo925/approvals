<?php

namespace Bebo925\Approvals\Traits;

use Bebo925\Approvals\Approval;
use Bebo925\Approvals\ApprovalStep;
use Bebo925\Approvals\Enums\ApprovalStatus;

trait HasApprovals
{
    public static function approvalSteps()
    {
        return ApprovalStep::where('approvable_class', static::class)
            ->with('users')
            ->orderBy('order')
            ->get();
    }

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function pendingApprovals()
    {
        return $this->approvals()->notApproved();
    }

    public function generateApprovals()
    {
        $this->approvalSteps()
            ->each(function (ApprovalStep $approvalStep) {
                $approval = $this->approvals()->create([
                    'approval_step_id' => $approvalStep->id,
                    'status' => ApprovalStatus::PENDING,
                ]);

                $approval->users()->sync($approvalStep->users->pluck('id'));
            });
    }

    public function isApproved()
    {
        if ($this->approvals->isEmpty()) {
            return false;
        }

        return $this->approvals->every(function (Approval $approval) {
            return $approval->status === ApprovalStatus::APPROVED;
        });
    }

    public function isPending()
    {
        return $this->approvals->whereNot('status', ApprovalStatus::APPROVED)->isNotEmpty();
    }

    public function isRejected()
    {
        return $this->approvals->contains('status', ApprovalStatus::REJECTED);
    }
}
