<?php

namespace Modules\User\app\Repository;

use App\Repositories\Repository;
use Modules\User\app\Models\BlockedAccount;

class BlockedAccountRepository extends Repository
{
    protected string $modelClass = BlockedAccount::class;
}
