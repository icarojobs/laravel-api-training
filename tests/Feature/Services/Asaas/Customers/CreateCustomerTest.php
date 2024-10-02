<?php

test('if CreateCustomer service can add new customer on Asaas', function () {
    $service = new \App\Services\Asaas\Customers\CreateCustomer();

    $data = $service->handle([
        'name' => 'Tio Jobs', // required
        'cpfCnpj' => '442.511.630-52', // required
        'email' => 'teste@teste.com',
        'mobilePhone' => '16992222222',
    ]);

    $result = $service->toArray($data);

    expect($data)
        ->toBeInstanceOf(\Illuminate\Http\JsonResponse::class);

    expect($result)
        ->toBeArray()
        ->toHaveKeys(['id', 'name', 'cpfCnpj', 'email', 'mobilePhone']);
});
