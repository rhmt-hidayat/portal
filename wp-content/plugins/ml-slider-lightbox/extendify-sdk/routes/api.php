<?php
/**
 * Api routes
 */

if (!defined('ABSPATH')) {
    die('No direct access.');
}

use Extendify\ExtendifySdk\ApiRouter;
use Extendify\ExtendifySdk\Controllers\PluginController;
use Extendify\ExtendifySdk\Controllers\CategoryController;
use Extendify\ExtendifySdk\Controllers\TemplateController;

\add_action(
    'rest_api_init',
    function () {
        ApiRouter::get('/active-plugins', [PluginController::class, 'active']);
        ApiRouter::get('/plugins', [PluginController::class, 'index']);
        ApiRouter::post('/plugins', [PluginController::class, 'install']);

        ApiRouter::get('/categories', [CategoryController::class, 'index']);
        ApiRouter::post('/templates', [TemplateController::class, 'index']);
        ApiRouter::post('/templates/(?P<template_id>[a-zA-Z0-9-]+)', [TemplateController::class, 'single']);
    }
);
