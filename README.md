# lib-user-verification

Adalah module yang menyediakan data random token untuk verifikasi field properti user
seperti email atau phone.

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install lib-user-verification
```

## Penggunaan

Module ini mendaftarkan satu library dengan nama `LibUserVerification\Library\Verifier`
yang bisa digunakan untuk menggenerasi token dan memverifikasi nilai token:

```php
use LibUserVerification\Library\Verifier;

$user_id    = 1;
$field_name = 'email';
$user_email = 'email@host.com';
$options    = [
	'next'      => $this->router->to('siteHome'),
	'type'      => 'text' // text | number
	'length'    => 32,
	'expires'   => '+2 hours'
];

// generat new email token
$token = Verifier::generate($user_id, $field_name, $user_email, $options);


// validate user provided token
$verif = Verifier::verify($token, $field_name, $user_email, $user_id);
if(!$verif)
	deb('Invalid token or already verified');
else
	deb('Success verifing user field');
```

### generate(string $user, string $field, string $value, array $options=[]): ?string

Menggenerasi token baru untuk digunakan user untuk verifikasi field properti user. Nilai
`$options` menerima array dengan properti sebagai berikut:

1. next::string  URL redirect kemana user akan dialihkan ketika proses verifikasi berhasil.
1. type::string  Type token, menerima nilai `text` untuk `[a-z0-9]` atau `number` untuk `[0-9]`.
1. length::number  Jumlah karakter token.
1. expires::string  Lamanya token bisa digunakan. Nilainya harus bisa digunakan oleh fungsi `strtotime`.

### verify(string $token, string $field, string $value=null, int $user=null): ?object

Memverifikasi token yang diberikan user. Sebagai catatan, fungsi ini tidak akan mengembalikan nilai jika
token yang digunakan untuk target field yang sama sudah pernah diverifikasi.

### lastError(): ?string

Mengembalikan pesan error yang terjadi.