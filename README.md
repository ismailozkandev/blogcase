## Kurulum

.env.example dosyasını, .env olarak değiştirin.

Sırasıyla aşağıda ki komutları çalıştırın:

composer update

php artisan migrate

php artisan

php artisan db:seed --class=UserSeeder

## API

### Kullanıcı Kayıt işlemi

Parametreler:

name

email

password

```
POST /api/register
```

### Kullanıcı Giriş işlemi

Parametreler:

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

Parametreler:

id

title

detail

created_at

```
GET /api/blog
```

### Örnek istek:
```
{
	"title": "test1 içerik",
	"detail": "lorem ipsum",
	"category": 1,
}
```


### Örnek yanıt:
```
{
	"id": 1,
	"title": "test1 içerik",
	"detail": "lorem ipsum",
	"category": 1,
	"user_id": "1",
	"created_at": "2024-04-17T10:00:00.000000Z",
}
```

### Belirli İçeriği Görünteleme

Parametreler:

id

title

detail

created_at

```
POST /api/blog/{id}
```

### Yeni Yazı Ekleme

Parametreler:

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

Parametreler:

Blog id

```
DELETE /api/blog/{id}
```



### Blog filtreleme

Parametreler:

category id (opsiyonel)

tag id (opsiyonel)

```
POST /api/postblogfilter
```

### Örnek istek:
```
{
	"cat": "1",
	"tag": "2",
}
```


### Örnek yanıt:
```
[
    {
        "id": 1,
		"title": "test1 içerik",
		"detail": "lorem ipsum",
		"category": 1,
		"user_id": "1",
		"created_at": "2024-04-17T10:00:00.000000Z",
    },
    {
        "id": 2,
		"title": "test2 içerik",
		"detail": "lorem ipsum",
		"category": 1,
		"user_id": "1",
		"created_at": "2024-04-17T10:00:00.000000Z",
    },
    {
        "id": 2,
		"title": "test2 içerik",
		"detail": "lorem ipsum",
		"category": 1,
		"user_id": "1",
		"created_at": "2024-04-17T10:00:00.000000Z",
    }
]
```