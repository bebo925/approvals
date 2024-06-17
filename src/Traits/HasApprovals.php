<?php

namespace bebo925\Approvals\Traits;

use bebo925\Approvals\Approval;
use bebo925\Approvals\ApprovalStep;
use bebo925\Approvals\Enums\ApprovalStatus;

trait HasApprovals
{
    public function approvalSteps()
    {
        return $this->hasMany(ApprovalStep::class, 'approvable_type')
            ->where('approvable_id', self::class)
            ->orderBy('order');
    }

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function generateApprovalSteps()
    {
        //Todo: check for existing approvals and do something about it
        ApprovalStep::where('approvable_class', self::class)
            ->orderBy('order')
            ->get()
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
