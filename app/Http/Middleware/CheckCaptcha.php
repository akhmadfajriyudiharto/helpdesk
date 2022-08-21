<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckCaptcha
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     * @throws
     * @throws Exception|GuzzleException
     */
    public function handle(Request $request, Closure $next)
    {
        if (Setting::getDecoded('recaptcha_enabled')) {
            $client = new Client();
            $response = $client->request('POST', 'https://google.com/recaptcha/api/siteverify', [
                'query' => [
                    'secret' => Setting::getDecoded('recaptcha_private'),
                    'response' => $request->get('captcha')
                ]
            ]);
            $recaptcha = json_decode($response->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
            if (!$recaptcha->success || $recaptcha->score < 0.5) {
                return response()->json(['message' => __('Unable to verify captcha')], Response::HTTP_BAD_REQUEST);
            }
        }
        return $next($request);
    }
}
