<?php

namespace Modules\Core\Models;

use Modules\Core\Models\Move as BaseMove;
use Modules\Core\Models\MoveLine;

class Invoice extends BaseMove
{
    public function paymentTermLine()
    {
        return $this->hasOne(MoveLine::class, 'move_id')
            ->where('display_type', 'payment_term');
    }
}
