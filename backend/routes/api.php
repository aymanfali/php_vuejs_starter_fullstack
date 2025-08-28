<?php

use App\Core\DotEnv;
use App\Core\Router;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\DashboardAboutController;
use App\Http\Controllers\Dashboard\DashboardContactsController;
use App\Http\Controllers\Dashboard\DashboardHomeController;

$base = DotEnv::env('APP_URL');

// grouping helper function
function group(string $prefix, $callback)
{
    $callback($prefix);
}

/**
 * ==============
 * AUTH ROUTES
 * ==============
 */
group($base . '/auth', function ($prefix) {
    Router::post("$prefix/login", [AuthController::class, 'login']);
    Router::post("$prefix/register", [AuthController::class, 'register']);
    Router::get("$prefix/check", [AuthController::class, 'checkSession']);
    Router::get("$prefix/logout", [AuthController::class, 'logout']);
});

/**
 * ==============
 * DASHBOARD ROUTES
 * ==============
 */
group($base . '/dashboard', function ($prefix) {
    Router::get($prefix, [DashboardHomeController::class, 'index']);

    // Users
    group($prefix . '/users', function ($p) {
        Router::get($p, [UserController::class, 'index']);
        Router::get("$p/{id}", [UserController::class, 'index']);
        Router::post($p, [UserController::class, 'store']);
        Router::post("$p/update/{id}", [UserController::class, 'update']);
        Router::post("$p/delete/{id}", [UserController::class, 'delete']);
    });

    // Contacts
    group($prefix . '/contacts', function ($p) {
        Router::get($p, [DashboardContactsController::class, 'index']);
        Router::get("$p/{id}", [DashboardContactsController::class, 'index']);
        Router::post("$p/delete/{id}", [DashboardContactsController::class, 'delete']);
    });

    // About Us
    group($prefix . '/about_us', function ($p) {
        Router::get("$p/{id}", [DashboardAboutController::class, 'index']);
        Router::post("$p/update/{id}", [DashboardAboutController::class, 'update']);
    });
});

/**
 * ==============
 * PUBLIC WEBSITE ROUTES
 * ==============
 */
group($base, function ($prefix) {
    // About
    Router::get("$prefix/about_us", [AboutController::class, 'show']);

    // Contacts
    Router::post("$prefix/contacts", [ContactController::class, 'store']);
});
