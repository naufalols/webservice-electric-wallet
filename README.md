# Electric Wallet

Electric Wallet adalah sebuah sistem web service, di mana user dapat melihat saldo saat ini dan mengirim saldo ke sesama pengguna Electric Wallet

## Installation

Clone git [Gitlab](https://gitlab.com/naufalols/electricWallet) untuk menginstall aplikasi.

```bash
git clone https://gitlab.com/naufalols/electricWallet.git
```
buat satu database msql pada server, lalu buat satu file .env atau rename .env.example dan koneksikan database yang telah dibuat.

Lalu di dalam bash lakukan

```bash
# composer
composer install

# migrate table
php artisan migrate

# seeding table
php artisan db:seed

# key generate
php artisan key:generate

# run server
php artisan serve
```
## Usage

Dalam web service ini memiliki 4 endpoint

Buka database lalu buka table users kemudian pilih salah satu users
### 1. Login
endpoint http://base_url/auth
```php
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://base_url/auth',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "email": "rveum@example.org",
    "password": "password"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Cookie: XSRF-TOKEN=eyJpdiI6Ik44TGd4MjJYdVdUbW5lTWpQNDI5UEE9PSIsInZhbHVlIjoiUTE5Q3FlUUJuTk11b0hYbitNRkVSSENkVXRrSUU4T3N1b2d5bzlIUEljcktFb1ZDczJvKytrSnZCNnhqWXI1SVdTZXJoeFVIMlNDOHJub1Nkc3IvNDdjNkNXdVNkS1V4c1JKci9zTEhPdmxFR2IyTHA2cDROQWdQdHlkaXB2bWgiLCJtYWMiOiI1OTI0M2I1OTEwZGJjYjAxYTc3YTQ0MzAzYjcxZTM1MTIxNGZjMmJjY2I3ZWRlYWEyZDk4YjIxZTg2MDVhMTk3IiwidGFnIjoiIn0%3D; electricwallet_session=eyJpdiI6IlljOEEzN0tUWUcrTVFGVTN2RWprb2c9PSIsInZhbHVlIjoiZnY5c05US0xLTzl2Vk9xQU54Yi9uZWh2NTNpQUdaTm1GM0VxWnU3ZnYveDNqVWtaNjRQUXM1SEtyeHZERTBPRVB6YktOanIvM21VN2tlcmg5cXh4UXp4S2YzZ2hFK096OE52akNzclk5RDhxekxucmVrbGRFbDRqVWl2VEFnQXgiLCJtYWMiOiIwN2MwYTFhODYyNTAwMDNlNmI3ZDJlYjUwYmNkMWU4YjE2NGNhZGM3MTY2NmMxNGIxYmQ1YzE3ZTdjZTdkZDA0IiwidGFnIjoiIn0%3D'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
```
response dari endpoint ini adalah
```json
{
    "data": {
        "id": 1,
        "name": "Mrs. Aurore Walter",
        "email": "rveum@example.org",
        "email_verified_at": "2021-11-21T03:31:36.000000Z",
        "created_at": "2021-11-21T03:31:36.000000Z",
        "updated_at": "2021-11-21T03:31:36.000000Z"
    },
    "token": {
        "accessToken": {
            "name": "login-client",
            "abilities": [
                "*"
            ],
            "tokenable_id": 1,
            "tokenable_type": "App\\Models\\User",
            "updated_at": "2021-11-21T15:37:37.000000Z",
            "created_at": "2021-11-21T15:37:37.000000Z",
            "id": 4
        },
        "plainTextToken": "4|WLHAFyrkl5snMwPHq3hfl6Abtg0QBa84VIFFvTuE"
    }
}
```
copy bearer token dari json plainTextToken untuk digunakan mengakses endpoint lainnya

### 2. User Top Up
endpoint http://base_url/api/userTransactionTopUp
ada 4 form body yang harus diisi yaitu 
- user_token (harus sama dengan user yang telah login, user_token tersedia di tanle users)
- userid
- amount
```php
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://base_url/api/userTransactionTopUp',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('user_token' => 'QrZmmqwPs7','userid' => '1','amount' => '8000'),
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Authorization: Bearer 4|WLHAFyrkl5snMwPHq3hfl6Abtg0QBa84VIFFvTuE',
    'Cookie: XSRF-TOKEN=eyJpdiI6IlYrVXhxMmRoWENGeUIyaXpkODRUWXc9PSIsInZhbHVlIjoiTTdYUEJuUWgwV2U4eTVjcVd1YzFoaFVIb3EwcXc0djdSaFo3RjlaRmRKVDhLdXp0MkFiSERLQWVOUWk1cUIyeFgzL1BFdE1oMkt3YWxYOGVVek55a2JSQWZvODZjWHVrclplY2o3bHM2VE9XeXJnaGlxSzRRSFRMRmI2ODQzdHYiLCJtYWMiOiJlYWE2MWQ3YjhiZDlhMzdmNDI2MjE5OGYxODE3ZmMyOTMwMjM4OGVkY2NiNDk3NDEzYTA3NDUwYWNkNjQwZDI1IiwidGFnIjoiIn0%3D; electricwallet_session=eyJpdiI6InMwTWphdlRoQmxrd2l1aUMyWmY4cEE9PSIsInZhbHVlIjoiUGNNY1FKazc4dTBsK3praTJzRzlZOUgxbDhld2p2akptaEh5aXB4T3VkK2E5b0t0TGtrejlzWFFuVG52RzAzMjRrcFFaOEYybXZ1OUpWWklNMUd3Yk51ajBWL1JBMmVIY1pGYkd3Q2xXQnRmYlhrTXkvV2c2QTM1QUZBTkt6RUoiLCJtYWMiOiI3MTk2MGI3MzdkMGE0MGJkZTlmNzM5MTU3ZWFlMzkyNDY4YjVmZWUyNWFjNmI1OTFmMTgwYzVlMjY3MjlmNjRjIiwidGFnIjoiIn0%3D'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

```
response dari endpoint ini adalah
```json
{
    "status": 200,
    "message": "successful topup"
}
```

### 3. User Transfer
endpoint http://base_url/api/userTransactionTransfer
ada 4 form body yang harus diisi yaitu 
- user_token (harus sama dengan user yang telah login, user_token tersedia di table users)
- userid
- amount
- touserid (user id tujuan)
```php
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://base_url/api/userTransactionTransfer',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('user_token' => 'eOr34GjSsV','userid' => '1','amount' => '12','touserid' => '2'),
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Authorization: Bearer 4|WLHAFyrkl5snMwPHq3hfl6Abtg0QBa84VIFFvTuE'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

```
hasil dari endpoint ini adalah
```json
{
    "status": 200,
    "message": "successful delivery"
}
```
### 4. Cek Balance
Endpoint ini menggunakan method get dengan param sesuai id
http://base_url/api/userBalance/2
```php
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://base_url/api/userBalance/2',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Authorization: Bearer 4|WLHAFyrkl5snMwPHq3hfl6Abtg0QBa84VIFFvTuE',
    'Cookie: XSRF-TOKEN=eyJpdiI6Ik44TGd4MjJYdVdUbW5lTWpQNDI5UEE9PSIsInZhbHVlIjoiUTE5Q3FlUUJuTk11b0hYbitNRkVSSENkVXRrSUU4T3N1b2d5bzlIUEljcktFb1ZDczJvKytrSnZCNnhqWXI1SVdTZXJoeFVIMlNDOHJub1Nkc3IvNDdjNkNXdVNkS1V4c1JKci9zTEhPdmxFR2IyTHA2cDROQWdQdHlkaXB2bWgiLCJtYWMiOiI1OTI0M2I1OTEwZGJjYjAxYTc3YTQ0MzAzYjcxZTM1MTIxNGZjMmJjY2I3ZWRlYWEyZDk4YjIxZTg2MDVhMTk3IiwidGFnIjoiIn0%3D; electricwallet_session=eyJpdiI6IlljOEEzN0tUWUcrTVFGVTN2RWprb2c9PSIsInZhbHVlIjoiZnY5c05US0xLTzl2Vk9xQU54Yi9uZWh2NTNpQUdaTm1GM0VxWnU3ZnYveDNqVWtaNjRQUXM1SEtyeHZERTBPRVB6YktOanIvM21VN2tlcmg5cXh4UXp4S2YzZ2hFK096OE52akNzclk5RDhxekxucmVrbGRFbDRqVWl2VEFnQXgiLCJtYWMiOiIwN2MwYTFhODYyNTAwMDNlNmI3ZDJlYjUwYmNkMWU4YjE2NGNhZGM3MTY2NmMxNGIxYmQ1YzE3ZTdjZTdkZDA0IiwidGFnIjoiIn0%3D'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

```
hasil dari endpoint ini adalah
```json
{
    "status": 200,
    "message": [
        {
            "id": 2,
            "email": "conroy.sadye@example.com",
            "balance": "5200"
        }
    ]
}
```

### 5. Logout
endpoint http://base_url/api/logout
```php
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://base_url/api/logout',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "email": "rveum@example.org"
}',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Authorization: Bearer 4|WLHAFyrkl5snMwPHq3hfl6Abtg0QBa84VIFFvTuE',
    'Content-Type: application/json',
    'Cookie: XSRF-TOKEN=eyJpdiI6Ik44TGd4MjJYdVdUbW5lTWpQNDI5UEE9PSIsInZhbHVlIjoiUTE5Q3FlUUJuTk11b0hYbitNRkVSSENkVXRrSUU4T3N1b2d5bzlIUEljcktFb1ZDczJvKytrSnZCNnhqWXI1SVdTZXJoeFVIMlNDOHJub1Nkc3IvNDdjNkNXdVNkS1V4c1JKci9zTEhPdmxFR2IyTHA2cDROQWdQdHlkaXB2bWgiLCJtYWMiOiI1OTI0M2I1OTEwZGJjYjAxYTc3YTQ0MzAzYjcxZTM1MTIxNGZjMmJjY2I3ZWRlYWEyZDk4YjIxZTg2MDVhMTk3IiwidGFnIjoiIn0%3D; electricwallet_session=eyJpdiI6IlljOEEzN0tUWUcrTVFGVTN2RWprb2c9PSIsInZhbHVlIjoiZnY5c05US0xLTzl2Vk9xQU54Yi9uZWh2NTNpQUdaTm1GM0VxWnU3ZnYveDNqVWtaNjRQUXM1SEtyeHZERTBPRVB6YktOanIvM21VN2tlcmg5cXh4UXp4S2YzZ2hFK096OE52akNzclk5RDhxekxucmVrbGRFbDRqVWl2VEFnQXgiLCJtYWMiOiIwN2MwYTFhODYyNTAwMDNlNmI3ZDJlYjUwYmNkMWU4YjE2NGNhZGM3MTY2NmMxNGIxYmQ1YzE3ZTdjZTdkZDA0IiwidGFnIjoiIn0%3D'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

```
hasil dari response ini adalah
```json
{
    "status": 200,
    "message": "logout successfully"
}
```
## Last but not Least
Terima kasih untuk Privy.id telah memberi saya kesempatan untuk melakukan pretest, semoga pretest ini dapat menunjang keputusan yang baik untuk saya maupun pihak Privy.id

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

