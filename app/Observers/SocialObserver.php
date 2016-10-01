<?php

namespace larashop\Observers;

use larashop\Social;

class SocialObserver {

    public function created(Social $social) {

        $this->handleRegisteredEvent('created', $social);
    }

    protected function handleRegisteredEvent($event, Social $social)
    {
        $class = config("social.events.{$social->service}.{$event}", null);
        
        if($class === null) {
            return;
        }

        event(new $class($social->user()->first()));
    }
}