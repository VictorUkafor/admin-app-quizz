<?php
namespace App\Helpers;


class EventHelper {

    const EVENTS = [
        [
            "name" => "User Created Event",
            "event" => "user_created",
        ],
        [
            "name" => "User Updated Event",
            "event" => "user_updated",
        ],
        [
            "name" => "Subscription Update Event",
            "event" => "subscription_update",
        ]
    ];

    const USER_CREATED = 'user_created';
    const USER_UPDATED = 'user_updated';
    const SUBSCRIPTION_UPDATE = 'subscription_update';
}
