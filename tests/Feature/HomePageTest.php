<?php

it('Welcome to AgroSpace', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});
