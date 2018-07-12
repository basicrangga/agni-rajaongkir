# Rajaongkir REST authenticate search province and city

## sprint_1

Tambahkan value pada .env 
```
RAJAONGKIR_DIRECT= true/false
RAJAONGKIR_API_KEY= [YOUR RAJAONGKIR KEY]

```

Jalankan artisan command untuk melakukan fetc data dari raja ongkir
```
php artisan rajaongkir::fetch-kota
php artisan rajaongkir::fetch-province
```

### common-error

Apabila terjadi error tidak memperoleh data dari .env lakukan pengaturan ulang config
```
php artisan config:cache
php artisan config:clear

```