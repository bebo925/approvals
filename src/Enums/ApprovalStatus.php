<?php

namespace Bebo925\Approvals\Enums;

enum ApprovalStatus: string
{
    case APPROVED = 'approved';
    case PENDING = 'pending';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::PENDING => 'Pending',
        };
    }
}
