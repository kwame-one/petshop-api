<?php

namespace App\Utils;

use Illuminate\Pipeline\Pipeline;
use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Token\UnsupportedHeaderFound;
use Lcobucci\JWT\Token\Parser;

class AppUtil
{
    public static function paginate($query)
    {
        $limit = request('limit') ?? 10;

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

    public static function response($status, $data = [], $error = null, $errors = []): array
    {
        return [
            'success' => $status,
            'data' => $data,
            'error' => $error,
            'errors' => $errors,
            'extra' => []
        ];
    }

    public static function uploadFile($data, $pipe)
    {
        return app(Pipeline::class)
            ->send($data)
            ->through($pipe)
            ->thenReturn();
    }

    public static function humanFilesize($bytes, $decimals = 2): string
    {
        $size = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    public static function getUserUuidFromToken($token)
    {
        $parser = new Parser(new JoseEncoder());

        try {
            $token = $parser->parse($token);
            return $token->claims()->get('uuid');
        } catch (CannotDecodeContent|InvalidTokenStructure|UnsupportedHeaderFound $e) {
            echo 'Oh no, an error: ' . $e->getMessage();
        }
        return '';
    }


}