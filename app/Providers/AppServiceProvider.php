<?php

namespace App\Providers;

use App\Http\View\Composers\FooterComposer;
use App\Http\View\Composers\HeaderComposer;
use App\Http\View\Composers\MenuHomePageComposer;
use App\Services\DatabaseConnectionService;
use Illuminate\Support\Facades\Schema; //SoftDelete
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Console\Scheduling\Schedule;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    { }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.env') != 'local') {
            URL::forceScheme('https');
        }

        // Tối ưu hóa connection khi app khởi động
        DatabaseConnectionService::optimizeConnections();


        // if (request()->is('admin/*')) {
        //     config(['session.cookie' => 'admin_session']);
        // } elseif (request()->is('client/*')) {
        //     config(['session.cookie' => 'client_session']);
        // }

        // Cache các dữ liệu để tránh query liên tục
        // Config cache 24 giờ (rất ít khi thay đổi)
        $config = \Cache::remember('app_config', 86400, function () {
            return \App\Model\Admin\Config::with(['image'])->where('id', 1)->first();
        });

        // Tags cache 2 giờ (ít thay đổi)
        $tag_search = \Cache::remember('app_tag_search', 7200, function () {
            return \App\Model\Admin\Tag::where('type', 10)->inRandomOrder()->limit(3)->get();
        });

        $tag_search_all = \Cache::remember('app_tag_search_all', 7200, function () {
            return \App\Model\Admin\Tag::where('type', 10)->get();
        });

        // Banners cache 1 giờ (có thể thay đổi thường xuyên hơn)
        $banners = \Cache::remember('app_banners', 3600, function () {
            return \App\Model\Admin\Banner::with(['image'])->get();
        });

        view()->share('config', $config);
        view()->share('tag_search', $tag_search);
        view()->share('tag_search_all', $tag_search_all);
        view()->share('banners', $banners);
        // \Illuminate\Database\Query\Builder::macro('toRawSql', function(){
        // 	return array_reduce($this->getBindings(), function($sql, $binding){
        // 		return preg_replace('/\?/', is_numeric($binding) ? $binding : "'".$binding."'" , $sql, 1);
        // 	}, $this->toSql());
        // });

        // \Illuminate\Database\Eloquent\Builder::macro('toRawSql', function(){
        // 	return ($this->getQuery()->toRawSql());
        // });

        View::composer(
            'site.partials.header',
            MenuHomePageComposer::class
        );

        View::composer(
            'site.partials.mobile_menu',
            MenuHomePageComposer::class
        );

        View::composer(
            'site.index',
            MenuHomePageComposer::class
        );

        View::composer(
            'site.partials.footer',
            FooterComposer::class
        );

        View::composer(
            'site.contact_us',
            FooterComposer::class
        );

        View::composer(
            'site.partials.before_footer',
            FooterComposer::class
        );

        View::composer(
            'site.partials.header',
            HeaderComposer::class
        );

        View::composer(
            'site.layouts.master',
            HeaderComposer::class
        );

        // Chạy cleanup định kỳ
        $this->scheduleCleanup();
    }

    private function scheduleCleanup()
    {
        // Chạy cleanup mỗi 5 phút
        $schedule = app(Schedule::class);
        $schedule->call(function () {
            DatabaseConnectionService::cleanupIdleConnections();
        })->everyFiveMinutes();
    }
}
