<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Setting\AppearanceUpdateRequest;
use App\Http\Requests\Dashboard\Admin\Setting\AuthenticationUpdateRequest;
use App\Http\Requests\Dashboard\Admin\Setting\CaptchaUpdateRequest;
use App\Http\Requests\Dashboard\Admin\Setting\GeneralUpdateRequest;
use App\Http\Requests\Dashboard\Admin\Setting\LocalizationUpdateRequest;
use App\Http\Requests\Dashboard\Admin\Setting\LoggingUpdateRequest;
use App\Http\Requests\Dashboard\Admin\Setting\OutgoingMailUpdateRequest;
use App\Http\Requests\Dashboard\Admin\Setting\SeoUpdateRequest;
use App\Http\Resources\Language\LanguageResource;
use App\Http\Resources\UserRole\UserRoleResource;
use App\Models\Language;
use App\Models\Setting;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('demo', ['only' => ['setGeneral', 'setSeo', 'setAppearance', 'setLocalization', 'setAuthentication', 'setOutgoingMail', 'setLogging', 'setCaptcha']]);
    }

    public function getGeneral(): JsonResponse
    {
        return response()->json([
            'app_url' => Setting::getDecoded('app_url'),
            'app_name' => Setting::getDecoded('app_name'),
            'app_https' => Setting::getDecoded('app_https'),
        ]);
    }

    public function setGeneral(GeneralUpdateRequest $request): JsonResponse
    {
        $request->validated();
        $settings = Setting::find('app_url');
        $settings->value = $request->get('app_url');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('app_name');
        $settings->value = $request->get('app_name');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('app_https');
        $settings->value = $request->get('app_https');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        return response()->json(['message' => __('Settings updated successfully')]);
    }

    public function getSeo(): JsonResponse
    {
        return response()->json([
            'meta_home_title' => Setting::getDecoded('meta_home_title'),
            'meta_keywords' => Setting::getDecoded('meta_keywords'),
            'meta_description' => Setting::getDecoded('meta_description'),
        ]);
    }

    public function setSeo(SeoUpdateRequest $request): JsonResponse
    {
        $request->validated();
        $settings = Setting::find('meta_home_title');
        $settings->value = $request->get('meta_home_title');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('meta_keywords');
        $settings->value = $request->get('meta_keywords');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('meta_description');
        $settings->value = $request->get('meta_description');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        return response()->json(['message' => __('Settings updated successfully')]);
    }

    public function getAppearance(): JsonResponse
    {
        return response()->json([
            'app_icon' => Setting::getDecoded('app_icon'),
            'app_background' => Setting::getDecoded('app_background'),
        ]);
    }

    public function setAppearance(AppearanceUpdateRequest $request): JsonResponse
    {
        $request->validated();
        if ($request->file('icon')) {
            $settings = Setting::find('app_icon');
            $settings->value = $request->file('icon')->store('appearance/icon', 'public');
            if (!$settings->save()) {
                return response()->json(['message' => __('An error occurred while saving data')], 500);
            }
        }
        if ($request->file('background')) {
            $settings = Setting::find('app_background');
            $settings->value = $request->file('background')->store('appearance/background', 'public');
            if (!$settings->save()) {
                return response()->json(['message' => __('An error occurred while saving data')], 500);
            }
        }
        return response()->json(['message' => __('Settings updated successfully')]);
    }

    public function getLocalization(): JsonResponse
    {
        return response()->json([
            'app_timezone' => Setting::getDecoded('app_timezone'),
            'app_locale' => Setting::getDecoded('app_locale'),
            'app_date_locale' => Setting::getDecoded('app_date_locale'),
            'app_date_format' => Setting::getDecoded('app_date_format'),
        ]);
    }

    public function setLocalization(LocalizationUpdateRequest $request): JsonResponse
    {
        $request->validated();
        $settings = Setting::find('app_timezone');
        $settings->value = $request->get('app_timezone');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('app_locale');
        $settings->value = $request->get('app_locale');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('app_date_locale');
        $settings->value = $request->get('app_date_locale');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('app_date_format');
        $settings->value = $request->get('app_date_format');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        return response()->json(['message' => __('Settings updated successfully')]);
    }

    public function getAuthentication(): JsonResponse
    {
        return response()->json([
            'app_user_registration' => Setting::getDecoded('app_user_registration'),
            'app_default_role' => Setting::getDecoded('app_default_role'),
        ]);
    }

    public function setAuthentication(AuthenticationUpdateRequest $request): JsonResponse
    {
        $request->validated();
        $settings = Setting::find('app_user_registration');
        $settings->value = (bool) $request->get('app_user_registration');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('app_default_role');
        $settings->value = $request->get('app_default_role');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        return response()->json(['message' => __('Settings updated successfully')]);
    }

    public function getOutgoingMail(): JsonResponse
    {
        return response()->json([
            'mail_from_address' => Setting::getDecoded('mail_from_address'),
            'mail_from_name' => Setting::getDecoded('mail_from_name'),
            'mail_mailer' => Setting::getDecoded('mail_mailer'),
            'mail_encryption' => Setting::getDecoded('mail_encryption'),
            'mail_host' => Setting::getDecoded('mail_host'),
            'mail_password' => Setting::getDecoded('mail_password'),
            'mail_port' => Setting::getDecoded('mail_port'),
            'mail_username' => Setting::getDecoded('mail_username'),
            'mailgun_domain' => Setting::getDecoded('mailgun_domain'),
            'mailgun_secret' => Setting::getDecoded('mailgun_secret'),
            'mailgun_endpoint' => Setting::getDecoded('mailgun_endpoint'),
        ]);
    }

    public function setOutgoingMail(OutgoingMailUpdateRequest $request): JsonResponse
    {
        $request->validated();
        $settings = Setting::find('mail_from_address');
        $settings->value = $request->get('mail_from_address');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('mail_from_name');
        $settings->value = $request->get('mail_from_name');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('mail_mailer');
        $settings->value = $request->get('mail_mailer');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('mail_encryption');
        $settings->value = $request->get('mail_encryption');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('mail_host');
        $settings->value = $request->get('mail_host');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('mail_password');
        $settings->value = $request->get('mail_password');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('mail_port');
        $settings->value = $request->get('mail_port');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('mail_username');
        $settings->value = $request->get('mail_username');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('mailgun_domain');
        $settings->value = $request->get('mailgun_domain');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('mailgun_secret');
        $settings->value = $request->get('mailgun_secret');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('mailgun_endpoint');
        $settings->value = $request->get('mailgun_endpoint');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        return response()->json(['message' => __('Settings updated successfully')]);
    }

    public function getLogging(): JsonResponse
    {
        return response()->json([
            'sentry_dsn' => Setting::getDecoded('sentry_dsn'),
        ]);
    }

    public function setLogging(LoggingUpdateRequest $request): JsonResponse
    {
        $request->validated();
        $settings = Setting::find('sentry_dsn');
        $settings->value = $request->get('sentry_dsn');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        return response()->json(['message' => __('Settings updated successfully')]);
    }

    public function getCaptcha(): JsonResponse
    {
        return response()->json([
            'recaptcha_enabled' => Setting::getDecoded('recaptcha_enabled'),
            'recaptcha_public' => Setting::getDecoded('recaptcha_public'),
            'recaptcha_private' => Setting::getDecoded('recaptcha_private'),
        ]);
    }

    public function setCaptcha(CaptchaUpdateRequest $request): JsonResponse
    {
        $request->validated();
        $settings = Setting::find('recaptcha_enabled');
        $settings->value = $request->get('recaptcha_enabled');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('recaptcha_public');
        $settings->value = $request->get('recaptcha_public');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        $settings = Setting::find('recaptcha_private');
        $settings->value = $request->get('recaptcha_private');
        if (!$settings->save()) {
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
        return response()->json(['message' => __('Settings updated successfully')]);
    }

    public function userRoles(): JsonResponse
    {
        return response()->json(UserRoleResource::collection(UserRole::all()));
    }

    public function languages(): JsonResponse
    {
        return response()->json(LanguageResource::collection(Language::all()));
    }
}
