# Rajaongkir REST authenticate search province and city

## sprint_1

Tambahkan value pada .env 
```
RAJAONGKIR_DIRECT= true/false
RAJAONGKIR_API_KEY= [YOUR RAJAONGKIR KEY]

```
Lakukan migrate sehingga schema yang dapat terbuat

Jalankan artisan command untuk melakukan fetc data dari raja ongkir
```
php artisan rajaongkir::fetch-kota
php artisan rajaongkir::fetch-province
```

Ujicoba get request untuk REST search provinces dan city dari url
```
/api/search/provinces?id={2to33}
/api/search/cities?id={2to501}
```

### common-error

Apabila terjadi error tidak memperoleh data dari .env lakukan pengaturan ulang config
```
php artisan config:cache
php artisan config:clear

```