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
        return $this->approvals()->pending();
    }

    public function generateApprovals()
    {
        $this->approvalSteps()
            ->each(function (ApprovalStep $approvalStep) {
                $approval = $this->approvals()->create([
                    'approval_step_id' => $approvalStep->id,
                ]);

                $approval->users()->sync($approvalStep->users->pluck('id'));
            });
    }

    public function isApproved()
    {
        return $this->approvals->every(function (Approval $approval) {
            return $approval->status === ApprovalStatus::APPROVED;
        });
    }

    public function isRejected()
    {
        return $this->approvals->contains('status', ApprovalStatus::REJECTED);
    }
}
