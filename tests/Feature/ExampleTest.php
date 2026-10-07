<?php

test('halaman utama mengarahkan pengunjung baru ke halaman masuk', function () {
    $this->get('/')->assertRedirect(route('masuk'));
});