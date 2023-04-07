<?php

namespace App\Utils;

use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token\Builder;

class AppUtil
{
    public static function paginate($query)
    {
        $limit = request('limit') ?? 10;

//        $sortBy = request('sortBy') ?? 'created_at';
//        $orderBy = request()->boolean('desc') ? 'desc' : 'asc';

        return $query->paginate($limit);
    }

    /**
     * @throws \Exception
     */
    public static function generateToken($uuid): string
    {
        $tokenBuilder = (new Builder(new JoseEncoder(), ChainedFormatter::default()));
        $algorithm = new Sha256();
        $signingKey = InMemory::plainText(random_bytes(32));

        $token = $tokenBuilder
            ->issuedBy(config('app.url'))
            ->withClaim('uuid', $uuid)
            ->getToken($algorithm, $signingKey);

        return $token->toString();
    }

    public static function response($data = null, $error = null, $errors = null): array
    {
        return [
            'success' => $data ? 1 : 0,
            'data' => $data,
            'error' => $error,
            'errors' => $errors,
            'extra' => []
        ];
    }

}