<?php

namespace App\Http\Middleware;

use Closure;

class AppVersion
{
    const IS_ANDROID_APP_IN_REVIEW_MODE = 'is_android_app_in_review_mode';
    const IS_IOS_APP_IN_REVIEW_MODE = 'is_ios_app_in_review_mode';
    const IS_ANDROID_APP_REQUIRE_UPDATE = 'is_android_app_require_update';
    const IS_IOS_APP_REQUIRE_UPDATE = 'is_ios_app_require_update';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $versionName = request()->header('App-Version');
        $versions = config("app_versions");
        if(array_key_exists($versionName,$versions))
            $versionValues = config("app_versions")["$versionName"];
        else
            $versionValues = config('app_versions.default');
        if($request->header('platform') == 'ios') {
            config()->set('app_versions.current.is_app_in_review_mode',$versionValues[self::IS_IOS_APP_IN_REVIEW_MODE]);
            config()->set('app_versions.current.is_app_require_update',$versionValues[self::IS_IOS_APP_REQUIRE_UPDATE]);
        }
        else {
            config()->set('app_versions.current.is_app_in_review_mode',$versionValues[self::IS_ANDROID_APP_IN_REVIEW_MODE]);
            config()->set('app_versions.current.is_app_require_update',$versionValues[self::IS_ANDROID_APP_REQUIRE_UPDATE]);
        }

        return $next($request);
    }
}
