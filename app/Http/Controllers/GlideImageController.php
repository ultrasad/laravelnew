<?php
namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

//use League\Flysystem\Adapter\Local as Adapter;

class GlideImageController extends Controller
{   
    /*
    public function show(Filesystem $filesystem, $path)
    {

        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            'source' => $filesystem->getDriver(),
            'cache' => $filesystem->getDriver(),
            //'source' => public_path('images'),
            //'cache' => public_path('images/outputfolder'),
            //'source_path_prefix' => '',
            //'cache_path_prefix' => '.cache',
            //'base_url' => 'images',
            //'watermarks' => $filesystem->getDriver(),
            //'source_path_prefix' => 'images',
            //'cache_path_prefix' => 'images/.cache',
            //'watermarks_path_prefix' => 'images/watermarks',
            //'base_url' => 'photos',
        ]);

        echo 'controller => ' . $path;

        //return $server->getImageResponse($path, request()->all());
        //return $server->outputImage($path, request()->all());
    }
    */

    public function show(Filesystem $filesystem, $path)
    { 
        //$filesystem = new Filesystem(new Adapter($path));
        //echo 'path => ' . $path;
        //var_dump($filesystem->has('images/' . $path));
        //var_dump($filesystem->getDriver());
        //exit;
        //echo 'filesystem => ' . $filesystem;
        ///echo 'public path => ' . public_path($path);
        //dd($path);
        //dd($filesystem);
        //exit;

        //$filesystem = $files ystem(new Local(public_path()));
        
        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            //'source' => public_path('images'),
            //'cache' => public_path('images'),
            //'source' => $filesystem->getDriver(),
            //'cache' => $filesystem->getDriver(),
            //'source' => local_path('public/images/' . $path),
            'source' => public_path(),
            'cache' => storage_path('glide'),
            //'cache' => public_path('images'),
            'cache_path_prefix' => '.cache',
            'base_url' => 'img',
        ]);
        
        //$response = $server->getImageResponse($path, request()->all());
        //dd($response);

        return $server->getImageResponse($path, request()->all());

        /*
        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            //'source' => $filesystem->getDriver(),
            //'cache' => $filesystem->getDriver(),
            //'source' => public_path('images'),
            //'cache' => public_path('images/outputfolder'),
            'cache_path_prefix' => '.cache',
            'base_url' => 'images',
        ]);
        */

        //return 'xxxx';

        //$response =  $server->getImageResponse($path, request()->all());
        //dd($response);
        //return $response;
        //return $server->outputImage($_GET['file'], $_GET);
    }
}
?>