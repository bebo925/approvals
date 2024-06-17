<?php

namespace Bebo925\Approvals\Traits;

use Bebo925\Approvals\Approval;
use Bebo925\Approvals\ApprovalStep;
use Bebo925\Approvals\Enums\ApprovalStatus;

trait HasApprovals
{
    public function approvalSteps()
    {
        return ApprovalStep::where('approvable_class', static::class)
            ->orderBy('order')
            ->get();
    }

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function generateApprovalSteps()
    {
        $this->approvalSteps()
            ->each(function (ApprovalStep $approvalStep) {
                $this->approvals()->create([
                    'approval_step_id' => $approvalStep->id,
                ]);
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
