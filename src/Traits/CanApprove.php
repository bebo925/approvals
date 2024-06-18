<?php

namespace Bebo925\Approvals\Traits;

use Bebo925\Approvals\Approval;

trait CanApprove
{
    public function approvals()
    {
        return $this->belongsToMany(Approval::class);
    }
}
