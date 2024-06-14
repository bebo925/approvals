<?php

namespace bebo925\Approvals\Traits;

use bebo925\Approvals\Approval;
use bebo925\Approvals\Enums\ApprovalStatus;

trait HasApprovals
{
    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
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
