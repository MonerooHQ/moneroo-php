<?php

namespace Moneroo\Payout;

final class Status
{
    /**
     * The payout has been initiated.
     * This is transactional state and will change.
     */
    public const INITIATED = 'initiated';

    /**
     * The payout is pending, waiting for confirmation from PSP.
     *
     * This is transactional state and will change.
     */
    public const PENDING = 'pending';

    /**
     * The payout has failed.
     *
     * This is final state.
     */
    public const FAILED = 'failed';
}
