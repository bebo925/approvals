<?php

namespace Bebo925\Approvals\Commands;

use Illuminate\Console\Command;

class ApprovalsCommand extends Command
{
    public $signature = 'approvals';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
