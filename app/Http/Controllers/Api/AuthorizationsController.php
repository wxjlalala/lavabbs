<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\SocialAuthorizationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorizationsController extends Controller
{
    public function socialStore(SocialAuthorizationRequest $request,$type)
    {
        if (!in_array($type, ['weixin'])) {
            return $this->response->errorBadRequest();
        }
        // 注册socialDriver
        $driver = \Socialite::driver('weixin');
        // 发起授权请求
        try {
            if ($code = $request->code) {
                $response = $driver->getAccessTokenResponse($code);
                $token = array_get($response, 'access_token');
            } else {
                $toke = $request->access_token;
                if ($type == 'weixin') {
                    $driver->setOpenId($request->openid);
                }
            }
            $oauthUser = $driver->userFromToken($token);

        } catch (\Exception $e) {
            return $this->response->errorUnauthorized('参数错误，未取到用户信息');
        }

        // 查找入库
        switch ($type) {
            case 'weixin':
                $unionid = $oauthUser->offsetExists('unionid') ? $oauthUser->offsetGet('unionid') : null;
                if($unionid){
                    $user = User::where('weixin_unionid',$unionid)->first();
                } else {
                    $user = User::where('weixin_openid',$oauthUser->getId())->first();
                }

                if(!$user){
                    $user = User::create([
                        'name' => $oauthUser->getNickname(),
                        'avatar' => $oauthUser->getAvatar(),
                        'weixin_openid' => $oauthUser->getId(),
                        'weixin_unionid' => $unionid
                    ]);
                }

                break;
        }

        return $this->response->array(['token' => $user->id]);

    }
}