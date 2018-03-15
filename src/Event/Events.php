<?php
namespace App\Event;

/**
 * Class Events
 * @package App\Event
 */
final class Events
{
    const USER_CREATED                      = 'user.created';
    const USER_CONFIRMED                    = 'user.account_confirmed';
    const USER_ACCOUNT_TOKEN_REQUESTED      = 'user.account_token_requested';
    const USER_PASSWORD_REQUESTED           = 'user.password_requested';
    const USER_PASSWORD_SENT                = 'user.new_password_sent';
}
