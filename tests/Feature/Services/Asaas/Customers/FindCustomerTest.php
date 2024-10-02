<?php

test('if FindCustomer service can find an existing customer on Asaas', function () {
    $service = new \App\Services\Asaas\Customers\FindCustomer();

    $data = $service->handle(customerId: '6238303');

    $result = $service->toArray($data);

    expect($data)
        ->toBeInstanceOf(\Illuminate\Http\JsonResponse::class);

    expect($result)
        ->toBeArray()
        ->toHaveKeys(['id', 'name', 'cpfCnpj', 'email', 'mobilePhone']);
});
