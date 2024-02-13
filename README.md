## Instalasi

1. Clone repositori backend:

   ```bash
   git clone https://github.com/faisal-gif/backend_sales.git
   ```
   
2. Masuk ke direktori proyek:

   ```bash
   cd backend_sales
   ```

3. Salin file .env.example menjadi .env dan sesuaikan pengaturan database:

   ```bash
   cp .env.example .env
   ```

4. Jalankan perintah berikut untuk menginstal dependensi:

   ```bash
   composer install
   ```

6. Generate key aplikasi Laravel:

   ```bash
   php artisan key:generate
   ```
7. Migrasi dan isi database dengan perintah berikut:

   ```bash
   php artisan migrate --seed
   ```

8. Jalankan server pengembangan Laravel

   ```bash
   php artisan serve
   ```
