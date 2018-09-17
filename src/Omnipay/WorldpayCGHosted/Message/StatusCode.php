<?php

namespace Omnipay\WorldpayCGHosted\Message;

class StatusCode
{
    const AUTHORISED = 'AUTHORISED';
    const CANCELLED = 'CANCELLED';
    const CAPTURED = 'CAPTURED';
    const CHARGED_BACK = 'CHARGED_BACK';
    const CHARGEBACK_REVERSED = 'CHARGEBACK_REVERSED';
    const ERROR = 'ERROR';
    const EXPIRED = 'EXPIRED';
    const INFORMATION_REQUESTED = 'INFORMATION_REQUESTED';
    const INFORMATION_SUPPLIED = 'INFORMATION_SUPPLIED';
    const REFUNDED_FAILED = 'REFUNDED_FAILED';
    const REFUNDED = 'REFUNDED';
    const REFUNDED_BY_MERCHANT = 'REFUNDED_BY_MERCHANT';
    const REFUSED = 'REFUSED';
    const SENT_FOR_AUTHORISATION = 'SENT_FOR_AUTHORISATION';
    const SENT_FOR_REFUND = 'SENT_FOR_REFUND';
    const SETTLED = 'SETTLED';
    const SETTLED_BY_MERCHANT = 'SETTLED_BY_MERCHANT';
}
