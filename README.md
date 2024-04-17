## Kurulum

.env.example dosyasını, .env olarak değiştirin.

Sırasıyla aşağıda ki komutları çalıştırın:

composer update
php artisan migrate
php artisan
php artisan db:seed --class=UserSeeder

## API

### Kullanıcı Kayıt işlemi

name
email
password

```
POST /api/register
```

### Kullanıcı Giriş işlemi

name
email
password

```
POST /api/login
```

### Örnek yanıt:
```
[
    {
        "id": 1,
        "name": "test1",
        "email": "test@test.com",
        "created_at": "2024-04-17T10:00:00.000000Z",
    },
    {
        "id": 2,
        "name": "test2",
        "email": "test@test.com",
        "created_at": "2024-04-12T10:00:00.000000Z",
    }
]
```


### Blog Listeleme

id
title
detail
created_at

```
GET /api/blog
```

### Belirli İçeriği Görünteleme

id
title
detail
created_at

```
POST /api/blog/{id}
```

### Yeni Yazı Ekleme

title
detail
categories
status

```
POST /api/blog
```

### Blog içeriğini Güncelleme

id

```
PUT /api/blog/{id}
```

### Blog içeriğini kaldırma

id

```
DELETE /api/blog/{id}
```
