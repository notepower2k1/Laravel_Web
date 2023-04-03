<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\bookMark;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
            view()->composer('client.layouts.header', function ($view) {

                if(Auth::check()){   

                    $bookMark_notifications = bookMark::where('userID','=',Auth::user()->id)->where('status','=',1)->get();
                    $view->with('bookMark_notifications',$bookMark_notifications);

                    $comment_notifications = Notification::where('receiverID','=',Auth::user()->id)->where('status','=',1)->get();
                    $view->with('comment_notifications',$comment_notifications);

                }
              
            });
        
    
     
    }
}
