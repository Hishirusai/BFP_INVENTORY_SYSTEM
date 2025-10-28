# BFP Inventory System

## Installation Steps

1. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Set up Environment File**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Then update the `.env` file with your database credentials

3. **Run Database Migrations**
   ```bash
   php artisan migrate
   ```

4. **Start the Development Server**
   In one terminal:
   ```bash
   php artisan serve
   ```
   
   In another terminal:
   ```bash
   npm run dev
   ```

5. **Access the Application**
   Open your browser and go to `http://localhost:8000`

That's it! The application should now be running locally.
