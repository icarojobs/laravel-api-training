<?php

declare(strict_types=1);

namespace App\Services\Asaas\Customers;

use App\Enums\HttpStatusEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class FindCustomer
{
    public function __construct(
        protected ?string $url = null,
        protected ?string $token = null,
        protected ?string $path = '/customers',
        protected ?string $fullUrl = null,
    )
    {
        if (!isset($this->url, $this->token)) {
            $this->url = config('asaas.url');
            $this->token = config('asaas.token');
            $this->fullUrl = "{$this->url}{$this->path}";
        }
    }

    public function handle(string|int $customerId): JsonResponse
    {
        try {
            $response = Http::withHeader('access_token', $this->token)
                ->get("{$this->fullUrl}/{$customerId}")
                ->throw()
                ->json();

            return response()->json($response, HttpStatusEnum::CREATED->value);
        } catch (\Exception $exception) {
           return response()->json([
               'code' => $exception->getCode(),
               'message' => $exception->getMessage(),
           ], HttpStatusEnum::INTERNAL_SERVER_ERROR->value);
        }
    }

    public function toArray(JsonResponse $response): array
    {
        $rawData = json_decode(json_encode($response), true);

        return $rawData['original'] ?? [];
    }
}
