<?php


namespace App\Support;


class Role
{
    //admin Privilege
    const ROOT = 'root';
    const ADMIN = 'admin';


    //other Privilege

    const OTHER = 'other';

    const ALL = [
        Role::OTHER,
        Role::ADMIN,
        Role::ROOT,
    ];
}
