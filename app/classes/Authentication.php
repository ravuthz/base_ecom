<?php

class Authentication {

    private $user;
    private $timeOut = 1800;
    private $sessionAuthUser = 'auth_user';
    private $sessionAuthTime = 'auth_time';

    const DAY = 86400;
    const HOUR = 3600;
    const MINUTE = 60;

    public function __contstruct($userSessionName = null, $timeSessionName = null, $timeOut = null) {
        if ($userSessionName != null) {
            $this->sessionAuthUser = $userSessionName;
        }
        if ($timeSessionName != null) {
            $this->sessionAuthTime = $timeSessionName;
        }
        if ($timeOut != null) {
            $this->timeOut = $timeOut;
        }
        $this->checkUserSession();
    }

    private function checkUserSession() {
        if (isset($_SESSION[$this->sessionAuthUser])) {
            $this->user = $_SESSION[$this->sessionAuthUser];
        } else {
            $this->user = new User();
//            $user = new stdClass();
//            $user->id = 0;
//            $user->name = '';
//            $user->email = '';
//            $user->status = 0;
//            $user->username = '';
//            $this->user = $user;
        }
    }

    public function isLoginSessionExpired() {
        $this->checkUserSession();
        if (isset($_SESSION[$this->sessionAuthTime]) && isset($_SESSION[$this->sessionAuthUser])) {
            if ( (time() - $_SESSION[$this->sessionAuthTime]) > $this->timeOut ) {
                return true;
            }
        }
        return false;
    }

    public function isGuest() {
        return $this->isLoginSessionExpired();
    }

    public function isAdmin() {
        if ($this->isLoginSessionExpired() === false) {
            return $this->user->role == 'admin';
        }
        return false;
    }

    public function isSeller() {
        if ($this->isLoginSessionExpired() === false) {
            return $this->user->role == 'seller';
        }
        return false;
    }

    public function isCustomer() {
        if ($this->isLoginSessionExpired() === false) {
            return $this->user->role == 'customer';
        }
        return false;
    }

    public function isLoggedIn() {
        if ($this->isLoginSessionExpired() === false) {
            if (!empty($_SESSION[$this->sessionAuthUser])) {
                return true;
            }
        }
        return false;
    }

    public function user() {
        $this->checkUserSession();
        return $this->user;
    }

    /**
     * Setter & Getter for Authorization timeOut
     * @param  [Integer] $time [The session time out value for sessionAuthTime]
     * @return [Object]       [The current time out value or Authorization instanciate]
     */
    public function timeOut($time = null) {
        if ($time != null) {
            $this->timeOut = $time;
            return $this;
        }
        return $this->timeOut;
    }

    public function timeOutInDays($timeInDays = null) {
        if ($timeInDays != null) {
            $this->timeOut($timeInDays * self::DAY);
        }
        return $this->timeOut();
    }

    public function timeOutInHours($timeInHours = null) {
        if ($timeInHours != null) {
            $this->timeOut($timeInHours * self::HOUR);
        }
        return $this->timeOut();
    }

    public function timeOutInMinutes($timeInMinutes = null) {
        if ($timeInMinutes != null) {
            $this->timeOut($timeInMinutes * self::MINUTE);
        }
        return $this->timeOut();
    }

    /**
     * Setter & Getter for Authorization sessionAuthUser
     * @param  [String] $sessionName [The session key name for sessionAuthUser]
     * @return [Object]              [The current session key name or Authorization instanciate]
     */
    public function userSessionName($sessionName = null) {
        if ($sessionName != null) {
            $this->sessionAuthUser = $sessionName;
            return $this;
        }
        return $this->sessionAuthUser;
    }

    /**
     * Setter & Getter for Authorization sessionAuthTime
     * @param  [String] $sessionName [The session key name for sessionAuthTime]
     * @return [Object]              [The current session key name or Authorization instanciate]
     */
    public function timeSessionName($sessionName = null) {
        if ($sessionName != null) {
            $this->sessionAuthTime = $sessionName;
            return $this;
        }
        return $this->sessionAuthTime;
    }
}
