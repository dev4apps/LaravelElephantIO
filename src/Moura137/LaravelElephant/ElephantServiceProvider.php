<?php
namespace Moura137\LaravelElephant;

use ElephantIO\Client;
use Moura137\LaravelElephant\LaraElephantIO;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;


class ElephantServiceProvider extends BaseServiceProvider
{
	protected $config;

	/**
	 * Bootstrap the service provider.
	 *
	 * @return void
	 */
    public function boot()
    {
        $this->package('moura137/laravel-elephantio');
    }

    /**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
    {
    	$this->app->bind('elephant.io', function($app){
            $config = $app['config']->get('laravel-elephantio::config');

            $address = rtrim($config['url'], '/');
            $port = $config['port'];
            if (!empty($port)) {
                $address .= ':' . $port;
            }

            return new Client($address, 'socket.io', 1, false, true, $config['debug']);
        });

        $this->app->bind('laravel.elephantio', function($app){
            return new LaraElephantIO($app['elephant.io']);
        });
    }
}