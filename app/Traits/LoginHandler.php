<?php

namespace App\Traits;

use Agent;
use App\User;

trait LoginHandler
{
    public function calcLoginToken(User $user, $ip)
    {
        $userID = md5($user->id);
        $browserInfo = md5(Agent::browser());
        $ip = md5($ip);
        $timestamp = md5(now());
        return "$userID.$browserInfo.$ip.$timestamp";
    }

    public function getTokenWithoutTimestamp($currentToken)
    {
        $token = explode('.', $currentToken);
        unset($token[3]);
        return implode('.', $token);
    }
}
