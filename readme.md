# Rajaongkir REST authenticate search province and city

## sprint_2

Tambahkan value pada .env 
```
RAJAONGKIR_DIRECT= true/false
RAJAONGKIR_API_KEY= [YOUR RAJAONGKIR KEY]

```

Jalankan artisan command untuk melakukan fetch data dari raja ongkir
```
php artisan rajaongkir::fetch-kota
php artisan rajaongkir::fetch-province
```

Jalankan unit test 
```
php vendor/phpunit/phpunit/phpunit --filter namaFunction
php vendor/phpunit/phpunit/phpunit --filter testNoCredential
php vendor/phpunit/phpunit/phpunit --filter testRegisterSuccess
```

### common-error

Apabila terjadi error tidak memperoleh data dari .env lakukan pengaturan ulang config
```
php artisan config:cache
php artisan config:clear

```