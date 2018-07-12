# Rajaongkir REST authenticate search province and city

##Overview
- Melakukan fetch data province dan city dari [Rajaongkir](https://rajaongkir.com/) 
- Request REST untuk search province dan city;
- Implementasi swapable implementation untuk direct request ke rajaongkir atau menggunakan data yang telah di fetch di database
- Menambahkan otentikasi kepada REST search
- Unit testing untuk REST login, logout dan register

##How To

Tambahkan value pada .env 
```
RAJAONGKIR_DIRECT= true/false
RAJAONGKIR_API_KEY= [YOUR RAJAONGKIR KEY]
```
Lakukan migrate sehingga schema yang dapat terbuat

Jalankan artisan command untuk melakukan fetch data dari raja ongkir
```
php artisan rajaongkir::fetch-kota
php artisan rajaongkir::fetch-province
```
Jalankan laravel
```
php artisan serve
```

Ujicoba get request untuk REST search provinces dan city dari url
```
/api/search/provinces?id={2to33}
/api/search/cities?id={2to501}
```

perbarui nilai RAJAONGKIR_DIRECT di file .env untuk mendapatkan hasil REST dari database

Jalankan unit test untuk mengetahui kondisi yang tercakup saat ini
```
php vendor/phpunit/phpunit/phpunit --filter namaFunction
php vendor/phpunit/phpunit/phpunit --filter testNoCredential
php vendor/phpunit/phpunit/phpunit --filter testRegisterSuccess
```

## Feature
Feature REST tersedia
- [Register User](http://localhost:8000/api/register)
- [Login](http://localhost:8000/api/login) 
- [Logout](http://localhost:8000/api/logout) 
- [Search Province By Id](http://localhost:8000/api/search/provinces?id=3)
- [Search City By Id](http://localhost:8000/api/search/cities?id=3) 


### common-error

Apabila terjadi error tidak memperoleh data dari .env lakukan pengaturan ulang config
```
php artisan config:cache
php artisan config:clear

```
