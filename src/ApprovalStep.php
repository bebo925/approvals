<?php

namespace bebo925\Approvals;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ApprovalStep extends Model
{
    protected $guarded = [];

    public function assignments(): Collection
    {
        $model = $this->approver_type::find($this->approver_id);
        $method = config('approvals.mappings.' . $this->approver_type);

        if (is_null($method)) {
            return new Collection([$model]);
        }

        return $model->$method;
    }
}
